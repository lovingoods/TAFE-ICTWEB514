<?php
header('Content-Type: application/json');
include 'config/database.php'; // 引入資料庫連接文件

$sql = "SELECT id, name, start_time, end_time, available FROM classes";
$result = mysqli_query($conn, $sql);

$events = [];

while ($row = mysqli_fetch_assoc($result)) {
  $start_time = date('c', strtotime($row['start_time'])); // 'c' 表示 ISO 8601 格式
  $end_time = date('c', strtotime($row['end_time']));

  $events[] = [
    'id' => $row['id'],
    'title' => $row['name'],
    'start' => $row['start_time'],
    'end' => $row['end_time'],
    'available' => $row['available'],
    'color' => $row['available'] > 0 ? '#28a745' : '#dc3545' // 綠色表示可預約，紅色表示不可預約
  ];
}

echo json_encode($events);
?>
