<?php

    session_start();
    unset($_SESSION['legitUser']);
    header('Location: ../pages/login_form.html'); 

?>
