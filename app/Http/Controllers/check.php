<?php 
//$cmd = 'echo %home%';
echo $loc = "C:\Users\sony\Desktop\autorun\app_publish\setup.exe";
$cmd = $loc.' "it worked!"';
echo shell_exec($cmd);
?>
