<?php
session_start();
if($_SESSION['logged']!=1){
	header('location:notLogged.php');
}

?>