<?php
function addPergola($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Pergola</h3>

    <div class="section sectionPergola"> <!-- dimension largeur hauteur longueur -->
        <div class="inputField">
            <label for="dimensionLargeur<?php echo $id ?>">Dimension largeur (en cm) :</label>
            <input type="text" name="dimensionLargeur<?php echo $id ?>" id="dimensionLargeur<?php echo $id ?>"
                placeholder="Exemple 120 cm">
        </div>

        <div class="inputField">

            <label for="dimensionHauteur<?php echo $id ?>">Dimension Hauteur (en cm) :</label>
            <input type="text" name="dimensionHauteur<?php echo $id ?>" id="dimensionHauteur<?php echo $id ?>"
                placeholder="Exemple 120 cm">
        </div>

        <div class="inputField">
            <label for="dimensionLongueur<?php echo $id ?>">Dimension Longueur (en cm) :</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="dimensionLongueur<?php echo $id ?>"
                placeholder="Exemple 120 cm">
        </div>
    </div>

    <div class="section sectionPergola"> <!-- options -->
        <div class="inputField">
            <h3>Options :</h3>
            <!-- <select name="options<?php echo $id ?>">
                <option value="Aucune">Aucune</option>
                <option value="LED">LED</option>
                <option value="Store verticaux">Store verticaux</option>
                <option value="chauffage">chauffage</option>
                <option value="parois vitrées">parois vitrées</option>
            </select> -->
            <div>
                <label for="optionsLED<?php echo $id ?>">LED</label>
                <input type="checkbox" name="optionsLED<?php echo $id ?>" id="optionsLED<?php echo $id ?>">
            </div>
            <div>
                <label for="optionsStoreVerticaux<?php echo $id ?>">Store verticaux</label>
                <input type="checkbox" name="optionsStoreVerticaux<?php echo $id ?>" id="optionsStoreVerticaux<?php echo $id ?>">
            </div>
            <div>
                <label for="optionsChauffage<?php echo $id ?>">chauffage</label>
                <input type="checkbox" name="optionsChauffage<?php echo $id ?>" id="optionsChauffage<?php echo $id ?>">
            </div>
            <div>
                <label for="optionsParoisVitrees<?php echo $id ?>">parois vitrées</label>
                <input type="checkbox" name="optionsParoisVitrees<?php echo $id ?>" id="optionsParoisVitrees<?php echo $id ?>">
            </div>
        </div>
    </div>


    <?php
    return ob_get_clean();
}
?>