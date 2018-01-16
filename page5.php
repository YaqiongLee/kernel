<?php
error_reporting(0);

$release = $_GET["release"];
$sprint = $_GET["sprint"];
$week = $_GET["week"];
$domain = $_GET["domain"];
$hostos = $_GET["hostos"];
$mongodb = $_GET["mongodb"];
$update = $_GET["update"];
$logaddr = $_GET["logaddr"];
$require = $_GET["require"];
$taskid = $_GET["taskid"];

$mongo_flag="";
$update_flag="";

if ($mongodb=="Yes") {
   $mongo_flag = "-mongDB";
}
if ($update=="Yes") {
   $update_flag = "-update";
}


echo("./vxworks7/LTAF/ltaf_vxworks.sh -sprint $sprint -week $week -ltaf $release -log $logaddr -domain $domain -req $require -hostos $hostos -taskID $taskid $mongo_flag $update_flag");

