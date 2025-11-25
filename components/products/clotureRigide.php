<?php
function addClotureRigide($id)
{
    ob_start();
    ?>
    <h3>Clôture rigide</h3>

    <div class="section sectionClotureRigide"> <!-- options kit occultant et soubassement -->
        <div class="inputField">
            <label for="chkA<?php echo $id ?>">kit occultant 661CL</label>
            <input type="checkbox" id="chkA<?php echo $id ?>" name="kitOccultant<?php echo $id ?>"
                value="Oui">
        </div>
        <div class="inputField">
            <label for="chkB<?php echo $id ?>">Soubassement 662CL</label>
            <input type="checkbox" id="chkB<?php echo $id ?>" name="kitSoubassement<?php echo $id ?>"
                value="Oui">
        </div>
    </div>

    <div class="section sectionClotureRigide"> <!-- choix couleur ral standard-->
        <div class="inputField">
            <?php echo ralStandard($id); ?>
        </div>
    </div>

    <div class="section sectionClotureRigide"> <!-- dimensions longueur -->
        <div class="inputField">
            <label for="dimensionLongueur<?php echo $id ?>">Longueur (en mètre linéaire)</label>
            <input type="text" name="dimensionLongueur<?php echo $id ?>" id="dimensionLongueur<?php echo $id ?>"
                placeholder="Exemple : 12,5 mètres">
        </div>
    </div>

    <div class="section sectionClotureRigide"> <!-- choix hauteur standard -->
        <div class="inputField">
            <label for="dimensionHauteur<?php echo $id ?>">Hauteur standard :</label>
            <select name="dimensionHauteur<?php echo $id ?>" id="dimensionHauteur<?php echo $id ?>">
                <option value="0,63">0,63 mètres</option>
                <option value="0,83">0,83 mètres</option>
                <option value="1,03">1,03 mètres</option>
                <option value="1,23">1,23 mètres</option>
                <option value="1,53">1,53 mètres</option>
                <option value="1,73">1,73 mètres</option>
                <option value="1,93">1,93 mètres</option>
                <option value="2,03" selected>2,03 mètres</option>
            </select>
        </div>
    </div>



    <?php
    return ob_get_clean();
}
?>