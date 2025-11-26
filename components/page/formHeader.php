<?php
echo "<form method='post' action='components/api/controller.php' enctype='multipart/form-data'>";
echo "<div class='section sectionIdentite'>";
echo "<h2>Vos informations</h2>";
echo "<div class='sectionGroup sectionGroupName'>";

echo createInput("text", "surname", "Votre prénom", "Prénom :", "", "", "required");
echo createInput("text", "name", "Votre nom", "Nom :", "", "", "required");
echo "</div>";
echo "<div class='sectionGroup sectionGroupAddress'>";
echo createInput("text", "address", "Votre adresse", "Adresse :", "", "", "required");
echo "</div>";
echo "<div class='sectionGroup sectionGroupContact'>";
echo createInput("text", "phone", "Votre téléphone", "Téléphone :");
echo createInput("text", "email", "Votre email", "Email :");
echo "</div>";
// echo "<br><hr><br>";
echo "</div>";

echo "<div class='section sectionPromotion'>";
echo "<h2>Promotion</h2>";
echo "<div class='sectionGroup sectionGroupCodePromo'>";
echo createInput("text", "codePromo", "Code promo", "Code promo :");
echo "</div>";

echo "<div class='sectionGroup sectionGroupTVAReduite'>";
echo createInput("radio", "TVA", "", "Ma maison à 2 ans ou plus :", "true", "", "checked");
echo createInput("radio", "TVA", "", "Ma maison à moins de 2 ans :", "false");
echo "</div>";
echo "</div>";
echo "<div class='projectsContainer' id='projectsContainer'>";
echo "<div class='projectsTitle'><h2>Vos projets</h2></div>";
echo "<input type='hidden' name='projectIds' id='projectIds' value=''>";
?>