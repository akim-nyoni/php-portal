<?php 
    session_start();
    $_SESSION['start_time'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/21274dacb7.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <title>Login Portal - Municipality Of Beitbridge</title>
</head>

<body>

  <?php
  include 'config.php';
  $_SESSION['error'] = "";

  if (isset($_POST['submit'])) {
    $acc_num = $_POST['acc_num'];
    $password = $_POST['password'];
    $acc_num = stripcslashes($acc_num);
    $password = stripcslashes($password);
    $acc_num = mysqli_real_escape_string($conn, $acc_num);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * from users where acc_num = '$acc_num' and pass_w = SHA2('$password', 256)";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    $ses_sql = mysqli_query($conn, "SELECT * FROM balance WHERE Account = '$acc_num'");
    if (strlen($acc_num) < 8) {
      $_SESSION['error'] = "<p style='color:red;'>Account does not exist</p>";
    } else {
      if ($count == 1) {
        while ($rows = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC)) {
          if ($rows['Account'] == $acc_num) {
            $_SESSION['acc_num'] = $acc_num; 
            ?>
            <script>window.location="https://balance.beitbridgemun.co.zw/dashboard";</script>
            <?php
          } else {
            $_SESSION['error'] = "<p style='color:red';>Account not found in the Database</p>";
          }
        }
      } else {
        $_SESSION['error'] = "<p style='color:red;'>Login failed. Invalid Account Number or Password.</p>";
      }
    }
  }
  //$conn->close; 
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
              <h4>
                <p>Login Portal</p>
              </h4>
              <div class="form-container">

                <form action="" method="post" autocomplete="off">
                  <div class="form-control-section pt-2">
                    <input class="form-control" type="text" name="acc_num" id="account_num" placeholder="Account Number" onkeyup='check()' autocomplete="off">
                  </div>

                  <div class="form-control-section mt-3">
                    <input class="form-control" type="password" name="password" id="password" placeholder="Password" onkeyup='check()' autocomplete="off">
                  </div>
                  <div class="form-control-section mt-3">
                    <?php
                    if ($_SESSION['error'] != "") {
                      echo $_SESSION['error'];
                      $_SESSION['error'] = null;
                    } else {
                      echo $msg;
                      $_SESSION['success'] = null;
                    }
                    ?>
                    <p id="alertLoginMsg"></p>
                  </div>
                  <button name="submit" id='btn-login' class="btn btn-warning" onchange='check()'>Login</button>
                  <p class="text mt-3">Don't have an account? <a href="/register" class="link-primary text-decoration-none">Register</a></p>
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
        document.getElementById('btn-login').disabled = true;
        document.getElementById('alertLoginMsg').style.color = '#EE2B39';
        document.getElementById('alertLoginMsg').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number does not exist</span>';
      } else if (document.getElementById('account_num').value == '') {
        document.getElementById('btn-login').disabled = true;
        document.getElementById('alertLoginMsg').style.color = '#EE2B39';
        document.getElementById('alertLoginMsg').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number cannot be empty</span>';
      } else if (document.getElementById('account_num').value.length < 8) {
        document.getElementById('btn-login').disabled = true;
        document.getElementById('alertLoginMsg').style.color = '#EE2B39';
        document.getElementById('alertLoginMsg').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Account Number does not exist</span>';
      } else if (document.getElementById('password').value.length < 4) {
        document.getElementById('btn-login').disabled = true;
        document.getElementById('alertLoginMsg').style.color = '#EE2B39';
        document.getElementById('alertLoginMsg').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Password must be at least 4 charactors</span>';
      } else {
        if (document.getElementById('password').value == '') {
          document.getElementById('btn-login').disabled = true;
          document.getElementById('alertLoginMsg').style.color = '#EE2B39';
          document.getElementById('alertLoginMsg').innerHTML = '<span><i class="fas fa-exclamation-triangle"></i> Password cannot be empty</span>';
        } else {
          document.getElementById('btn-login').disabled = false;
          document.getElementById('alertLoginMsg').style.color = '';
          document.getElementById('alertLoginMsg').innerHTML = '';
        }
      }
    }
  </script>
</body>

</html>