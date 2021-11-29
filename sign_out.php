<?php 
$title='sign out';
require_once 'includes/header.php';

session_start();
unset($_SESSION['username']);
header("location:index.php");

