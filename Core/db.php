<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/8/29
 * Time: 13:05
 */

class db {

    static function getCollection(){
        require_once("config.db.php");

        $client = new MongoClient($db_config["serverUrl"]);

        $db = $client->selectDB($db_config["database"]);

        $collection = $db->selectCollection($db_config["collection"]);

        return $collection;

    }
}