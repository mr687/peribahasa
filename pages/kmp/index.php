<?php
include 'koneksi.php';
#include 'textpre/preprocessing.php';
#require_once 'enhanced_CS.php';
require_once 'kmp/kmp.php';

#$tampil  = mysql_query("SELECT * from periba") or die (mysql_error());
#$row = mysql_fetch_array($tampil);

#echo "tampil: "

$text = "ada udang dibalik batu";
$pattern = (isset($_POST['kata']) ? $_POST['kata'] : "");

$result = kmp($text, $pattern);
if ($result === false)
{
  echo "Tidak ditemukan";
}
else
{
  echo "Ditemukan pada index ke " . $result . '<br/>';
  echo "Text: ".$text;


}