<?php

function addClotureBeton($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Clôture en béton</h3>

    <div class="section sectionClotureBeton sectionClotureBetonModel"> <!-- modèle de clôture béton -->
        <div class="inputField">
            <?php echo modelSelector($id, "clotureBeton"); ?>
        </div>
    </div>

    <div class="section sectionClotureBeton"> <!-- dimensions longueur et hauteur -->
        <div class="inputField">
            <label for="dimensionLongueur<?php echo $id ?>">Longueur (en mètre linéaire) :</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="dimensionLongueur<?php echo $id ?>"
                placeholder="Exemple 12,5 mètres">
        </div>
        <div class="inputField">
            <label for="dimensionHauteur<?php echo $id ?>">Hauteur (en cm) :</label>
            <input type="text" name="dimensionHauteur<?php echo $id ?>" id="dimensionHauteur<?php echo $id ?>"
                placeholder="Exemple 125 cm">
        </div>
    </div>



    <?php
    return ob_get_clean();
}

?>