<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <script src="https://kit.fontawesome.com/21274dacb7.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>

  <?php

  include 'config.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acc_num = $_POST['account_num'];
    $sec_code = $_POST['sec_code'];
    $acc_num = stripcslashes($acc_num);
    $sec_code = stripcslashes($sec_code);
    $acc_num = mysqli_real_escape_string($conn, $acc_num);
    $sec_code = mysqli_real_escape_string($conn, $sec_code);

    $sql = "SELECT * from verification where Account = '$acc_num' and ucARPin = '$sec_code'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    $ses_sql = mysqli_query($conn, "SELECT * FROM balance WHERE Account = '$acc_num'");

    if ($count == 1) {
      while ($rows = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC)) {
        if ($rows['Account'] == $acc_num) {
          $password = $_POST['password'];

          $checkQuery = "SELECT COUNT(*) as count FROM users WHERE acc_num = '$acc_num'";
          $checkResult = mysqli_query($conn, $checkQuery);
          $checkRow = mysqli_fetch_assoc($checkResult);
          $accountExists = $checkRow['count'] > 0;

          if ($accountExists) {
            $msg = "<p style='color:red;'>Account already exists</p>";
          } else {
            // Perform the INSERT query
            $sql = "INSERT INTO users (acc_num, pass_w)" . "VALUES('$acc_num', SHA2('$password', 256))";
            // Rest of your code
          }


          if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "<p style='color:green;'>You have successfully registered your account. You may login</p>";
            ?>
            <script>window.location="https://balance.beitbridgemun.co.zw/login";</script>
            <?php
          } else {
            $msg = "<p style='color:red;'>Account already exist</p>";
          }
        } else {
          $msg = "<p style='color:red';>Account not found in the Database</p>";
        }
      }
    } else {
      $msg = "<p style='color:red;'>Invalid Account Number or Security Code.</p>";
    }
  }



  $conn->close();
  ?>

  <div class="container">
    <div class="row mt-5">
      <div class="col-md-4"></div>
      <div class="col-md-4" style="background:green;padding:0;border-radius: 8px;">
        <center>
          <h3 class="p-2" style="color:white;">Municipality Of Beitbridge</h3>
        </center>
        <section style="background:#F7F7F7;" class="form-control p-4">
          <div class="login-form-bd">
            <div class="form-wrapper">
              <div class="form-container">
                <h4>
                  <p>Register Portal</p>
                </h4>
                <div class="form-control-section">
                  <?php echo $msg; ?>
                </div>
                <form method="post" autocomplete="off">
                  <div class="form-control-section mt-3">
                    <input class="form-control" type="text" name="account_num" id="account_num" placeholder="Account Number" autocomplete="off" onkeyup='check()'>
                  </div>

                  <div class="form-control-section mt-3">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password" autocomplete="off" onkeyup='check()'>
                  </div>

                  <div class="form-control-section mt-3">
                    <input class="form-control" type="password" name="checkpassword" id="checkPassword" placeholder="Confirm Password" autocomplete="off" onkeyup='check()'>
                  </div>
                  <div class="form-control-section mt-3">
                    <p id="alertPassword"></p>
                  </div>
                  Enter Security Code to Proceed
                  <div class="form-control-section mt-3">
                    <input class="form-control" type="password" name="sec_code" id="sec_code" placeholder="Security Code" autocomplete="off" onkeyup='check()' required>
                  </div>

                  <button id="btn-reg" class="btn btn-warning mt-3" onchange='check();'>Register</button>
                  <p class="text mt-3">Have an account? <a href="/login" class="link-primary text-decoration-none"> Login</a></p>
                </form>
              </div>
            </div>
          </div>
        </section>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>



  <script>
    var check = function() {
      if (document.getElementById('account_num').value.length > 12) {
        document.getElementById('btn-reg').disabled = true;
        document.getElementById('alertPassword').style.color = '#EE2B39';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number does not exist</span>';
      } else if (document.getElementById('account_num').value == '') {
        document.getElementById('btn-reg').disabled = true;
        document.getElementById('alertPassword').style.color = '#EE2B39';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number cannot be empty</span>';
      } else if (document.getElementById('account_num').value.length < 8) {
        document.getElementById('btn-reg').disabled = true;
        document.getElementById('alertPassword').style.color = '#EE2B39';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number does not exist</span>';
      } else if (document.getElementById('password').value.length < 4) {
        document.getElementById('btn-reg').disabled = true;
        document.getElementById('alertPassword').style.color = '#EE2B39';
        document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Password must be at least 4 charactors</span>';
      } else {
        if (document.getElementById('password').value !=
          document.getElementById('checkPassword').value) {
          document.getElementById('btn-reg').disabled = true;
          document.getElementById('alertPassword').style.color = '#EE2B39';
          document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Not matching</span>';
        } else if (document.getElementById('password').value == '') {
          document.getElementById('btn-reg').disabled = true;
          document.getElementById('alertPassword').style.color = '#EE2B39';
          document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Password cannot be empty</span>';
        } else {
          document.getElementById('btn-reg').disabled = false;
          document.getElementById('alertPassword').style.color = '#8CC63E';
          document.getElementById('alertPassword').innerHTML = '<span><i class="fas fa-check-circle"></i> Match!</span>';
        }
      }
    }
  </script>
</body>

</html>