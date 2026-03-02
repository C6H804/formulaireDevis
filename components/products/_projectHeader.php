<?php
function projectHeader($id, $type = "Portail"): bool|string
{
    $options = [
        "Portail", "Portillon", "Clôture rigide", "Clôture béton",
        "Clôture aluminium", "Porte de garage", "Store", "Pergola",
        "Carport", "Fournitures", "Maçonnerie", "Autre"
    ];
    ob_start();
    ?>
    <div class="project" id="project<?php echo $id ?>">
        <div class="projectHeader" id="projectHeader<?php echo $id ?>">
            <div class="inputField">

                <select class="hidden" name="selectProject<?php echo $id; ?>" id="selectProject<?php echo $id ?>"
                    onchange="window.changeProjectType(<?php echo $id ?>)">
                    <?php foreach ($options as $opt): ?>
                    <option value="<?php echo $opt; ?>"<?php echo ($opt === $type) ? ' selected' : ''; ?>><?php echo $opt; ?></option>
                    <?php endforeach; ?>
                </select>

                <input type="button" class="btn btn-h-red btn-black" id="selectProjectBtn<?php echo $id ?>" onclick="window.openModalProject(<?php echo $id ?>)" value="Modifier ce projet" />

            </div>
        </div>

        <div class="projectBody">
            <?php
            return ob_get_clean();
}
?>