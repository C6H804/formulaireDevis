<?php
echo "<div id='formulaireDevis' class='formulaireDevis'>";
echo "<form method='post' action='components/api/controller.php' enctype='multipart/form-data'>";
echo "<div class='section sectionIdentite'>";
echo "<h2>Vos informations</h2>";
echo "<div class='sectionGroup sectionGroupName'>";

echo createInput("text", "surname", "Votre prénom", "Prénom :", "", "", "required");
echo createInput("text", "name", "Votre nom", "Nom :", "", "", "required");
// echo createInput("checkbox", "consent", "Consentement", "consentement :", "", "", "sectionA");
echo "<div class='sectionA'>
<label for='consent'>Consentement :</label>
<input type='checkbox' name='consent' id='consent'>
</div>";

// echo createInput("text", "age", "Votre age", "Âge :", "", "", "sectionA");
echo "<div class='sectionA'>
<label for='age'>Âge :</label>
<input type='text' name='age' id='age'>
</div>";

echo "</div>";
echo "<div class='sectionGroup sectionGroupAddress'>";
echo createInput("text", "address", "Votre adresse", "Adresse :", "", "", "required");
echo createInput("text", "city","Votre ville", "Ville :", "", "", "required");
echo createInput("text","postalCode","Votre code postal", "Code postal :", "", "", "required");
echo "</div>";
echo "<div class='sectionGroup sectionGroupContact'>";
echo createInput("text", "phone", "Votre téléphone", "Téléphone :");
echo createInput("text", "email", "Votre email", "Email :");
// echo createInput("text", "emailB", "Votre 2ème email", "2ème Email :", "", "sectionA");
echo "<div class='sectionA'>
<label for='emailB'>2ème Email :</label>
<input type='text' name='emailB' id='emailB'>
</div>";

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