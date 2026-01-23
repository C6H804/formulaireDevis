<?php
function addPortillon($id)
{
    ob_start();
    ?>

    <h3 class="productTitle">Portillon</h3>

    <div class="section sectionPortillon sectionPortillonModel"> <!-- modèle de portillon -->
        <div class="inputField">
            <?php echo modelSelector($id, 'portillon'); ?>
        </div>
    </div>

    <div class="section sectionPortillon" id="radioToClear<?php echo $id; ?>"> <!-- choix couleur ral standard-->
        <?php ralStandard($id); ?>
    </div>


    <div class="section sectionPortillon"> <!-- autre couleur -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

    <div class="section sectionPortillon"> <!-- finition Mat, brillant, sablé -->
        <div class="inputField">
            <label for="<?php echo "finition$id"; ?>">Finition :</label>
            <select name="finition<?php echo $id ?>" id="<?php echo "finition$id"; ?>">
                <option value="Brillant">Brillant</option>
                <option value="Mât">Mât</option>
                <option value="Sablé">Sablé</option>
            </select>
        </div>
    </div>


    <div class="section sectionPortillon"> <!-- dimensions entre Poteaux et hauteur -->
        <div class="inputField">
            <label for="<?php echo "dimensionLongueur$id"; ?>">Dimension entre Poteaux (en cm)</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="<?php echo "dimensionLongueur$id"; ?>"
                placeholder="Exemple : 250 cm" />
        </div>
        <div class="inputField">
            <label for="<?php echo "dimensionHauteur$id"; ?>">Dimension Hauteur du portail (en cm)</label>
            <input type="text" name="dimensionHauteur<?php echo $id ?>"
                id="<?php echo "dimensionHauteur$id"; ?>" placeholder="Exemple : 200 cm" />
        </div>
    </div>



    <?php
    return ob_get_clean();
}
?>