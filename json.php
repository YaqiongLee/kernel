<?php
error_reporting(0);
/**
 * Created by mliu4.
 * User: Administrator
 * Date: 2015/8/29
 */

$name = $_GET["name"];

getJson($name);

function getJson($para){
    include_once('./Core/db.php');
    $collection = db::getCollection();

    if($para == null){
        echo "";
    }elseif($para == 'project'){
        $dvds = $collection->distinct("project",[]);
        echo json_encode(array_format($dvds));
    } elseif($para == 'dvd'){
        $project = $_GET["project"];
        if(!empty($project)) {
            $dvds = $collection->distinct("dvd", array(
                'project' => $project
            ));
        }else{
             $dvds = $collection->distinct("dvd",[]);
        }
        echo json_encode(array_format($dvds));
    }elseif($para == 'bsp'){
        $project = $_GET["project"];
        $dvd = $_GET["dvd"];
        if(!empty($project)&& !empty($dvd)){
            $dvds = $collection->distinct("bsp", array(
               'project' => $project,
               'dvd' => $dvd
            ));
        }elseif(empty($project)&& !empty($dvd)){
           $dvds = $collection->distinct("bsp", array(
                'dvd' => $dvd
            ));
        }elseif(!empty($project)&& empty($dvd)){
           $dvds = $collection->distinct("bsp", array(
                'project' => $project
            ));
        }else{
            $dvds = $collection->distinct("bsp",[]);
        }
        echo json_encode(array_format($dvds));
    }elseif($para == 'board'){
        $project = $_GET["project"];
        $bsp = $_GET["bsp"];
        if(!empty($project)&& !empty($bsp)){
            $dvds = $collection->distinct("board", array(
               'project' => $project,
               'bsp' => $bsp
            ));
        }elseif(empty($project)&& !empty($bsp)){
           $dvds = $collection->distinct("board", array(
                'bsp' => $bsp
            ));
        }elseif(!empty($project)&& empty($dvd)){
           $dvds = $collection->distinct("board", array(
                'project' => $project
            ));
        }else{
            $dvds = $collection->distinct("board",[]);
        }
        echo json_encode(array_format($dvds));
    }elseif($para == 'mp'){
        $project = $_GET["project"];
        $bsp = $_GET["bsp"];
        if(!empty($project)&& !empty($bsp)){
            $dvds = $collection->distinct("mp", array(
               'project' => $project,
               'bsp' => $bsp
            ));
        }elseif(empty($project)&& !empty($bsp)){
           $dvds = $collection->distinct("mp", array(
                'bsp' => $bsp
            ));
        }elseif(!empty($project)&& empty($dvd)){
           $dvds = $collection->distinct("mp", array(
                'project' => $project
            ));
        }else{
            $dvds = $collection->distinct("mp",[]);
        }

        //$dvds = $collection->distinct("mp",[]);
        echo json_encode(array_format($dvds));
    }elseif($para == 'bits'){
        $project = $_GET["project"];
        $bsp = $_GET["bsp"];
        if(!empty($project)&& !empty($bsp)){
            $dvds = $collection->distinct("bits", array(
               'project' => $project,
               'bsp' => $bsp
            ));
        }elseif(empty($project)&& !empty($bsp)){
           $dvds = $collection->distinct("bits", array(
                'bsp' => $bsp
            ));
        }elseif(!empty($project)&& empty($dvd)){
           $dvds = $collection->distinct("bits", array(
                'project' => $project
            ));
        }else{
            $dvds = $collection->distinct("bits",[]);
        }

        //$dvds = $collection->distinct("bits",[]);
        echo json_encode(array_format($dvds));
    }elseif($para == 'testsuite'){
        $dvds = $collection->distinct("testSuite",[]);
        echo json_encode(array_format($dvds));
    }elseif($para == 'dosfs'){
        $dvds = $collection->distinct("dosFs",[]);
        echo json_encode(array_format($dvds));
    }elseif($para == 'cache'){
        $dvds = $collection->distinct("cache",[]);
        echo json_encode(array_format($dvds));
    }elseif($para == 'testname') {
        $testSuite = $_GET["testSuite"];
        if(!empty($testSuite)) {
            $dvds = $collection->distinct("testName", array(
                'testSuite' => $testSuite
            ));
        }else{
            $dvds = $collection->distinct("testName");
        }

//        echo count($dvds);
        echo json_encode(array_format($dvds));
    }else{
        echo "";
    }
}

function array_format($array){
    $result = array();

    foreach($array as $val){
        array_push($result, array(
            "id" => $val,
            "text" => $val
        ));
    }

    return $result;
}
