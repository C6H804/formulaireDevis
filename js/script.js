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

const init = () => {

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

    addProject(projectType[0]);
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
}

window.closeModal = () => {
    document.querySelectorAll(".modal").forEach(e => {
        e.remove();
    });
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
    modalmodel.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal') || e.target.classList.contains('closeModalBtn')) {
            closeModal();
        }
    });
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
            CreateElement("img", { src: model.image_url, alt: model.nom, class: "modelImage" }),
            CreateElement("div", { class: "modelName" }, [model.nom])
        ]);
        target.appendChild(modelItem);
    });
}




window.selectModel = (id, modelName, modelImg, outputIdPrefix = "") => {

    const select = document.getElementById(outputIdPrefix + "modelSelect" + id);
    if (!select) {
        console.error("Élément non trouvé :", outputIdPrefix + "modelSelect" + id);
        return;
    }
    select.value = modelName;

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