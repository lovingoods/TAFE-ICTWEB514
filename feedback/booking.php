<?php
include 'config/database.php';

// 初始化變數
$responseMessage = '';
$responseColor = 'red';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = isset($_POST['eventId'])? (int)$_POST['eventId'] : 0;
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // 確認課程是否還有名額
    $query = "SELECT available FROM classes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();

    if ($event) {
      if ($event['available'] > 0) {
          // 插入預約資料
          $insertQuery = "INSERT INTO bookings (event_id, name, email, created_at) VALUES (?, ?, ?, NOW())";
          $insertStmt = $conn->prepare($insertQuery);
          $insertStmt->bind_param("iss", $eventId, $name, $email);

          if ($insertStmt->execute()) {
              // 更新可預約名額
              $updateQuery = "UPDATE classes SET available = available - 1 WHERE id = ?";
              $updateStmt = $conn->prepare($updateQuery);
              $updateStmt->bind_param("i", $eventId);
              $updateStmt->execute();

              $response['success'] = true;
              $response['message'] = 'Booking Successful!';
          } else {
              $response['message'] = 'Failed to save booking data';
          }
      } else {
          $response['message'] = 'No Vacancy';
      }
  } else {
      $response['message'] = 'Class not found';
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Booking Status</title>
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100vh;
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }
    .message {
    max-width: 400px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
    font-family: Arial, sans-serif;
    margin-top: 20px;
    transition: transform 0.2s ease-in-out;
    border-width: 2px;
    }

    .message.success {
        background-color: #d4edda;
        border: 2px solid #c3e6cb;
        color: #155724;
    }

    .message.error {
        background-color: #f8d7da;
        border: 2px solid #f5c6cb;
        color: #721c24;
    }

    .message h2 {
        margin: 0 0 10px;
        font-size: 1.2em;
    }

    .message p {
        font-size: 1em;
        margin: 0;
    }

    .message:hover {
        transform: scale(1.05);
    }
    .button-group {
        display: flex;
        gap: 20px;
        margin-top: 20px
    }
    .btn {
        padding: 10px 20px;
        font-size: 1em;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }
    .btn-home {
        background-color: #007bff;
        color: white;
    }
    .btn-calendar {
        background-color: #28a745;
        color: white;
    }
</style>
</head>
<body>
    <div class="message <?= $responseColor === 'green' ? 'success' : 'error' ?>">
        <h2>Hi, <?= $name ?> <br>thank you for booking our class!</br></h2>
        <p><?= htmlspecialchars($response['message']) ?></p>
    </div>
    <div class="button-group">
        <button class="btn btn-home" onclick="window.location.href='index.php'">Go to Home</button>
        <button class="btn btn-calendar" onclick="window.location.href='calendar.php'">View Calendar</button>
    </div>
</body>
</html>