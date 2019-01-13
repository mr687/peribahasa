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
		foreach($pattern as $k => $v):
			$getkmp = kmp($text,$v);
			if(!$getkmp){
				return false;
			}
		endforeach;
		return true;
	}
	return false;
}
function checkkmp2($text = "",$pattern = array()){
	if($text != "" && count($pattern) > 0){
		$textlower = strtolower($text);
		$kmp = array();
		foreach($pattern as $k => $v):
			foreach($v as $kk => $vv):
				$getkmp = kmp($textlower,$vv);
				if($getkmp){
					$kmp = $text;
				}
			endforeach;
		endforeach;
		return $kmp;
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
		return array_filter($katadasar);
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
	$words = str_replace("&", " ", $words);
	
	$words = strtolower($words);
	return $words;
}

// function cari sinonim dan cari di database peribahasa
function checkrelate($data = []){
	$kmp = [];
	foreach($data as $k => $v):
		$sinonim = array();
		$katada = basicword(netral(checkword($v['nama_peribahasa'])));
		foreach(array_unique($katada) as $kk => $vv):
			if($vv == ""):
				continue;
			endif;
			$si = mysqli_fetch_assoc(db_get("SELECT * FROM sinonim WHERE kata='" . $vv . "' OR sinonim like '%" . $vv . "'"));
			if(count($si) > 0){
				$split = split(",",trim(str_replace(" ","",$si['sinonim'].','.$si["kata"]),","));
				$split = array_diff($split,[$vv]);
				$sinonim[] = $split;
			}
		endforeach;
		$peribahasa = array();
		$q = db_get("SELECT * FROM periba");
		while($d = mysqli_fetch_array($q)){
			$peribahasa[] = $d;
		}
		foreach($peribahasa as $kk => $vv):
			if(checkkmp2($vv['nama_peribahasa'],$sinonim)):
				$kmp[] = $vv;
			endif;
		endforeach;
	endforeach;
	return $kmp;
}

// function mengembalikan hasil berbentuk table
function proses($data = []){
	if(count($data) < 1){
		echo json_encode(["status" => "kosong","data"=>[],"relate"=>[]]);
		return false;
	}
	$data["data"] = $data;
	$data["status"] = "sukses";
	$data["relate"] = [];

	$h = checkrelate($data["data"]);
	if($h):
		$data["relate"] = $h;
	endif;

	echo json_encode($data);
	return true;
}

if(isset($_POST['kata']) && $_POST['kata'] != ''){
	
	$asli = $_POST['kata'];
	unset($_POST['kata']);
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
		$aa = db_get($sql);
		$n = 0;
		while($p = mysqli_fetch_array($aa)){
			$periba[$n]["id_peribahasa"] = $p['id_peribahasa'];
			$periba[$n]["nama_peribahasa"] = $p['nama_peribahasa'];
			$periba[$n]["arti_peribahasa"] = $p['arti_peribahasa'];
			$periba[$n]["id_kategori"] = $p['id_kategori'];
			$periba[$n]["id_admin"] = $p['id_admin'];
			$n++;
		}
		proses($periba);
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
	$periba = [];
	$n = 0;
	foreach($datas as $k => $v){
		if(checkkmp($v["nama_peribahasa"],$katadasar)){
			$periba[$n]["id_peribahasa"] = $v['id_peribahasa'];
			$periba[$n]["nama_peribahasa"] = $v['nama_peribahasa'];
			$periba[$n]["arti_peribahasa"] = $v['arti_peribahasa'];
			$periba[$n]["id_kategori"] = $v['id_kategori'];
			$periba[$n]["id_admin"] = $v['id_admin'];
			$n++;
		}
	}
	if(proses($periba)):
		return;
	else:
		echo json_encode(["status" => "kosong","data"=>[],"relate"=>[]]);
	endif;
}
?>