<?php
function addPergola($id)
{
    ob_start();
    ?>
    <h3>Pergola</h3>

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
            <label for="">Options :</label>
            <select name="options<?php echo $id ?>">
                <option value="Aucune">Aucune</option>
                <option value="LED">LED</option>
                <option value="Store verticaux">Store verticaux</option>
                <option value="chauffage">chauffage</option>
                <option value="parois vitrées">parois vitrées</option>
            </select>
        </div>
    </div>


    <?php
    return ob_get_clean();
}
?>