<?php
function addFournitures($id)
{
    ob_start();
    ?>

    <h3>Fournitures</h3>
    <div class="section sectionFournitures"> <!-- options fournitures -->
        <div class="inputField">
            <label for="visiophone<?php echo $id ?>">Visiophone</label>
            <input type="checkbox" name="visiophone<?php echo $id ?>" id="visiophone<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="digicode<?php echo $id ?>">Digicode</label>
            <input type="checkbox" name="digicode<?php echo $id ?>" id="digicode<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="interphone<?php echo $id ?>">Interphone</label>
            <input type="checkbox" name="interphone<?php echo $id ?>" id="interphone<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="fournituresPose<?php echo $id ?>">Fournitures Pose</label>
            <input type="checkbox" name="fournituresPose<?php echo $id ?>" id="fournituresPose<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="automatisme<?php echo $id ?>">Automatisme</label>
            <input type="checkbox" name="automatisme<?php echo $id ?>" id="automatisme<?php echo $id ?>">
        </div>
    </div>
    
    <?php
}
?>