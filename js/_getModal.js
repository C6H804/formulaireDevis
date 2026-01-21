import { CreateElement } from "./components/__CreateElement.js";
export const getModal = async (id, type) => {
    closeModal();
    // loadModal from components/page/formBody
    // content = {type: "ral", id= id}
    if (type !== "ral") preloadModal(id);
    try {
        const response = await fetch("components/page/formBody.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: `loadModal=${encodeURIComponent(JSON.stringify({ type: type, id: id }))}`,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.text();
        // console.log("Modal fetched:", result);
        // récupère un json avec de la donnée
        if (type === "ral") {
            return result;
        } else {
            console.log("json data", JSON.parse(result));
            return result;
        }
    } catch (error) {
        console.error('Error fetching modal:', error);
        throw error;
    }
}



const preloadModal = (id) => {
    document.body.style.overflow = 'hidden';
    const closeButton = CreateElement("div", { class: "closeModal" }, ["×"]);

    const modalHtml = CreateElement("div", { class: "modal modalDevis", id: "modalModel" + id }, [
        CreateElement("div", { class: "modalContent" }, [
            CreateElement("div", { class: "modalHeader" }, [
                CreateElement("div", { class: "modalTitle" }, [
                    CreateElement("h2", {}, ["Sélectionner un modèle"])
                ]),
                closeButton,
                CreateElement("div", { class: "filterContainer" })
            ]),
            CreateElement("div", { class: "modal-body", id: "modalBodyModel" + id }, [
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