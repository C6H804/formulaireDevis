<?php


function writteSondageRandom()
{
    $sondage = [
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageGoogle"
            id="chkSondageGoogle" value="on"></input><label for="chkSondageGoogle">Google</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageFacebook"
            id="chkSondageFacebook" value="on"></input><label for="chkSondageFacebook">Facebook</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageInstagram"
            id="chkSondageInstagram" value="on"></input><label for="chkSondageInstagram">Instagram</label></div>',
        // '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondagePinterest"
            // id="chkSondagePinterest" value="on"></input><label for="chkSondagePinterest">Pinterest</label></div>',
        // '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageRadio"
            // id="chkSondageRadio" value="on"></input><label for="chkSondageRadio">Radio</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageBoucheOreille"
            id="chkSondageBoucheOreille" value="on"></input><label for="chkSondageBoucheOreille">Bouche à oreille</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondagePubliciteGrandMail"
            id="chkSondagePubliciteGrandMail" value="on"></input><label for="chkSondagePubliciteGrandMail">Publicité Grand Mail St Paul
            Lès Dax</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondagePublicitePapier"
            id="chkSondagePublicitePapier" value="on"></input><label for="chkSondagePublicitePapier">Publicité papier (Catalogue,
            prospectus, flyer)</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondagePubliciteExterieure"
            id="chkSondagePubliciteExterieure" value="on"></input><label for="chkSondagePubliciteExterieure">Publicité extérieure
            (Panneau publicitaire)</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageRouteBegaar"
            id="chkSondageRouteBegaar" value="on"></input><label for="chkSondageRouteBegaar">Sur la route, en passant devant l\'agence à
            Bégaar</label></div>',
        '<div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageRouteLescar"
            id="chkSondageRouteLescar" value="on"></input><label for="chkSondageRouteLescar">Sur la route, en passant devant l\'agence à
            Lescar</label></div>'
    ];

    $r = '';
    shuffle( $sondage );
    foreach ( $sondage as $s) {
        $r .= $s;
    }
    return $r;
}

ob_start();
?>

<div class="section sectionSondage">
    <h3>
        Comment nous avez-vous connu ? Nous vous serions reconnaissant de bien vouloir répondre à ce très rapide
        questionnaire afin d'améliorer nos services. (Plusieurs choix possible)
    </h3>
    <?php
    echo writteSondageRandom();
    ?>

    <div class="inputField"><input type="checkbox" class="chkSondage" name="chkSondageAutre" id="chkSondageAutre"
            value="on"></input><label for="chkSondageAutre">Autre</label></div>
</div>

<div class="section sectionCGU">
    <div class="inputField">
        <input type="checkbox" class="chkSondage" name="chkAcceptCGU" id="chkAcceptCGU" required></input>
        <label for="chkAcceptCGU">En
            soumettant ce formulaire, j'accepte que les informations saisies soient exploitées dans le cadre
            de la demande
            de devis et de la relation commerciale qui peut en découler.
        </label>
    </div>
</div>


<?php
echo ob_get_clean();
?>