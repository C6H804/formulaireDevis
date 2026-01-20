<?php
function modelPortailBattantsModal($id)
{

    $modelList = getModel("portails_battants");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}


function modelPortailCoulissantModal($id)
{
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
                $modelList = getModel("portails_coulissants");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"coulissant-\")'>
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

function modelPortillonModal($id)
{
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
                $modelList = getModel("portillons");
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


function modelClotureBeton($id)
{
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
                $modelList = getModel("clotures_beton");
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


function modelClotureAluminiumModal($id) {
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
                $modelList = getModel("clotures_aluminium");
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

function modelPorteGarageBasculanteModal($id) {
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
                $modelList = getModel("portes_garages_basculantes");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"basculante-\")'>
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

function modelPorteGarageBattanteModal($id) {
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
                $modelList = getModel("portes_garages_battantes");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"battante-\")'>
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

function modelPorteGarageSectionnableModal($id) {
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
                $modelList = getModel("portes_garages_sectionnelles");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"sectionnable-\")'>
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

function modelPorteGarageEnroulableModal($id) {
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
                $modelList = getModel("portes_garages_enroullements");
                foreach ($modelList as $model) {
                    $modelName = $model['reference_code'];
                    $modelImage = $model['image_url'];
                    $modelNameJS = json_encode($modelName);
                    $modelImageJS = json_encode($modelImage);
                    echo "<div class='modelItem' onclick='selectModel($id, $modelNameJS, $modelImageJS, \"enroulable-\")'>
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