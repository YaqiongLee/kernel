<?php
if (ob_get_level()) 
    ob_end_clean();

ob_implicit_flush(true);

echo str_pad('',1024, ' ');


error_reporting(0);

$release = $_REQUEST["release"];
$sprint = $_REQUEST["sprint"];
$week = $_REQUEST["week"];
$domain = $_REQUEST["domain"];
$hostos = $_REQUEST["hostos"];
$mongodb = $_REQUEST["mongodb"];
$update = $_REQUEST["update"];
$logaddr = $_REQUEST["logaddr"];
$require = $_REQUEST["require"];
$taskid = $_REQUEST["taskid"];

$mongo_flag="";
$update_flag="";

if ($mongodb=="Yes") {
   $mongo_flag = "-mongDB";
}
if ($update=="Yes") {
   $update_flag = "-update";
}

echo ("$release");
