<?php
error_reporting(0);

$project = $_GET["project"];
$dvd = $_GET["dvd"];
$bsp = $_GET["bsp"];
//$board = $_GET["board"];
$mp = $_GET["mp"];
$bits = $_GET["bits"];
$testSuite = $_GET["testSuite"];
$dosFs = $_GET["dosFs"];
$cache = $_GET["cache"];

#page
$limit = $_GET["limit"];
$offset = $_GET["offset"];
#$order = $_GET["order"];

$queryObj = array();
if(!empty($project))
    $queryObj["project"] = $project;
if(!empty($dvd))
    $queryObj["dvd"] = $dvd;
if(!empty($bsp))
    $queryObj["bsp"] =$bsp;
if(!empty($board))
    $queryObj["board"] =$board;
if(!empty($mp))
    $queryObj["mp"] =$mp;
if(!empty($bits))
    $queryObj["bits"] =$bits;
if(!empty($testSuite))
    $queryObj["testSuite"] =$testSuite;
if(!empty($dosFs))
    $queryObj["dosFs"] =$dosFs;
if(!empty($cache))
    $queryObj["cache"] =$cache;

$queryObj["vsbState"] = 'Shipped';

include_once("./Core/db.php");
$collection = db::getCollection();
$pageCursor = $collection->find($queryObj, array(
    "_id" => 0
));

$cursor = $collection->find($queryObj, array(
    "_id" => 0
));
$cursor->skip($offset)->limit($limit);

echo json_encode(array(
    "total" => $pageCursor->count(),
    "rows" => iterator_to_array($cursor)
));
