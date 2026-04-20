import { addProject } from './components/_AddProject.js';
import { changeProject } from './components/_ChangeProject.js';
import { getModal } from './_getModal.js';
window.projectType = [
    "Portail",
    "Portillon",
    "Clôture rigide",
    "Clôture béton",
    "Clôture aluminium",
    "Porte de garage",
    "Store",
    "Pergola",
    "Carport",
    "Fournitures",
    "Maçonnerie",
    "Autre"
];
window.projectList = [];

let ralColors = [];

const init = async () => {

    console.log("Script loaded");
    document.getElementById('addProjectBtn').addEventListener('click', async (e) => {
        e.preventDefault();
        addProjectModal();
    });


    window.addProjectModal = async () => {
        preloadModal("adding", "Project");
        // const data = getProjectList(id);
        const data = window.projectType;
        const target = document.getElementById("modalBodyProjectadding");
        // const target = document.getElementById("modalBodyProject" + id);
        target.innerHTML = "";
        const projectImgFolder = "./img/projects/";

        data.forEach(p => {
            const projectItem = CreateElement("div", { class: "projectItem" }, [
                CreateElement("div", { class: "projectItemContent" }, [
                    CreateElement("img", { class: "projectImg", src: projectImgFolder + p.normalize('NFD').replace(/[\u0300-\u036f]/g, '') + ".png", alt: p }),
                    CreateElement("div", { class: "projectName" }, [p])
                ])
            ]);
            projectItem.addEventListener('click', async () => {
                const projectType = p;
                closeModal();
                await addProject(projectType);
            });
            target.appendChild(projectItem);
        });
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") {
            closeModal();
        }
    });

    // Écouter la soumission du formulaire pour s'assurer que projectIds est à jour
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            // Mettre à jour projectIds une dernière fois avant soumission
            const projectIds = window.projectList.map(p => p.id).join(',');
            document.getElementById('projectIds').value = projectIds;
            console.log('Soumission du formulaire, projectIds:', projectIds);

            // Vérifier qu'il y a au moins un projet
            if (projectIds === '' && (window.projectList.length === 0 && document.getElementById("moreInfo").value.trim() === "")) {
                cancelSubmit(e, "Veuillez ajouter au moins un projet avant de soumettre le formulaire.");
                return false;
            } else {
                const firstName = form.surname.value.trim();
                const lastName = form.name.value.trim();

                const phone = form.phone.value.trim();
                const email = form.email.value.trim();

                if (firstName === "" || lastName === "" || (email === "" && phone === "")) {
                    cancelSubmit(e, "Veuillez remplir tous les champs obligatoires (Prénom, Nom, et au moins un moyen de contact).", true);
                    return false;
                }
                if (phone !== "" && !/^[0-9+\s()-]{6,20}$/.test(phone) && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    cancelSubmit(e, "Veuillez entrer un numéro de téléphone valide ou une adresse e-mail valide.", true);
                    return false;
                }
            }
        });
    }
};

function cancelSubmit(e, message = "Erreur inconnue, veuillez réessayer.", scroll = false) {
    e.preventDefault();
    alert(message);
    if (scroll) {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

const ifFormValid = () => {
    const form = document.getElementById('devisForm');
    // form.firstName.value = form.firstName.value.trim();
    alert.log(form.firstName.value);
    return false;
    const lastName = document.getElementById("lastName").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();

    // if (firstName === "" || lastName === "" || (email === "" && phone === "")) {
    //     return false;
    // }
    // return /^[0-9+\s()-]{6,20}$/.test(phone) || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

window.changeProjectType = async (id = "") => {
    console.log("Changing project type for ID:", id);
    const value = document.getElementById("selectProject" + id).value;
    const target = document.querySelectorAll("#project" + id + " .projectBody")[0];
    projectList.forEach(e => {
        if (e.id == id) e.type = value;
    });
    target.innerHTML = "";
    target.appendChild(CreateElement("div", { class: "loader" }, [
        CreateElement("img", { src: "/img/loader.svg", alt: "Chargement..." })
    ]));
    const result = await changeProject(id, value);
    target.innerHTML = result;
}

window.changeDisplaySection = (id, self) => {
    const sections = {
        "Coulissant": {
            on: [".directionCoulissantSection", ".modelCoulissant"],
            off: [".modelBattant"]
        },
        "Battant": {
            on: [".modelBattant"],
            off: [".directionCoulissantSection", ".modelCoulissant"]
        }
    }
    const value = document.getElementById(self + id).value;

    const toShow = sections[value]?.on || [];
    const toHide = sections[value]?.off || [];
    toShow.forEach(e => {
        document.querySelectorAll("#project" + id + " " + e).forEach(el => {
            el.classList.remove("hidden");
        });
    });
    toHide.forEach(e => {
        document.querySelectorAll("#project" + id + " " + e).forEach(el => {
            el.classList.add("hidden");
        });
    });
}

window.deleteProject = async (id) => {
    if (projectList.length > 0) {
        changeProjectDisplay(1);
        
        projectList = projectList.filter(e => e.id != id);
        const pToDelete = document.getElementById("project" + id);

        await pToDelete.scrollIntoView({ behavior: 'smooth', block: 'end' });


        const projectIds = window.projectList.map(p => p.id).join(',');
        const pHeight = pToDelete.offsetHeight;
        pToDelete.style.setProperty('--project-height', pHeight + 'px');
        document.getElementById('projectIds').value = projectIds;

        pToDelete.addEventListener("animationend", () => {
            pToDelete.remove();
        });

        if (!pToDelete.classList.contains("projectDelete")) {
            pToDelete.classList.add("projectDelete");
        }
    }

}




window.modalRalOpen = async (id, uncheckAll = "", color, name = "") => {
    const modalHtml = await getModal(id, "ral", "Ral");

    const target = document.getElementById("modalBodyRal" + id);
    // console.log("Modal HTML for RAL:", modalHtml);
    ralColors = JSON.parse(modalHtml);

    // target.innerHTML = modalHtml;
    target.innerHTML = "";
    fillRalModal(id, ralColors, target);

    // document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modalRal = document.getElementById("modalRal" + id);
    modalRal.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal') || e.target.classList.contains('closeModalBtn')) {
            closeModal();
        }
    });

    document.body.style.overflow = 'hidden';
}

const fillRalModal = (id, colors, target, search = "") => {
    let ammount = 0;
    colors.forEach(color => {
        if (color.name_fr.toLowerCase().includes(search.toLowerCase()) || color.order.toLowerCase().startsWith(search.toLowerCase())) {
            target.appendChild(addRalToModal(id, color));
            ammount++;
        }
    });
    if (ammount === 0) {
        target.innerHTML = "<p class='noResult'>Aucun résultat trouvé pour \"" + search + "\"</p>";
    }
}


const addRalToModal = (id, color) => {
    const e = CreateElement("div", { class: "colorItem" }, [
        CreateElement("span", { class: "colorSample", style: `background-color: #${color.color}` }),
        CreateElement("div", { class: "colorName" }, [color.name_fr]),
        CreateElement("div", { class: "colorRal" }, [color.value])
    ]);
    e.addEventListener('click', () => {
        selectRal(id, color.order, "#radioToClear" + id, color.color, color.name_fr);
    });
    return e;
}


window.closeModal = () => {
    document.querySelectorAll(".modal").forEach(e => {
        e.classList.add("modalClose");
        e.addEventListener("animationend", () => {
            e.remove();
        });
    });
    document.body.style.overflow = '';
}

window.selectRal = (id, ralCode, un = "", color = "", name = "", clear = false) => {
    const select = document.getElementById("ralSelect" + id);
    if (!clear) {
        select.value = ralCode;
        uncheckAll(un);
        const output = document.getElementById("ralOutput" + id);
        output.innerText = name + " (" + ralCode + ")";
        const outputSample = document.getElementById("ralColor" + id);
        outputSample.style.backgroundColor = "#" + color;
        closeModal();
    } else {
        select.value = "";
        const output = document.getElementById("ralOutput" + id);
        output.innerText = "";
        const outputSample = document.getElementById("ralColor" + id);
        outputSample.style.backgroundColor = "transparent";
        closeModal();
    }
}


const uncheckAll = (containerId) => {
    document.querySelectorAll(containerId + " input[type='checkbox'], " + containerId + " input[type='radio']").forEach(input => {
        input.checked = false;
    });
};

init();

window.modalModel = async (id, type) => {
    const models = JSON.parse(await getModal(id, type));
    renderModelStyle(Object.keys(models), id, models);
    const modalmodel = document.getElementById("modalModel" + id);
}


const renderModelStyle = (styles, id, data) => {
    const target = document.querySelectorAll(`#modalModel${id} .filterContainer`)[0];
    console.log("Rendering styles:", styles, "for modalModel" + id);
    styles.forEach(style => {
        const button = CreateElement("button", { class: "filterButton" }, [style]);
        button.addEventListener('click', () => changeModelFilter(id, style, data));
        target.appendChild(button);
    });
    changeModelFilter(id, styles[0], data);
}

window.changeModelFilter = (id, style, data) => {
    console.log("Changing model filter to:", style, "for modalModel" + id);
    document.querySelectorAll(`#modalModel${id} .filterButton`).forEach(button => {
        button.classList.remove("active");
        if (button.innerText === style) {
            button.classList.add("active");
        }
    });
    loadModels(id, style, data);
}


window.loadModels = (id, style, data) => {
    const target = document.getElementById("modalBodyModel" + id);
    target.innerHTML = "";
    data[style].forEach(model => {
        const modelItem = CreateElement("div", { class: "modelItem", onClick: `selectModel(${id}, '${model.nom}', '${model.image_url}')` }, [
            CreateElement("div", { class: "modelImageContainer" }, [CreateElement("img", { src: model.image_url, alt: model.nom, class: "modelImage center" })]),
            CreateElement("div", { class: "modelName" }, [model.nom])
        ]);
        target.appendChild(modelItem);
    });
}


window.selectModel = (id, modelName, modelImg, outputIdPrefix = "") => {
    const pt = document.getElementById("selectProject" + id).value;

    // Déterminer le préfixe en fonction du type de projet
    if (pt === "Portail") {
        outputIdPrefix = document.getElementById("typePortail" + id).value === "Battant" ? "battant-" : "coulissant-";
    }
    // else if (projectType === "Porte de garage") {
    //     const typePorteGarage = document.getElementById("typePorteGarage" + id).value.toLowerCase();
    //     outputIdPrefix = typePorteGarage + "-";
    // }

    // Mise à jour du champ caché avec le nom du modèle
    const select = document.getElementById(outputIdPrefix + "modelSelect" + id);
    if (select) {
        select.value = modelName;
        console.log("Modèle sélectionné:", outputIdPrefix + "modelSelect" + id, "=", modelName);
    } else {
        console.error("Élément non trouvé :", outputIdPrefix + "modelSelect" + id);
    }

    const output = document.getElementById(outputIdPrefix + "modelOutput" + id);
    if (output) {
        output.innerText = modelName;
    } else {
        console.warn("Output non trouvé :", outputIdPrefix + "modelOutput" + id);
    }

    console.log("modelImg:", modelImg);
    const outputSample = document.getElementById(outputIdPrefix + "modelImage" + id);
    if (outputSample) {
        outputSample.innerHTML = `<img src="${modelImg}" alt="${modelName}" />`;
    } else {
        console.warn("OutputSample non trouvé :", outputIdPrefix + "modelImage" + id);
    }

    closeModal();
}


window.openModalProject = async (id) => {
    preloadModal(id, "Project");
    const data = getProjectList(id);
    console.log(data);
    const target = document.getElementById("modalBodyProject" + id);
    target.innerHTML = "";
    const projectImgFolder = "./img/projects/";

    data.forEach(p => {
        const projectItem = CreateElement("div", { class: "projectItem" }, [
            CreateElement("div", { class: "projectItemContent" }, [
                CreateElement("img", { class: "projectImg", src: projectImgFolder + p.id.normalize('NFD').replace(/[\u0300-\u036f]/g, '') + ".png", alt: p.id }),
                CreateElement("div", { class: "projectName" }, [p.name])
            ])
        ]);
        projectItem.addEventListener('click', () => {
            const s = document.getElementById("selectProject" + id);
            console.log("Project selected:", p);
            s.value = p.id;
            console.log(s.name);

            changeProjectType(id);
            closeModal();
        });
        target.appendChild(projectItem);
    });
}


const getProjectList = (id) => {
    const options = document.querySelectorAll(`#selectProject${id} option`);
    let projectList = [];
    options.forEach(option => {
        projectList.push({
            id: option.value,
            name: option.textContent
        });
    });
    return projectList;
}

window.changeRalSearch = (id) => {
    // alert("Recherche RAL : " + document.getElementById("ralSearch" + id).value);
    document.getElementById("modalBodyRal" + id).innerHTML = "";
    fillRalModal(id, ralColors, document.getElementById("modalBodyRal" + id), document.getElementById("ralSearch" + id).value);
}
window.clearRalSearch = (id) => {
    document.getElementById("ralSearch" + id).value = "";
    changeRalSearch(id);
}


window.preloadModal = (id = null, modalType) => {
    document.body.style.overflow = 'hidden';
    const target = document.getElementById("formulaireDevis");
    const closeButton = CreateElement("div", { class: "closeModal" }, ["×"]);
    const title = modalType === "Model" ? "Choisir un modèle" : modalType === "Project" ? "Choisir un projet" : "Choisir une couleur";
    let searchContainer = null;
    if (modalType === "Ral") {
        searchContainer = CreateElement("div", { class: "searchContainer" }, [
            CreateElement("div", { class: "searchArea" }, [
                CreateElement("input", { type: "text", placeholder: "Rechercher par nom ou code RAL...", id: "ralSearch" + id, onInput: `changeRalSearch(${id})`, class: "ralSearchInput" }),
                CreateElement("button", { type: "span", class: "ralClearButton", onClick: `clearRalSearch(${id})` }, ["×"])
            ])
        ]);
    }


    const modalHtml = CreateElement("div", { class: "modal modalDevis modal" + modalType, id: "modal" + modalType + id }, [
        CreateElement("div", { class: "modalContent" }, [
            CreateElement("div", { class: "modalHeader" }, [
                CreateElement("div", { class: "modal-title" }, [
                    CreateElement("h2", {}, [title])
                ]),
                closeButton,
                modalType === "Model" ? CreateElement("div", { class: "filterContainer" }) : null,
                modalType === "Ral" ? searchContainer : null
            ]),
            CreateElement("div", { class: "modal-body", id: "modalBody" + modalType + id }, [
                CreateElement("div", { class: "loader" }, [
                    CreateElement("img", { src: "/img/loader.svg", alt: "Chargement..." })
                ])
            ])
        ])
    ]);

    modalHtml.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal') || e.target.classList.contains('closeModalBtn')) {
            closeModal();
        }
    });
    closeButton.addEventListener('click', () => closeModal());

    target.appendChild(modalHtml);
}

window.changeImage = () => {
    const input = document.getElementById("projectFile");
    const btn = document.querySelectorAll("label[for='projectFile']")[0];
    const file = input.files[0];

    const container = document.querySelectorAll(".imgPreview")[0];
    const imgNameDisplay = document.getElementById("imgName");
    const imgDisplay = document.getElementById("imgDisplayPreview");

    if (input.files.length > 0) {
        container.classList.remove("hidden");
        btn.innerText = "Choisir une autre image";
        const reader = new FileReader();

        imgNameDisplay.innerText = file.name;
        imgDisplay.alt = file.name;
        reader.onload = (e) => {
            imgDisplay.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        container.classList.add("hidden");
        btn.innerText = "Nous transmettre une image";
        imgNameDisplay.innerText = "";
        imgDisplay.src = "";
        imgDisplay.alt = "Aucune image envoyée";
    }
}


const getProjectsData = () => {
    const data = document.getElementById("projectIds");
    if (data) return data.value.split(",").length;
    return 0;
}

window.changeProjectDisplay = (deleted = 0) => {
    const quantity = getProjectsData() - deleted;
    const target = projectsFieldTitle;
    switch (true) {
        case quantity <= 0:
            target.innerText = "Il n'y a aucun produit dans votre devis";
            break;
        case quantity === 1:
            target.innerText = `Vous avez ${quantity} produit dans votre devis`;
            break;
        default:
            target.innerText = `Vous avez ${quantity} produits dans votre devis`;
            break;
    }
}


window.addProjectPortillon = async () => {
    await addProject("Portillon");
}


window.removeImage = () => {
    const target = document.querySelectorAll(".imgPreview")[0];
    target.classList.add("deleting");

    target.addEventListener("animationend", () => {
        if (target.classList.contains("deleting")) {
            const input = document.getElementById("projectFile");
            input.value = "";
            changeImage();
            target.classList.remove("deleting");
        }
    });
}