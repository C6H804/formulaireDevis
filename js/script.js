import { addProject } from './components/_AddProject.js';
import { changeProject } from './components/_ChangeProject.js';
import { getModal } from './_getModal.js';
import { CreateElement } from './components/__CreateElement.js';
window.projectType = [
    "Portail",
    "Portillon",
    "Clôture rigide",
    "Clôture Béton",
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

const init = async () => {

    console.log("Script loaded");
    document.getElementById('addProjectBtn').addEventListener('click', () => {
        addProject(projectType[0]);
        console.log(window.projectList);
    });

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
            if (projectIds === '' || window.projectList.length === 0) {
                e.preventDefault();
                alert('Veuillez ajouter au moins un projet avant de soumettre le formulaire.');
                return false;
            }
        });
    }

    await addProject(projectType[0]);
    console.log("Premier projet ajouté, projectIds =", document.getElementById('projectIds')?.value);
};

window.changeProjectType = async (id = "") => {
    console.log("Changing project type for ID:", id);
    const value = document.getElementById("selectProject" + id).value;
    const target = document.querySelectorAll("#project" + id + " .projectBody")[0];
    projectList.forEach(e => {
        if (e.id == id) e.type = value;
    });
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
        },
        "Basculante": {
            on: [".basculante"],
            off: [".battante", ".sectionnable", ".enroulable"]
        },
        "Enroulable": {
            on: [".enroulable"],
            off: [".battante", ".sectionnable", ".basculante"]
        },
        "Sectionnable": {
            on: [".sectionnable"],
            off: [".battante", ".enroulable", ".basculante"]
        },
        "Battante": {
            on: [".battante"],
            off: [".sectionnable", ".enroulable", ".basculante"]
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

window.deleteProject = (id) => {
    if (projectList.length <= 1) return;
    projectList = projectList.filter(e => e.id != id);
    document.getElementById("project" + id).remove();

    // Mettre à jour le champ caché avec les IDs des projets
    const projectIds = window.projectList.map(p => p.id).join(',');
    document.getElementById('projectIds').value = projectIds;
}

window.modalRalOpen = async (id, uncheckAll = "", color, name = "") => {
    const modalHtml = await getModal(id, "ral");
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    const modalRal = document.getElementById("modalRal" + id);
    modalRal.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal') || e.target.classList.contains('closeModalBtn')) {
            closeModal();
        }
    });
    document.body.style.overflow = 'hidden';
}

window.closeModal = () => {
    document.querySelectorAll(".modal").forEach(e => {
        e.remove();
    });
    document.body.style.overflow = '';
}

window.selectRal = (id, ralCode, un = "", color = "", name = "") => {
    const select = document.getElementById("ralSelect" + id);
    select.value = ralCode;
    uncheckAll(un);
    const output = document.getElementById("ralOutput" + id);
    output.innerText = name + " (" + ralCode + ")";
    const outputSample = document.getElementById("ralColor" + id);
    outputSample.style.backgroundColor = "#" + color;
    closeModal();
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
            CreateElement("div", { class: "modelImageContainer"}, [CreateElement("img", { src: model.image_url, alt: model.nom, class: "modelImage" })]),
            CreateElement("div", { class: "modelName" }, [model.nom])
        ]);
        target.appendChild(modelItem);
    });
}




window.selectModel = (id, modelName, modelImg, outputIdPrefix = "") => {
    
    projectType = document.getElementById("selectProject" + id).value;
    
    // Déterminer le préfixe en fonction du type de projet
    if (projectType === "Portail") {
        outputIdPrefix = document.getElementById("typePortail" + id).value === "Battant" ? "battant-" : "coulissant-";
    } else if (projectType === "Porte de garage") {
        const typePorteGarage = document.getElementById("typePorteGarage" + id).value.toLowerCase();
        outputIdPrefix = typePorteGarage + "-";
    }

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
    const projectImgFolder = "/img/projects/";

    data.forEach(p => {
        const projectItem = CreateElement("div", { class: "projectItem" }, [
            CreateElement("div", { class: "projectItemContent" }, [
                CreateElement("img", { class: "projectImg", src: projectImgFolder + p.id + ".svg", alt: p.id }),
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



window.preloadModal = (id, modalType) => {
    document.body.style.overflow = 'hidden';
    const closeButton = CreateElement("div", { class: "closeModal" }, ["×"]);
    const name = modalType === "Model" ? "modèle" : modalType === "Project" ? "projet" : modalType;

    const modalHtml = CreateElement("div", { class: "modal modalDevis modal" + modalType, id: "modal" + modalType + id }, [
        CreateElement("div", { class: "modalContent" }, [
            CreateElement("div", { class: "modalHeader" }, [
                CreateElement("div", { class: "modal-title" }, [
                    CreateElement("h2", {}, ["Choisir un " + name])
                ]),
                closeButton,
                CreateElement("div", { class: "filterContainer" })
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

    document.body.appendChild(modalHtml);
}