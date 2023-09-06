<?php
    // PDO 連線至資料庫實作
    require_once("../mysql_pdo_connect/mysql_connect.php");
    header('Content-type:application/json;charset=utf-8');

    // [GET] result=all
    // 要求回覆所有資料
    if(isset($_GET["result"]) && $_GET["result"] == "all"){
        $sql = "SELECT * FROM `patients`;";
        $query = $PDO -> query($sql);
        $sql_data = $query -> fetchAll();
        echo json_encode($sql_data);
        return;
    }
    // [GET] result=new&count=(int)
    // 要求回覆最新(count)筆資料
    elseif(isset($_GET["result"]) && $_GET["result"] == "new" && isset($_GET["count"])){
        $count = intval($_GET["count"]);
        $sql = "SELECT * FROM patients ORDER BY patient_id DESC LIMIT :count";
        $query = $PDO->prepare($sql);
        $query->bindParam(':count', $count, PDO::PARAM_INT);
        $query->execute();
        $sql_data = $query->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($sql_data);
        return;
    }
    // 沒有HTTP Method參數，API回覆錯誤
    else{
        echo json_encode(array("error" => "No HTTP Method"));
    }
?>