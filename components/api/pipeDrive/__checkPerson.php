<?php
include_once "__fetchByEmail.php";
include_once "__fetchByPhone.php";
function checkPerson($email, $phone)
{
    global $token;

    if ($email !== "") {
        $personByEmail = fetchPersonByEmail($token, $email);
        foreach ($personByEmail['data']['items'] as $p) {
            if ($p['item']['emails'][0] == $email) {
                return $p['item']['id'];
            }
        }
    }
    if ($phone !== "") {
        $personByPhone = fetchPersonByPhoneNumber($token, $phone);
        foreach ($personByPhone['data']['items'] as $p) {
            if ($p['item']['phones'][0] == $phone) {
                return $p['item']['id'];
            }
        }
    }
    return false;

}


?>