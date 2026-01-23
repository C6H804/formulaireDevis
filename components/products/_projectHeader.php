<?php
function projectHeader($id): bool|string
{
    ob_start();
    ?>
    <div class="project" id="project<?php echo $id ?>">
        <div class="projectHeader" id="projectHeader<?php echo $id ?>">
            <div class="inputField">

                <select class="hidden" name="selectProject<?php echo $id; ?>" id="selectProject<?php echo $id ?>"
                    onchange="window.changeProjectType(<?php echo $id ?>)">
                    <option value="Portail">Portail</option>
                    <option value="Portillon">Portillon</option>
                    <option value="Clôture rigide">Clôture rigide</option>
                    <option value="Clôture beton">Clôture béton</option>
                    <option value="Clôture aluminium">Clôture aluminium</option>
                    <option value="Porte de garage">Porte de garage</option>
                    <option value="Store">Store</option>
                    <option value="Pergola">Pergola</option>
                    <option value="Carport">Carport</option>
                    <option value="Fournitures">Fournitures</option>
                    <option value="Maçonnerie">Maçonnerie</option>
                    <option value="Autre">Autre</option>
                </select>

                <input type="button" class="btn btn-h-red btn-black" id="selectProjectBtn<?php echo $id ?>" onclick="window.openModalProject(<?php echo $id ?>)" value="Modifier ce projet" />

            </div>
        </div>

        <div class="projectBody">
            <?php
            return ob_get_clean();
}
?>