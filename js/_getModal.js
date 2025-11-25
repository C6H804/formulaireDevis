export const getModal = async (id, type) => {
    closeModal();
    // loadModal from components/page/formBody
    // content = {type: "ral", id= id}
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
        return result;
    } catch (error) {
        console.error('Error fetching modal:', error);
        throw error;
    }
}