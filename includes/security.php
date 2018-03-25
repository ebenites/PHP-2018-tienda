<?php
if(!isset($_SESSION['usuario'])){
    Flash::error('No está autorizado a acceder a esta página');
    header('location: login.php');
    exit();
}