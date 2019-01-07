<?php
include 'koneksi.php';
$id		  = $_POST['username'];
$password = $_POST['pass'];

$login    = mysqli_query($link, "select * from login where id='$id and pass='$password'");


if (mysqli_fetch_array($login,MYSQLI_NUM) <> 0){
	 session_start();
	 $_SESSION['username'] = $id;
	 $_SESSION['pass'] = $password;

	 header ("location:pages/blank.html");
}else {
	echo "Gagal !! <br>";
} 
?>