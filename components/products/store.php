<?php
function addStore($id)
{
    ob_start();
    ?>
    <h3>Store</h3>
    <div class="section sectionStore"> <!-- modèle de store -->
        <div class="inputField">
            <?php echo modelSelector($id, 'store'); ?>
        </div>
    </div>

    <div class="section sectionStore"> <!-- dimension store -->
        <div class="inputField">
            <label for="dimensionLargeur<?php echo $id ?>">Dimension largeur (en cm) :</label>
            <input type="text" name="dimensionLargeur<?php echo $id ?>" id="dimensionLargeur<?php echo $id ?>"
                placeholder="Exemple 120 cm">
        </div>
    </div>
    
    <?php
    return ob_get_clean();
}
?>