<?php  
function kmp($t, $p)
{
	$hasil = array();
    $pattern = str_split($p);
    $text    = str_split($t);
 
    $lompat = preKMP($pattern);
 
    $i = $j = 0;
    $num=0;
    while($j<count($text)){
      if(isset($pattern[$i]) && isset($lompat[$i])){
        while($i>-1 && $pattern[$i]!=$text[$j]){
            $i = $lompat[$i];
        }
      }else{
        $i = 0;
      }
 
      $i++;
      $j++;
      if($i>=count($pattern)){
          $hasil[$num++]=$j-count($pattern);
          if(isset($lompat[$i])){
              $i = $lompat[$i];
		  }
      }
	}
	if(count($hasil) > 0):
		return true;
	else:
		return false;
	endif;
}

function preKMP($pattern){
    $i = 0;
    $j = $lompat[0] = -1;
    while($i<count($pattern)){
      while($j>-1 && $pattern[$i]!=$pattern[$j]){
        $j = $lompat[$j];
      }
      $i++;
      $j++;
      if(isset($pattern[$i])&&isset($pattern[$j])){
        if($pattern[$i]==$pattern[$j]){
            $lompat[$i]=$lompat[$j];
        }else{
            $lompat[$i]=$j;
        }
      }
    }
    return $lompat;
  }
?>