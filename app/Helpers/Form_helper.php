<?php

function display_errors($validation, $field){
    if($validation->hasError($field)){
        return $validation->getError($field);
    } else {
        return false;
    }    
}
function form_errors($validation, $field){
    if($validation->hasError($field)){
        return $validation->getError($field);
    } else {
        return false;
    }    
}
function form_validation($validation, $field){
    if(isset($validation[$field])){
        return $validation[$field];
    } else {
        return false;
    }    
}

?>