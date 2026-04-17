<?php
echo "</div>";
// echo "<div class='addProjectBtnContainer'><input type='button' id='addProjectBtn' value='+ Ajouter un produit' class='btn btn-black addProjectBtn center'></div>";
echo "<div class='addProjectBtnContainer'>
<button id='addProjectBtn' class='btn btn-black addProjectBtn center'>
<span class='addProjectBtnContainerPlus'>+</span>
<span class='addProjectBtnContainerText'>Ajouter un produit</span>
</button>
</div>";
echo "
<div class='formFooter'>
<div class='fieldInput fieldInputTextarea'>
    <label for='moreInfo'>Plus d'informations sur votre projet ?</label>
    <textarea name='moreInfo' id='moreInfo' rows='4' cols='50' placeholder='Vous pouvez écrire ici des informations complémentaires...'></textarea>
</div>
<div class='fieldInput fieldInputFile'>
<label class='btn btn-red btn-h center' for='projectFile'>Nous transmettre une image</label>
</div>
<input type='file' name='projectFile' id='projectFile' onchange='changeImage()' class='hidden' />

<div class='imgPreview hidden'>
    <div class='imgPreviewContainer'>
        <div class='imgPreviewImageContainer'>
            <img id='imgDisplayPreview' class='imgDisplayPreview' src='' alt='Aucune image envoyée' />
        </div>
        <a id='removeImageBtn' class='removeImageBtn' onclick='removeImage()'>+</a>
    </div>
    <div id='imgName' class='imgName'></div>
</div>
";

include_once 'components/page/sondage.php';

echo "</div>";
echo "<input class='btn btn-red btn-h center' type='submit' value='Envoyer votre demande' name='submit' />";

echo "</form>";
echo "</div>";
?>