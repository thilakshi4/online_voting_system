<?php 

$dbHost='localhost';
$dbName="online_voting_system";
$dbUsername='root';
$dbPassword='';

$conn= mysqli_connect($dbHost,$dbUsername,$dbPassword,$dbName);
if(!$conn)
{
    die("connection fail".mysqli_connect_error());
}



