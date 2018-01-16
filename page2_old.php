<?php
error_reporting(0);

$step = $_GET["step"];
$project = $_GET["project"];
$dvd1 = $_GET["dvd1"];
$dvd2 = $_GET["dvd2"];
$bsp = $_GET["bsp"];
$board = $_GET["board"];
$mp = $_GET["mp"];
$bits = $_GET["bits"];

//step 2
$testSuite = $_GET["testSuite"];
$dosFs = $_GET["dosFs"];
$cache = $_GET["cache"];

if($step == 1){
    $query1 = array("project" => $project, "dvd" => $dvd1);
    $query2 = array("project" => $project, "dvd" => $dvd2);
    if(!empty($bsp)){
        $query1["bsp"] = $bsp;
        $query2["bsp"] = $bsp;
    }
    if(!empty($board) && ($board != "null") ){
        $query1["board"] = $board;
        $query2["board"] = $board;
    }

    if(!empty($mp)){
        $query1["mp"] = $mp;
        $query2["mp"] = $mp;
    }
    if(!empty($bits)){
        $query1["bits"] = $bits;
        $query2["bits"] = $bits;
    }

    step_one($query1, $query2);
}elseif($step == 2){
    $query1 = array("dvd" => $dvd1);
    $query2 = array("dvd" => $dvd2);
    if(!empty($bsp)){
        $query1["bsp"] = $bsp;
        $query2["bsp"] = $bsp;
    }
    if(!empty($board)){
        $query1["board"] = $board;
        $query2["board"] = $board;
    }

    if(!empty($mp)){
        $query1["mp"] = $mp;
        $query2["mp"] = $mp;
    }
    if(!empty($bits)){
        $query1["bits"] = $bits;
        $query2["bits"] = $bits;
    }
    if(!empty($testSuite)){
        $query1["testSuite"] = $testSuite;
        $query2["testSuite"] = $testSuite;
    }
    if(!empty($dosFs)){
        $query1["dosFs"] = $dosFs;
        $query2["dosFs"] = $dosFs;
    }
    if(!empty($cache)){
        $query1["cache"] = $cache;
        $query2["cache"] = $cache;
    }

    step_two($query1, $query2);
}else{
    echo "[]";
}


function step_one($query1, $query2){
    include_once("./Core/db.php");
    $collection = db::getCollection();

    $pip1 = getPip_one($query1);
    $resultObj1 = $collection->aggregate($pip1);
    $result1 = $resultObj1["result"];

    $pip2 = getPip_one($query2);
    $resultObj2 = $collection->aggregate($pip2);
    $result2 = $resultObj2["result"];

//    echo count($result1).'---'.count($result2);

    $shared = my_array_intersect($result1, $result2);//交集，$result1和$result2都有的
    $bsp1have = my_array_diff($result1, $result2);//$result2中没有的
    $bsp2have = my_array_diff($result2, $result1);//$result1中没有的

//    echo json_encode($shared);

    $resultArray = array();
    while(list($key, $val) = each($shared)){
        array_push($resultArray, array(
            "bsp1" => $val["bsp"],
            "bsp2" => $val["bsp"],
            "board1" => $val["board"],
            "board2" => $val["board"],
            "bits1" => $val["bits"],
            "bits2" => $val["bits"],
            "mp1" => $val["mp"],
            "mp2" => $val["mp"]
        ));
    }

    if(count($bsp1have) > 0){
        while(list($key, $val) = each($bsp1have)){
            array_push($resultArray, array(
                "bsp1" => $val["bsp"],
                "bsp2" => "",
                "board1" => $val["board"],
                "board2" => "",
                "bits1" => $val["bits"],
                "bits2" => "",
                "mp1" => $val["mp"],
                "mp2" => ""
            ));
        }
    }

//    var_dump($resultArray);

    if(count($bsp2have) > 0){
        while(list($key, $val) = each($bsp2have)){
            array_push($resultArray, array(
                "bsp1" => "",
                "bsp2" => $val["bsp"],
                "board1" => "",
                "board2" => $val["board"],
                "bits1" => "",
                "bits2" => $val["bits"],
                "mp1" => "",
                "mp2" => $val["mp"]
            ));
        }
    }

    rsort($resultArray);
    echo json_encode($resultArray);
}

function step_two($query1, $query2){
    include_once("./Core/db.php");
    $collection = db::getCollection();

    $pip1 = getPip_two($query1);
    $resultObj1 = $collection->aggregate($pip1);
    $result1 = $resultObj1["result"];
//    var_dump($result1);

    $pip2 = getPip_two($query2);
    $resultObj2 = $collection->aggregate($pip2);
    $result2 = $resultObj2["result"];

//    echo count($result1).'---'.count($result2);

    $resultArray = array();
    foreach($result1 as $doc1){

        foreach($result2 as $doc2){
            if($doc1["bmName"] == $doc2["bmName"]){
                //2-1/1
                $diff = ($doc2["bmData"] - $doc1["bmData"])/$doc1["bmData"];
                array_push($resultArray, array(
                    "bmName1" => $doc1["bmName"],
                    "bmName2" => $doc1["bmName"],
                    "bmData1" => $doc1["bmData"],
                    "bmData2" => $doc2["bmData"],
                    "diff" => round($diff, 2).'%'
                ));
                continue;
            }
        }
    }

    rsort($resultArray);
    echo json_encode($resultArray);
}


function getPip_one($query){
    return array(
        array(
            '$match' => $query
        ),
        array(
            '$group' => array(
                '_id' => array(
                    'bsp' => '$bsp',
                    'board' => '$board',
                    'mp' => '$mp',
                    'bits' => '$bits'
                )
            )
        ),
        array(
            '$project' => array(
                '_id' => 0,
                'bsp' => '$_id.bsp',
                'board' => '$_id.board',
                'mp' => '$_id.mp',
                'bits' => '$_id.bits'
            )
        )
    );
}

function getPip_two($query){
    return array(

        array(
            '$match' => $query
        ),
        array(
            '$project' => array(
                '_id' => 0,
                'bmName' => '$testName',
                'bmData' => '$averageTime'
            )
        )
    );
}

function my_array_intersect($arr1, $arr2){
    $result = array();

    foreach($arr1 as $doc1){

        foreach($arr2 as $doc2){
            if($doc1 == $doc2)
                array_push($result, $doc1);
        }
    }

    return $result;
}

function my_array_diff($arr1, $arr2){//差集$arr1有，$arr2中没有的数据
    $result = array();

    foreach($arr1 as $doc1){
        $isFind = false;
        foreach ($arr2 as $doc2) {
            if($doc1 == $doc2)
                $isFind = true;
        }

        if(!$isFind){
            array_push($result, $doc1);
        }
    }

    return $result;
}

