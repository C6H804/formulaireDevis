<?php

function addPortail($id)
{
    ob_start();
    ?>
    <h3 class="productTitle">Portail</h3>
    <div class="section sectionPortail typePortailSection"> <!-- type de portail : battant coulissant -->
        <div class="inputField">
            <label for="<?php echo "typePortail$id"; ?>">Choisissez votre type de portail :</label>
            <select name="typePortail<?php echo $id; ?>" id="<?php echo "typePortail$id"; ?>"
                onchange="changeDisplaySection(<?php echo $id; ?>, 'typePortail')">
                <option value="Battant">Portail battant</option>
                <option value="Coulissant">Portail coulissant</option>
            </select>
        </div>
    </div>

    <div class="section sectionPortail automatismeSection"> <!-- automatisme oui non -->
        <label for="<?php echo "automatismeOui$id"; ?>">Avec automatisme ?</label>

        <div class="inputField">
            <label for="<?php echo "automatismeOui$id"; ?>">Oui :</label>
            <input type="radio" name="automatisme<?php echo $id ?>" value="Oui" checked
                id="<?php echo "automatismeOui$id"; ?>" />
        </div>
        <div class="inputField">
            <label for="<?php echo "automatismeNon$id"; ?>">Non :</label>
            <input type="radio" name="automatisme<?php echo $id ?>" value="Non" id="<?php echo "automatismeNon$id"; ?>" />
        </div>
    </div>

    <div class="section sectionPortail hidden directionCoulissantSection"> <!-- sens ouverture coulissant -->
        <div class="inputField">
            <label for="<?php echo "directionCoulissant$id"; ?>">Sens de l'ouverture (vue de l'extérieur)</label>
            <select name="directionCoulissant<?php echo $id ?>" id="<?php echo "directionCoulissant$id"; ?>">
                <option value="Droite">Droite</option>
                <option value="Gauche">Gauche</option>
            </select>
        </div>
    </div>

    <div class="section sectionPortail hidden modelCoulissant"> <!-- modèle coulissant -->
        <div class="inputField">
            <?php echo modelSelector($id, 'portailCoulissant', 'coulissant-'); ?>
        </div>
    </div>

    <div class="section sectionPortail modelBattant"> <!-- modèle battant -->
        <div class="inputField">
            <?php echo modelSelector($id, 'portailBattant', 'battant-'); ?>
        </div>
    </div>

    <div class="section sectionPortail" id="radioToClear<?php echo $id; ?>"> <!-- couleur standard -->
        <?php ralStandard($id); ?>
    </div>

    <div class="section sectionPortail"> <!-- autre couleur -->
        <div class="inputField">
            <?php echo ralSelector($id); ?>
            <input type="text" name="ralSelect<?php echo $id ?>" id="ralSelect<?php echo $id ?>" class="hidden">
            <div class="output" id="ralOutput<?php echo $id; ?>"></div>
        </div>
    </div>

    <div class="section sectionPortail"> <!-- finition Mat, brillant, sablé -->
        <div class="inputField">
            <label for="<?php echo "finition$id"; ?>">Finition :</label>
            <select name="finition<?php echo $id ?>" id="<?php echo "finition$id"; ?>">
                <option value="Brillant">Brillant</option>
                <option value="Mât">Mât</option>
                <option value="Sablé">Sablé</option>
            </select>
        </div>
    </div>

    <div class="section sectionPortail"> <!-- dimensions entre Poteaux et hauteur -->
        <div class="inputField">
            <label for="<?php echo "dimensionLongueur$id"; ?>">Dimension entre Poteaux (en cm)</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="<?php echo "dimensionLongueur$id"; ?>"
                placeholder="Exemple : 125 cm" />
        </div>
        <div class="inputField">
            <label for="<?php echo "dimensionHauteur$id"; ?>">Dimension Hauteur du portail (en cm)</label>
            <input type="text" name="dimensionHauteur<?php echo $id ?>"
                id="<?php echo "dimensionHauteur$id"; ?>" placeholder="Exemple : 170 cm" />
        </div>
    </div>


    <?php
    return ob_get_clean();
}
?>