<?php
function addClotureAluminium($id)
{
    ob_start();
    ?>
    <h3>Clôture en aluminium</h3>

    <div class="section sectionClotureAluminium"> <!-- modèle de clôture aluminium -->
        <div class="inputField">
            <?php echo modelSelector($id, 'clotureAluminium'); ?>
        </div>
    </div>

    <div class="section sectionClotureAluminium" id="radioToClear<?php echo $id; ?>"> <!-- choix couleur ral standard-->
        <?php ralStandard($id); ?>
    </div>

    <div class="section sectionClotureAluminium"> <!-- autre couleur -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

    <div class="section sectionClotureAluminium"> <!-- finition Mat, brillant, sablé -->
        <div class="inputField">
            <label for="<?php echo "finition$id"; ?>">Finition :</label>
            <select name="finition<?php echo $id ?>" id="<?php echo "finition$id"; ?>">
                <option value="Brillant">Brillant</option>
                <option value="Mât">Mât</option>
                <option value="Sablé">Sablé</option>
            </select>
        </div>
    </div>

    <div class="section sectionClotureAluminium"> <!-- dimensions longueur et hauteur -->
        <div class="inputField">
            <label for="dimensionLongueur<?php echo $id ?>">Longueur (en mètre linéaire) :</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="dimensionLongueur<?php echo $id ?>"
                placeholder="Exemple 12,5 mètres">
        </div>
        <div class="inputField">
            <label for="dimensionHauteur<?php echo $id ?>">Hauteur (en cm) :</label>
            <input type="text" name="dimensionHauteur<?php echo $id ?>" id="dimensionHauteur<?php echo $id ?>" placeholder="Exemple 125 cm">
        </div>
    </div>

    <?php
    return ob_get_clean();
}
?>