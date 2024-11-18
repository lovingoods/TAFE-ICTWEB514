<?php include 'inc/header.php'; ?>

<?php
  $name = $email = $body = $appointment_date= $time = $trainer = '';
  $nameErr = $emailErr = $bodyErr = $dateErr = $timeErr = $trainerErr = '';

  // 表單提交
  if (isset($_POST['submit'])) {
    // 驗證姓名
    if (empty($_POST['name'])) {
      $nameErr = 'Name is required';
    } else {
      $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    // 驗證 Email
    if (empty($_POST['email'])) {
      $emailErr = 'Email is required';
    } else {
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    }
    // 驗證反饋內容
    if (empty($_POST['body'])) {
      $bodyErr = 'Feedback is required';
    } else {
      $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    // 驗證預約日期
    if (empty($_POST['appointment_date'])) {
      $dateErr = 'Appointment date is required';
    } else {
      $appointment_date = $_POST['appointment_date'];
    }
    if (empty($_POST['appointment_time'])) {
      $timeErr = 'Appointment time is required';
    } else {
      $appointment_time = $_POST['appointment_time'];
    }
    // 驗證教練
    if (empty($_POST['trainer'])) {
      $tranierErr = 'Trainer is required';
    } else {
      $trainer = $_POST['trainer'];
    }
  

    // 如果沒有錯誤，插入資料庫
    if (empty($nameErr) && empty($emailErr) && empty($bodyErr) && empty($dateErr) && empty($timeErr) && empty($trainerErr)) {
      $sql = "INSERT INTO feedback (name, email, body, appointment_date, trainer) VALUES ('$name', '$email', '$body', '$appointment_date', '$time', '$trainer')";

      if (mysqli_query($conn, $sql)) {
        // 插入成功，跳轉到預約列表頁面
        header('Location: feedback.php');
      } else {
        echo 'Error: ' . mysqli_error($conn);
      }
    }
  }
?>

<img src="/php-crash/feedback/img/logo.png" class="w-25 mb-3" alt="">
<h2>Book an Appointment</h2>
<p class="lead text-center">Leave your details for an appointment</p>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-4 w-75">
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control <?php echo $nameErr ? 'is-invalid' : null; ?>" id="name" name="name" placeholder="Enter your name">
    <div class="invalid-feedback">
      <?php echo $nameErr; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control <?php echo $emailErr ? 'is-invalid' : null; ?>" id="email" name="email" placeholder="Enter your email">
    <div class="invalid-feedback">
      <?php echo $emailErr; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="appointment_date" class="form-label">Appointment Date</label>
    <input type="date" class="form-control <?php echo $dateErr ? 'is-invalid' : null; ?>" id="appointment_date" name="appointment_date">
    <div class="invalid-feedback">
      <?php echo $dateErr; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="body" class="form-label">Comment</label>
    <textarea class="form-control <?php echo $bodyErr ? 'is-invalid' : null; ?>" id="body" name="body" placeholder="Enter your comment"></textarea>
    <div class="invalid-feedback">
      <?php echo $bodyErr; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="appointment_time" class="form-label">Appointment Time</label>
    <select class="form-control <?php echo $timeErr ? 'is-invalid' : null; ?>" id="appointment_time" name="appointment_time">
      <option value="">Select Time</option>
      <?php
        // 顯示每小時選項
        for ($i = 9; $i < 20; $i++) {
          $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
          echo "<option value='$hour:00'>$hour:00</option>";
        }
      ?>
    </select>
    <div class="invalid-feedback">
      <?php echo $timeErr; ?>
    </div>
  </div>
  <div class="mb-3">
    <label for="trainer" class="form-label">Trainer</label>
    <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="trainerDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    Select Trainer
    </button>
    <ul class="dropdown-menu" aria-labelledby="trainerDropdown">
      <li><a class="dropdown-item" href="#" onclick="selectTrainer('Sally Wilson')">Sally Wilson</li>
      <li><a class="dropdown-item" href="#" onclick="selectTrainer('Jack Tompson')">Jack Tompson</li>
      <li><a class="dropdown-item" href="#" onclick="selectTrainer('Natalee Wu')">Natalee Wu</li>  
    </ul>
      <input type="hidden" id="trainer" name="trainer">
    </div>
  </div>
  <div class="mb-3">
    <input type="submit" name="submit" value="Book Now" class="btn btn-dark w-100">
  </div>
  <script>
  function selectTrainer(trainer) {
    // 更新隱藏輸入欄位的值
    document.getElementById('trainer').value = trainer;
    // 更新按鈕的顯示文字
    document.getElementById('trainerDropdown').textContent = trainer;
  }
</script>
</form>

<?php include 'inc/footer.php'; ?>
