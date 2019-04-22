<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $filename = $_SERVER['REMOTE_ADDR'].'_'.(new DateTime())->format('Y-m-d H-i-s').'.jpg';
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, base64_decode($_REQUEST['file']));
    fclose($myfile);
}
?>
