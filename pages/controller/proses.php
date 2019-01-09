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

// function cari sinonim dan cari di database peribahasa
function checkrelate($katadasar = []){
	$sinonim = array();
	foreach($katadasar as $k => $v):
		$si = mysqli_fetch_assoc(db_get("SELECT * FROM sinonim WHERE kata='" . $v . "'"));
		if(count($si) > 0){
			$sinonim[] = split(",",trim(str_replace(" ","",$si['sinonim']),","));
		}
	endforeach;

	$peribahasa = array();
	$q = db_get("SELECT * FROM periba");
	while($d = mysqli_fetch_array($q)){
		$peribahasa[] = $d;
	}
	$kmp = [];
	foreach($peribahasa as $k => $v):
		foreach($sinonim as $kk => $vv):
			if(checkkmp(trim($v['nama_peribahasa']),$vv)):
				if(!in_array(trim($v['nama_peribahasa']),$kmp)){
					$kmp[] = $v;
				}
			endif;
		endforeach;
	endforeach;
	return $kmp;
}

// function mengembalikan hasil berbentuk table
function populate($data = [],$relate = []){
	if(count($data) < 1){
		return false;
	}
	$content = "<div class=\"title\">";
	$content .= "<h3><Strong id=\"title\">";
	$content .= $data['nama_peribahasa'];
	$content .= "</Strong></h3>";
	$content .= "<p>";
	$content .= $data['arti_peribahasa'];
	$content .= "</p>";
	$content .= "</div>";
	$kmp = checkrelate($relate);
	if(count($kmp) > 0):
		$content .= "<div class=\"relate\" style=\"margin-top:60px;\">";
		$content .= "<h4><u>Peribahasa serupa</u></h4>";
		$content .= "<div class=\"col-md-5\">";
		$content .= "<ul class=\"list-group\">";
		foreach($kmp as $k=> $v):
			$content .= "<li class=\"list-group-item\">";
			$content .= "<a href=\"http://localhost/peribahasa/pages/cari.php?kata=" . $v['nama_peribahasa'] . "\">";
			$content .= trim($v['nama_peribahasa']);
			$content .= "</a>";
			$content .= "</li>";
		endforeach;
		$content .= "</li>";
		$content .= "</div>";
	endif;
	$content .= "</div>";

	echo $content;
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
		while($p = mysqli_fetch_array($aa)){
			$periba["id_peribahasa"] = $p['id_peribahasa'];
			$periba["nama_peribahasa"] = $p['nama_peribahasa'];
			$periba["arti_peribahasa"] = $p['arti_peribahasa'];
			$periba["id_kategori"] = $p['id_kategori'];
			$periba["id_admin"] = $p['id_admin'];
		}
		populate($periba, $katadasar);
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
			$periba["id_peribahasa"] = $v['id_peribahasa'];
			$periba["nama_peribahasa"] = $v['nama_peribahasa'];
			$periba["arti_peribahasa"] = $v['arti_peribahasa'];
			$periba["id_kategori"] = $v['id_kategori'];
			$periba["id_admin"] = $v['id_admin'];
			populate($periba, $katadasar);
			return;
		}
	}

	echo "<p>Peribahasa tidak ditemukan.</p>";
}
?>