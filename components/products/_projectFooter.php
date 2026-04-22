<?php
function projectFooter($id, $type = null)
{
    ob_start();
    ?>
    </div> <!-- Close projectBody -->
    <div class="projectFooter">
        <button type="button" class="btn btn-black addPortillonBtn <?php echo $type === "Portail" ? "" : "hidden" ?>" id="addPortillon-<?php echo $id ?>" onclick="addProjectPortillon()">Ajouter un portillon</button>

        <button type="button" class="btn btn-red deleteProjectBtn right" onclick="deleteProject(<?php echo $id; ?>)">Supprimer le produit</button>
    </div>
    </div> <!-- Close project -->
    <?php
    return ob_get_clean();
}
?>