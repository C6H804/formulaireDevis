<?php
function ralSelector($id)
{
    ob_start();
    ?>
    <input type="button" id="<?php echo "ral$id"; ?>" class="btn btn-h-black center" value="Choisir une autre couleur"
        onclick="modalRalOpen(<?php echo $id; ?>, '#radioToClear<?php echo $id; ?>')" />
        <div class="displayColorSelected"><span id="ralOutput<?php echo $id; ?>"></span><span id="ralColor<?php echo $id; ?>"></span></div>
    <?php
    return ob_get_clean();
}
?>