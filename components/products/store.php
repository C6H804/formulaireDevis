<?php
function addStore($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Store</h3>
    <div class="section sectionStore"> <!-- modèle de store -->
        <div class="inputField">
            <?php echo modelSelector($id, 'store'); ?>
        </div>
    </div>

    <div class="section sectionStore" id="radioToClear<?php echo $id; ?>"> <!-- choix couleur ral standard-->
        <?php ralStandard($id); ?>
    </div>

    <div class="section sectionStore"> <!-- autre couleur -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

    <div class="section sectionStore"> <!-- dimension store -->
        <div class="inputField">
            <label for="dimensionLargeur<?php echo $id ?>">Dimension largeur (en mètres) :</label>
            <input type="text" name="dimensionLargeur<?php echo $id ?>" id="dimensionLargeur<?php echo $id ?>"
                placeholder="Exemple 2.5 m" max="7">
        </div>

        <div class="inputField">
            <label for="projection<?php echo $id ?>">Projection (en mètres) :</label>
            <input type="text" name="projection<?php echo $id ?>" id="projection<?php echo $id ?>"
                placeholder="Exemple 1.5 m" max="4">
        </div>
        <div class="inputField">
            <label for="">Toile verticale :</label>
            <select name="toileVerticale<?php echo $id ?>" id="toileVerticale<?php echo $id ?>">
                <option value="non">Non</option>
                <option value="oui">Oui</option>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
?>