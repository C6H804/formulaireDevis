<?php
echo "</div>";
echo "<div class='addProjectBtnContainer'><input type='button' id='addProjectBtn' value='Ajouter un projet' class='btn btn-black addProjectBtn center'></div>";
echo "
<div class='formFooter'>
<div class='fieldInput fieldInputTextarea'>
    <label for='moreInfo'>Plus d'informations sur votre projet ?</label>
    <textarea name='moreInfo' id='moreInfo' rows='4' cols='50'></textarea>
</div>
<div class='fieldInput fieldInputFile'>
    <label class='btn btn-red btn-h center' for='projectFile'>Nous transmettre une image</label>
    </div>
    <input type='file' name='projectFile' id='projectFile' onchange='changeImage()' class='hidden' />
";
include_once 'components/page/sondage.php';

echo "
</div>";
echo "<input class='btn btn-red btn-h center' type='submit' value='Envoyer vôtre demande' name='submit' />";

echo "</form>";
echo "</div>";
?>