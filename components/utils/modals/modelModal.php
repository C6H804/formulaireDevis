<?php
function modelPortailBattantsModal($id)
{

    $modelList = getModel("portails_battants");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}


function modelPortailCoulissantModal($id)
{
    $modelList = getModel("portails_coulissants");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function modelPortillonModal($id)
{
    $modelList = getModel("portillons");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}


function modelClotureBeton($id)
{
   $modelList = getModel("clotures_beton");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}


function modelClotureAluminiumModal($id) {
    $modelList = getModel("clotures_aluminium");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

function modelPorteGarageModal($id) {
    $modelList = getModel("portes_garage");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

function modelStoreModal($id) {
    ob_start();
    ?>
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
                $modelList = getModel("stores");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS)'>
                        <img src='$modelImage' alt='$modelName' class='modelImage'/>
                        <div class='modelName'>$modelName</div>
                        </div>";
                }
                ?>
            </div>
            <div class='modal-footer'></div>
        </div>
    </div>

    <?php
    return ob_get_clean();

}
?>