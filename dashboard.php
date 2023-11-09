<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/21274dacb7.js" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  <title>Dashboard</title>
</head>

<body>

  <?php

  include 'config.php';
  $AccountNo = $_SESSION['acc_num'];
  if ($AccountNo == "") {
    header("location: http://localhost/php-portal/login");
  } else if (strlen($AccountNo) < 8) {
    header("location: http://localhost/php-portal/login");
  } else {
    $ses_sql = mysqli_query($conn, "SELECT * FROM balance b, users p WHERE (p.acc_num = b.Account) and p.acc_num = '$AccountNo'");

    while ($rows = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC)) {
      if ($rows['Account'] == $AccountNo) {
  ?>

        <div class="container form-control p-4 mt-5">
          <h1 class="">Municipality Of Beitbridge</h1>
          <div class="row">
            <!--<div class="col-md-1"></div>-->
            <div class="col-md-6 mt-3">
              <section>
                <h3>Account Details</h3>
                <div class="login-form-bd">
                  <div class="form-wrapper">
                    <div class="form-container">
                      <form method='post' action="">
                        <table class="table table-striped">
                          <tbody>
                            <tr>
                              <td>Name</td>
                              <td>: <?php echo $rows['Name']; ?></td>
                            </tr>
                            <tr>
                              <td>Phone Number</td>
                              <td>: 0<?php echo $rows['Telephone']; ?></td>
                            </tr>
                            <tr>
                              <td>House Number</td>
                              <td>: <?php echo $rows['Physical1']; ?></td>
                            </tr>
                            <tr>
                              <td>Location</td>
                              <td>: <?php echo $rows['Physical2']; ?></td>
                            </tr>
                            <tr>
                              <td>Town</td>
                              <td>: <?php echo $rows['Physical3']; ?></td>
                            </tr>
                            <tr>
                              <td>Account Number</td>
                              <td>: <?php echo $rows['acc_num']; ?></td>
                            </tr>
                            <tr>
                              <td>Balance</td>
                              <td>: <?php if ($rows['DCBalance'] <= 0) {
                                      echo "<sec style='color:green'>ZWL" . $rows['DCBalance'] . "</sec>";
                                    } else {
                                      echo "<sec style='color:red'>ZWL" . $rows['DCBalance'] . "</sec>";
                                    }; ?></td>
                            </tr>
                          </tbody>
                        </table>
                        <center><button class="btn btn-warning mt-3 col-md-4" type="submit" value="Logout" name="logout">Logout</button></center>
                        <?php
                        if (isset($_POST['logout'])) {
                          session_destroy();
                          header("location: http://localhost/php-portal/login");
                        }
                        ?>
                      </form>

                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="col-md-6 mt-3">
              <h3>PayNow</h3>
              <iframe src="https://www.topup.co.zw/billpay/widget/municipality-of-beitbridge?iframe=true" style="width: 100%;height:350px;"></iframe>
            </div>
          </div>
        </div>




  <?php
      } else {
        session_destroy();
        header("location: http://localhost/php-portal/login");
      }
    }
  }
  ?>

</body>

</html>