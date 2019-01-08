<?php
set_time_limit(0);
ini_set('memory_limit', '2048M');
include '../Enhanced_CS.php';
include '../kmp/kmp.php';

function db_get($q = ''){
	include '../koneksi.php';
	if($q !=''){
		return mysqli_query($link,$q);
	}
}

// function Cek kesamaan database dengan kmp
function checkkmp($text = "",$pattern = array()){
	if($text != "" && count($pattern) > 0){
		for($i=0;$i<count($pattern);$i++){
			$getkmp = kmp($text,$pattern[$i]);
			if(!$getkmp){
				return false;
			}
		}
		return true;
	}
	return false;
}

// funtion check kata imbuhan dan menghapusnya
function checkword($w){
	include '../koneksi.php';
	if($w !=''){
		$q = mysqli_query($link,"SELECT * FROM stopwords");
		$d = array();
		$words = array();
		while($word = mysqli_fetch_array($q)){
			$words[] = $word;
		}
		for($i = 0; $i < count($words); $i++){
			$w = str_replace($words[$i][0] . " ", "",$w);
		}
		return $w;
	}
}

// function dapatkan kata dasar dengan algoritma stemming
function basicword($words = ""){
	if($words !=""){
		$pecah=explode(" ", $words);
		$index = count($pecah);

		$katadasar = array();
		for($i=0; $i<$index;$i++){
			$stemming = Enhanced_CS($pecah[$i]);
			$katadasar[] = $stemming;
		}
		return $katadasar;
	}
	return null;
}

// function menetralkan kalimat dari karakter / ) {} dsb.
function netral($words){
	$words = str_replace("'", " ", $words);
	$words = str_replace("-", " ", $words);
	$words = str_replace(")", " ", $words);
	$words = str_replace("(", " ", $words);
	$words = str_replace("\"", " ", $words);
	$words = str_replace("/", " ", $words);
	$words = str_replace("=", " ", $words);
	$words = str_replace(".", " ", $words);
	$words = str_replace(",", " ", $words);
	$words = str_replace(":", " ", $words);
	$words = str_replace(";", " ", $words);
	$words = str_replace("!", " ", $words);
	$words = str_replace("?", " ", $words); 
	$words = str_replace(">", " ", $words); 
	$words = str_replace("<", " ", $words);
	$words = str_replace("+", " ", $words);
	$words = str_replace("%", " ", $words);
	$words = str_replace("^", " ", $words);
	$words = str_replace("*", " ", $words);
	$words = str_replace("#", " ", $words);

	return $words;
}

// function mengembalikan hasil berbentuk table
function populate($data = []){
	if(count($data) < 1){
		return false;
	}


}

if(isset($_POST['kata']) && $_POST['kata'] != ''){
	
	$asli = $_POST['kata'];
	$target = $asli;
	// menetralkan kalimat
	$target = netral($target);
	// mengubah menjadi huruf kecil
	$target = strtolower($target);
	// menghapus konjungsi
	$target = checkword($target);
	// mengambil kata dasar
	$katadasar = basicword($target);
	
	
	// dapatkan semua data peribahasa berdasarkan text asli
	$sql = "SELECT * FROM periba WHERE nama_peribahasa='" . $asli . "'";
	if(count(mysqli_fetch_array(db_get($sql))) > 0):
		$periba = array();
		$n = 0;
		while($p = mysqli_fetch_array(db_get($sql))){
			$periba[$n]["id_peribahasa"] = $p['id_peribahasa'];
			$periba[$n]["nama_peribahasa"] = $p['nama_peribahasa'];
			$periba[$n]["arti_peribahasa"] = $p['arti_peribahasa'];
			$periba[$n]["id_kategori"] = $p['id_kategori'];
			$periba[$n]["id_admin"] = $p['id_admin'];
		}
		populate($periba);
		return;
	endif;

	// Jika dengan cara diatas tidak ditemukan data, maka menggunakan algo kmp
	$sql = "SELECT * FROM periba";
	$q = db_get($sql);
	$datas = array();
	// simpan pada variable array
	while($data = mysqli_fetch_array($q)){
		$datas[]  = $data;
	}
	// Jika dengan cara diatas tidak ditemukan data, maka menggunakan algo kmp
	$sql = "SELECT * FROM periba";
	$q = db_get($sql);
	$datas = array();
	while($data = mysqli_fetch_array($q)){
		$datas[] = $data;
	}
	foreach($datas as $k => $v){
		if(checkkmp($v["nama_peribahasa"],$katadasar)){
			$periba[0]["id_peribahasa"] = $v['id_peribahasa'];
			$periba[0]["nama_peribahasa"] = $v['nama_peribahasa'];
			$periba[0]["arti_peribahasa"] = $v['arti_peribahasa'];
			$periba[0]["id_kategori"] = $v['id_kategori'];
			$periba[0]["id_admin"] = $v['id_admin'];
			populate($periba);
			return;
		}
	}

	echo "Peribahasa tidak ditemukan.";
}
?>