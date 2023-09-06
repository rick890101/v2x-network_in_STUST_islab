<?php
// 先連接資料庫
require_once("../mysql_pdo_connect/mysql_connect.php");
header('Content-type:application/json;charset=utf-8');

// [GET] result=all
// GET回傳所有傳感器資料
if(isset($_GET["result"]) && $_GET["result"] == "all"){
    $sql = "SELECT * FROM `sensors`;";
    $query = $PDO -> query($sql);
    $sql_data = $query -> fetchAll();
    echo json_encode($sql_data);
    return;
}

// [GET] sensor_id=N
// GET回傳sensor_id=N的傳感器資料
elseif(isset($_GET["sensor_id"])){
    $sensor_id = $_GET["sensor_id"];
    $sql = "SELECT * FROM `sensors` WHERE `sensor_id` = :sensor_id;";
    $query = $PDO -> prepare($sql);
    $query -> bindParam(":sensor_id", $sensor_id, PDO::PARAM_INT);
    $query -> execute();
    $sql_data = $query -> fetchAll();
    echo json_encode($sql_data);
    return;
}

// [GET] patient_id=N
// GET回傳patient_id=N，患者身上所裝設之傳感器列表
elseif(isset($_GET["patient_id"])){
    $patient_id = $_GET["patient_id"];
    // PDO SQL語法，列出sensor資料表中，patient_id=N的資料，依sensor_id小至大排序
    $sql = "SELECT * FROM `sensors` WHERE `patient_id` = :patient_id ORDER BY `sensor_id` ASC;";
    $query = $PDO -> prepare($sql);
    $query -> bindParam(":patient_id", $patient_id, PDO::PARAM_INT);
    $query -> execute();
    $sql_data = $query -> fetchAll();
    echo json_encode($sql_data);
    return;
}

// 若沒有HTTP Method參數，API回覆錯誤
else{
    echo json_encode(array("error" => "No HTTP Method"));
    return;
}
?>