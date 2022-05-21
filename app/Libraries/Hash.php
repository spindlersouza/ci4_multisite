<?php

namespace App\Libraries;

class Hash {

    public static function make($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function check($password, $dbPass) {
        if (password_verify($password, $dbPass)) {
            return true;
        } else {
            return false;
        }
    }

}

?>