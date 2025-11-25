<?php
function addAutre($id): bool|string
{
    ob_start();
    ?>

    <h3>Autre Produit</h3>
    <div class="section sectionAutre">
        <div class="inputField">
            <label for="descriptionAutre<?php echo $id ?>">Description</label>
            <textarea name="descriptionAutre<?php echo $id ?>" id="descriptionAutre<?php echo $id ?>" rows="4" cols="50"></textarea>
        </div>

    </div>
    <?php
    return ob_get_clean();
}
?>