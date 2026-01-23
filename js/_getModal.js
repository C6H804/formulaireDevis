import { CreateElement } from "./components/__CreateElement.js";
export const getModal = async (id, type, modalType = "Model") => {
    closeModal();
    // loadModal from components/page/formBody
    // content = {type: "ral", id= id}
    if (type !== "ral") preloadModal(id, modalType);
    if (type === "project") {
        return projectType;
    }
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




