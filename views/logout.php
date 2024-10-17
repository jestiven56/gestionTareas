<?php

require_once '../includes/session.php';
require_once '../includes/functions.php';

logout_user();
redirect('login.php');
?>