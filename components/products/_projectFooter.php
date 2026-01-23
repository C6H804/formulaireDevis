<?php
function projectFooter($id)
{
    ob_start();
    ?>
    </div> <!-- Close projectBody -->
    <div class="projectFooter">
        <button type="button" class="btn btn-red deleteProjectBtn right" onclick="deleteProject(<?php echo $id; ?>)">Supprimer le projet</button>
    </div>
    </div> <!-- Close project -->
    <?php
    return ob_get_clean();
}
?>