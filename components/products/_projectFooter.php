<?php
function projectFooter($id, $type = null)
{
    ob_start();
    ?>
    </div> <!-- Close projectBody -->
    <div class="projectFooter">
        <?php if ($type === "Portail") { ?>
            <button type="button" class="btn btn-black" onclick="addProjectPortillon()">Ajouter un portillon</button>
        <?php } ?>
        <button type="button" class="btn btn-red deleteProjectBtn right" onclick="deleteProject(<?php echo $id; ?>)">Supprimer le produit</button>
    </div>
    </div> <!-- Close project -->
    <?php
    return ob_get_clean();
}
?>