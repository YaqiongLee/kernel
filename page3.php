<?php
error_reporting(0);

$project = $_GET["project"];
$bsp = $_GET["bsp"];
$mp = $_GET["mp"];
$bits = $_GET["bits"];
$testSuite = $_GET["testSuite"];
$dosFs = $_GET["dosFs"];
$cache = $_GET["cache"];
$testName = $_GET["testName"];

$query = array();



if(!empty($project)){
    $query["project"] = $project;
}
if(!empty($bsp)){
    $query["bsp"] = $bsp;
}
if(!empty($mp)){
    $query["mp"] = $mp;
}
if(!empty($bits)){
    $query["bits"] = $bits;
}
if(!empty($testSuite)){
    $query["testSuite"] = $testSuite;
}
if(!empty($dosFs)){
    $query["dosFs"] = $dosFs;
}
if(!empty($cache)){
    $query["cache"] = $cache;
}
if(!empty($testName)){
    $query["testName"] = $testName;
}
#lyq add. Shipped is the only we cared for vx69. 
$query["vsbState"] = 'Shipped';

include_once("./Core/db.php");
$collection = db::getCollection();

//$pip1 = getPip_one($query1);
$cursor = $collection->find($query, array(
    "_id" => 0,
    "dvd" => 1,
    "averageTime" => 1,
    "minTime" => 1,
    "maxTime" => 1,
));


$dvdArray = array();
$timeArray = array();
$minTimeArray=array();
$maxTimeArray=array();
while($cursor->hasNext()){
    $item = $cursor->next();
    array_push($dvdArray, $item["dvd"]);
    array_push($timeArray, $item["averageTime"]);
    array_push($minTimeArray, $item["minTime"]);
    array_push($maxTimeArray, $item["maxTime"]);
}

echo json_encode(array(
    "dvd" => $dvdArray,
    "average" => $timeArray,
    "min" => $minTimeArray,
    "max" => $maxTimeArray,
));

//$cursor->limit($cursor->count());

//echo json_encode(iterator_to_array($cursor));
