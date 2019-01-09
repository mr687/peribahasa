<?php  
function kmp($text, $pattern)
{
	//strlen utk menghitung jml string
	$textlen = strlen($text);
	$pattlen = strlen($pattern);

	for ($i = 0; $i < $textlen; $i++)
	{
		$match = true;
		for ($j = 0; $j < $pattlen; $j++)
		{
			if(isset($text[$i + $j]) && isset($pattern[$j])):
				if ($text[$i + $j] != $pattern[$j])
				{
					$match = false;
					$i += $j;
					break;
				}
			endif;
		}

		if ($match) return $i;		
	}
	
	
	return false;
}
?>