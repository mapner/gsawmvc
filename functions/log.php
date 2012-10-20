<?php


function writelog($texto){
	$ddf = fopen('msg.log','a');
	fwrite($ddf,$texto . chr(13).chr(10));
	fclose($ddf);
	}
	
function confirm($msg)
{
echo "<script langauge=\"javascript\">alert(\"".$msg."\");</script>";
}

?>