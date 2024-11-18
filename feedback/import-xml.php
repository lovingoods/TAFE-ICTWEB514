<?php
// 引入資料庫配置文件
include 'config/database.php';

// 加載 XML 文件
$xmlFile = 'classes.xml';

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);

    // 遍歷每個 <class> 節點
    foreach ($xml->class as $class) {
        $name = $class->name;
        $start_time = $class->start_time;
        $end_time = $class->end_time;
        $available = $class->available;

        // 準備 SQL 查詢語句
        $sql = "INSERT INTO classes (name, start_time, end_time, available) 
                VALUES ('$name', '$start_time', '$end_time', '$available')";

        // 執行 SQL 查詢
        if (mysqli_query($conn, $sql)) {
            echo "Class '$name' has been successfully added to the database.<br>";
        } else {
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }
} else {
    echo "XML file not found.";
}

// 關閉資料庫連接
mysqli_close($conn);
?>
