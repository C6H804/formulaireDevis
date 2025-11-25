<?php
function createInput($type, $name, $placeholder = "", $label = "", $value = "", $class = "", $required = "", $checked = "")
{
    $id = uniqid("input_$name-");
    if ($type === "textarea") {
        return "
        <div class='inputField'>
        <label for='" . htmlspecialchars($id) . "'>" . htmlspecialchars($label) . "</label>
        <textarea class='$class' id='" . htmlspecialchars($id) . "' name='" . htmlspecialchars($name) . "' placeholder='" . htmlspecialchars($placeholder) . "'>" . htmlspecialchars($value) . "</textarea>
        </div>
        ";
    } else if ($type === "select") {
        $result = "
        <div class='inputField'>
        <label for='" . htmlspecialchars($id) . "'>" . htmlspecialchars($label) . "</label>
        <select class='$class' id='" . htmlspecialchars($id) . "' name='" . htmlspecialchars($name) . "'>
        ";
        foreach ($value as $option) {
            $result .= "<option value='" . htmlspecialchars($option) . "'>" . htmlspecialchars($option) . "</option>";
        }
        $result .= "
        </select>
        </div>
        ";
        return $result;
    } else {
        return "
        <div class='inputField'>
        <label for='" . htmlspecialchars($id) . "'>" . htmlspecialchars($label) . "</label>
        <input class='$class' type='" . htmlspecialchars($type) . "' id='" . htmlspecialchars($id) . "' name='" . htmlspecialchars($name) . "' placeholder='" . htmlspecialchars($placeholder) . "' value='" . htmlspecialchars($value) . "' $required $checked />
        </div>
        ";
    }
}


?>