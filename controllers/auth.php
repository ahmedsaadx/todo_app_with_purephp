<?php 
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

function route_protected(){
    if(!isAuthenticated()){
        header("location: ../index.php?page=login");
        exit;
    }
}