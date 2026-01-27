<?php
function modelPortailBattantsModal($id)
{

    $modelList = getModel("portails_battants");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}


function modelPortailCoulissantModal($id)
{
    $modelList = getModel("portails_coulissants");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}

function modelPortillonModal($id)
{
    $modelList = getModel("portillons");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}


function modelClotureBeton($id)
{
   $modelList = getModel("clotures_beton");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}


function modelClotureAluminiumModal($id) {
    $modelList = getModel("clotures_aluminium");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

function modelPorteGarageModal($id) {
    $modelList = getModel("portes_garage");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

function modelStoreModal($id) {
    $modelList = getModel("stores");
    return json_encode($modelList, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}
?>