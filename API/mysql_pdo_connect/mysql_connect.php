<?php
    date_default_timezone_set('Asia/Taipei');
    // PHP-PDO Connect
    $dbhost = "localhost";
    $dbname = "ncku_ttc_imot";
    $dbuser = "nckuttcproject";
    $dbuserpwd = "TTCproject0915";
    
    // PDO Options Setting: https://blog.markgdi.com/article/quick-start-operation-mysql-using-php-pdo/
    $pdo_options = [
        PDO::ATTR_PERSISTENT => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
    ];

    global $PDO;
    
    try{
        $PDO = new PDO("mysql:host=$dbhost;port=3306;dbname=$dbname", $dbuser, $dbuserpwd, $pdo_options);
        // echo "Success to PDO Connect MySQL.";
    }catch (PDOException $e) {
        throw new PDOException($e -> getMessage());
        exit();
        
    }

    function mysql_nowtime() {
        global $PDO;
        $sql = "SELECT NOW(3);";
        $query = $PDO -> query($sql);
        $sql_data = $query -> fetchAll();
        foreach($sql_data as $sql_data) return $sql_data[0];
    }

    function php_jsHref($url, $msec){
            echo "<script language='javascript' type='text/javascript'>";
            echo "setTimeout(()=>{window.location.href='$url'}, $msec);";
            echo '</script>'; 
            return;
    }
    function php_jsAlertHref($url, $msg){
        echo "<script language='javascript' type='text/javascript'>";
        echo "window.alert('$msg');";
        echo "window.location.href='$url';";
        echo '</script>'; 
        return;
}
?>