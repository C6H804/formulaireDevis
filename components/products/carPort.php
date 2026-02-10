<?php
function addCarport($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Carport</h3>

    <div class="section sectionCarport"> <!-- dimensions -->
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

    <div class="section sectionCarport" id="radioToClear<?php echo $id; ?>"> <!-- couleur standard -->
        <?php ralStandard($id); ?>
    </div>

    <div class="section sectionCarport"> <!-- autre couleur -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

        <div class="section sectionCarport"> <!-- finition Mat, brillant, sablé -->
        <div class="inputField">
            <label for="<?php echo "finition$id"; ?>">Finition :</label>
            <select name="finition<?php echo $id ?>" id="<?php echo "finition$id"; ?>">
                <option value="Sablé">Sablé</option>
                <option value="Mât">Mât</option>
                <option value="Brillant">Brillant</option>
            </select>
        </div>
    </div>

    <div class="section sectionCarport"> <!-- options -->
        <div class="inputField">
            <label for="">Options :</label>
            <select name="options<?php echo $id ?>" >
                <option value="Aucune">Aucune</option>
                <option value="LED">LED</option>
            </select>
        </div>
    </div>


    <?php
    return ob_get_clean();
}
?>