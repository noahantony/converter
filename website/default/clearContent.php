<?php
$file = 'files/tamilLyrics.txt';
$fh = fopen($file, 'w') or die("can't open file");
$stringData = "";
fwrite($fh, $stringData);
fclose($fh);
$convertedFile = 'files/converted/tamilLyrics.txt';
$fhc = fopen($convertedFile, 'w') or die("can't open file");
$stringDataCon = "";
fwrite($fhc, $stringDataCon);
fclose($fhc);
?>

<a href="phpinfo.php"> << back </a><br>
<a href="index.html"> Home </a>