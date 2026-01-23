<?php
function addPorteGarage($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Porte de garage</h3>

    <div class="section sectionPorteGarage"> <!-- type de porte de garage -->
        <div class="inputField">
            <label for="typePorteGarage<?php echo $id; ?>">Type de porte de garage :</label>
            <select name="typePorteGarage<?php echo $id; ?>" id="typePorteGarage<?php echo $id; ?>"
                onchange="changeDisplaySection(<?php echo $id; ?>, 'typePorteGarage')">
                <option value="Basculante">Basculante</option>
                <option value="Battante">Battante</option>
                <option value="Sectionnable">Sectionnable</option>
                <option value="Enroulable">Enroulable</option>
            </select>
        </div>
    </div>

    <div class="section sectionPorteGarage basculante"> <!-- modèle porte garage basculante -->
        <div class="inputField">
            porteGarageBasculante
            <?php echo modelSelector($id, "porteGarageBasculante", "basculante-"); ?>
        </div>
    </div>

    <div class="section sectionPorteGarage hidden battante"> <!-- modèle porte garage battante -->
        <div class="inputField">
            porteGarageBattante
            <?php echo modelSelector($id, "porteGarageBattante", "battante-"); ?>
        </div>
    </div>

    <div class="section sectionPorteGarage hidden sectionnable"> <!-- modèle porte garage sectionnable -->
        <div class="inputField">
            porteGarageSectionnable
            <?php echo modelSelector($id, "porteGarageSectionnable", "sectionnable-"); ?>
        </div>
    </div>

    <div class="section sectionPorteGarage hidden enroulable"> <!-- modèle porte garage enroulable -->
        <div class="inputField">
            porteGarageEnroulable
            <?php echo modelSelector($id, "porteGarageEnroulable", "enroulable-"); ?>
        </div>
    </div>

    <div class="section sectionPorteGarage" id="porteGarage-radioToClear<?php echo $id; ?>">
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