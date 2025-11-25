<?php
function addMaconnerie($id)
{
    ob_start();
    ?>

    <h3>Maçonnerie</h3>
    <div class="section sectionMaconnerie"> <!-- options maçonnerie -->
        <div class="inputField">
            <label for="piliers<?php echo $id ?>">Piliers</label>
            <input type="checkbox" name="piliers<?php echo $id ?>" id="piliers<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="piliersAluminium<?php echo $id ?>">Piliers Aluminium</label>
            <input type="checkbox" name="piliersAluminium<?php echo $id ?>" id="piliersAluminium<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="seuil<?php echo $id ?>">Seuil</label>
            <input type="checkbox" name="seuil<?php echo $id ?>" id="seuil<?php echo $id ?>">
        </div>
        <div class="inputField">
            <label for="refuite<?php echo $id ?>">Refuite</label>
            <input type="checkbox" name="refuite<?php echo $id ?>" id="refuite<?php echo $id ?>">
        </div>
    </div>

    <?php

    return ob_get_clean();
}
?>