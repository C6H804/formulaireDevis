<?php
function addPorteGarage($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Porte de garage</h3>

    <div class="section sectionPorteGarage"> <!-- modèle porte garage -->
        <div class="inputField">
            <?php echo modelSelector($id, "porteGarage"); ?>
        </div>
    </div>


    <div class="section sectionPorteGarage" id="radioToClear<?php echo $id; ?>">
        <!-- couleur porte de garage -->
        <?php ralStandard($id); ?>
    </div>


    <div class="section sectionPorteGarage"> <!-- couleur porte de garage ral selector -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
?>