<?php
if(isset($_POST['kata'])){
	#memanggil nilai dari text box
	$teksAsli = $_POST['kata'];
	echo "Teks asli : ".$teksAsli.'<br/>';
	
	#bersihkan tanda baca, ganti dengan space 
	$teksAsli = str_replace("'", " ", $teksAsli);
	$teksAsli = str_replace("-", " ", $teksAsli);
	$teksAsli = str_replace(")", " ", $teksAsli);
	$teksAsli = str_replace("(", " ", $teksAsli);
	$teksAsli = str_replace("\"", " ", $teksAsli);
	$teksAsli = str_replace("/", " ", $teksAsli);
	$teksAsli = str_replace("=", " ", $teksAsli);
	$teksAsli = str_replace(".", " ", $teksAsli);
	$teksAsli = str_replace(",", " ", $teksAsli);
	$teksAsli = str_replace(":", " ", $teksAsli);
	$teksAsli = str_replace(";", " ", $teksAsli);
	$teksAsli = str_replace("!", " ", $teksAsli);
	$teksAsli = str_replace("?", " ", $teksAsli); 
	$teksAsli = str_replace(">", " ", $teksAsli); 
	$teksAsli = str_replace("<", " ", $teksAsli);
	$teksAsli = str_replace("+", " ", $teksAsli);
	$teksAsli = str_replace("%", " ", $teksAsli);
	$teksAsli = str_replace("^", " ", $teksAsli);
	$teksAsli = str_replace("*", " ", $teksAsli);
	$teksAsli = str_replace("#", " ", $teksAsli);
	echo "Filtering: ".$teksAsli.'<br/>';
	
	#case folding
	$lower = strtolower($teksAsli);
	echo "Case folding : ".$lower.'<br/>';
	
	#stopword
	include 'koneksi.php';
	$file = file_get_contents("textpre/stops.txt");
	$data = explode(",", $file );
	array($data);
	echo "Preprocessing: ";
	for($i=0;$i<count($data);$i++){
		$lower = str_replace($data[$i], " ", $lower);
	}
	echo "".$lower.'</br>';

	#menyimpan semua hasil token kedalam array
	#tokenizing
	$pecah=explode(" ", $lower);
	$index = count($pecah);

	echo "Kata dasar : ";
	#proses stemming dg algo nazief
	for($i=0; $i<$index;$i++){
		$stemming = Enhanced_CS($pecah[$i]);
		echo " ".$stemming;
	}
	
	
}
?>