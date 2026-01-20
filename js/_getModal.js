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
        // console.log("Modal fetched:", result);
        // récupère un json avec de la donnée
        console.log("json data", JSON.parse(result));
        return result;
    } catch (error) {
        console.error('Error fetching modal:', error);
        throw error;
    }
}


/*
    <div class='modal modalDevis' id='modalModel<?php echo $id ?>'>
        <div class='modalContent'>
            <div class='modalHeader'>
                <div class='modal-title'>
                    <h2>Choisir un modèle</h2>
                </div>
                <span class='closeModal' onclick='closeModal()'>&times;</span>
            </div>
            <div class='modal-body'>
                <?php
                $modelList = getModel("portails_battants");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"battant-\")'>
                        <img src='$modelImage' alt='$modelName' class='modelImage'/>
                        <div class='modelName'>$modelName</div>
                        </div>";
                }
                ?>
            </div>
            <div class='modal-footer'></div>
        </div>
    </div>
*/