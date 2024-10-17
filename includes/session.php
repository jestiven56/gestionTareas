<?php

session_start();

function login_user($user_id, $user_name) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_name'] = $user_name;
}

function logout_user() {
    session_unset();
    session_destroy();
}
?>