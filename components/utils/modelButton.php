<?php
function modelSelector($id, $type, $outputIdPrefix = ""): bool|string
{
    ob_start();
    ?>
    <input type="button" id="model<?php echo $id; ?>" class="btn btn-h-black" value="Choisir un modèle"
        onclick="modalModel(<?php echo $id ?>, '<?php echo $type; ?>')" />

    <div class="modeleOutputField">
        <span id="<?php echo $outputIdPrefix; ?>modelOutput<?php echo $id; ?>"></span><span id="<?php echo $outputIdPrefix; ?>modelImage<?php echo $id; ?>"></span>
    </div>
    
    <input type="text" id="<?php echo $outputIdPrefix; ?>modelSelect<?php echo $id; ?>" name="<?php echo $outputIdPrefix; ?>modelSelect<?php echo $id; ?>" class="hidden">

    <?php
    return ob_get_clean();
}


?>