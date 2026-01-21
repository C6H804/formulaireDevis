<?php
echo "</div>";
echo "<div class='addProjectBtnContainer'><input type='button' id='addProjectBtn' value='Ajouter un projet' class='btn btn-black addProjectBtn'></div>";
echo "
<div class='formFooter'>
<div class='fieldInput'>
    <label for='moreInfo'>Plus d'informations sur votre projet</label>
    <textarea name='moreInfo' id='moreInfo' rows='4' cols='50'></textarea>
</div>
<div class='fieldInput'>
    <label for='projectFile'>Nous transmettre un fichier</label>
    <input type='file' name='projectFile' id='projectFile'>
</div>
";
include_once 'components/page/sondage.php';

echo "
</div>";
echo "<input class='btn btn-red btn-h' type='submit' value='Envoyer vôtre demande' name='submit' />";

echo "</form>";
?>