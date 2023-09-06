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

    // [POST] full_name, Gender, Age, contact_number數據，新增患者資料
    elseif( isset($_POST["full_name"]) && isset($_POST["gender"]) && isset($_POST["age"]) && isset($_POST["contact_number"]) ){
        // 取得POST數據
        $full_name = $_POST["full_name"];
        $gender = $_POST["gender"];
        $age = $_POST["age"];
        $contact_number = $_POST["contact_number"];
        // PDO SQL語法，插入患者資料至資料表patients
        $sql = "INSERT TO patients (full_name, gender, age, contact_phone) VALUES (?, ?, ?, ?)";
        $query = $PDO -> prepare($sql);
        // try-catch 錯誤處理
        try{
            $query -> execute(array($full_name, $gender, $age, $contact_number));
        }catch(PDOException $e){
            echo json_encode(array("error" => $e -> getMessage()));
            return;
        }
        // 回覆成功訊息
        echo json_encode(array("success" => "Insert Success"));
        return;
    }

    // 沒有HTTP Method參數，API回覆錯誤
    else{
        echo json_encode(array("error" => "No HTTP Method"));
    }
?>