<?php
require_once "conn.php";
session_start();
$id = $_GET['id'] ?? '';
$data = [];
if ($id) {
  $sql = "SELECT * FROM auth_data WHERE id='$id'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
  }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id       = $_POST['id'] ?? '';
  $name     = $_POST['name'] ?? '';
  $email    = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';

  $password_hash = "";
  if ($password) {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
  }
  // echo "<pre>";
  // print_r($_POST);
  // exit();

  if ($id) {
    if ($password_hash) {
      $sql = "UPDATE auth_data SET name='$name',email='$email',password='$password_hash' WHERE id='$id'";
    } else {
      $sql = "UPDATE auth_data SET name='$name',email='$email' WHERE id='$id'";
    }
  } else {
    $sql = "INSERT INTO auth_data (name,email,password) VALUES ('$name','$email','$password_hash')";
  }

  if (mysqli_query($con, $sql)) {
    // echo "insert user";
    $_SESSION['flash_message'] = "User Add Successfully";
    $_SESSION['flash_type']    = "success";
    header("refresh:3;url=index.php");
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Registration Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="./plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
  <style>
    .error {
      color: red;
    }
  </style>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="index2.html"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>
        <?php
        if (isset($_SESSION['flash_message'])) {
          $message = $_SESSION['flash_message'];
          $type    = $_SESSION['flash_type'];
          unset($_SESSION['flash_message']);
          unset($_SESSION['flash_type']);
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="myform">
          <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
          <div class="input-group in1">
            <input type="text" class="form-control" placeholder="Full name" name="name" value="<?php echo $data['name'] ?? '' ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mt-3 email">
            <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $data['email'] ?? '' ?>">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mt-3 pass">
            <input type="password" class="form-control password" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mt-3 com-pass">
            <input type="password" class="form-control" placeholder="Retype password" name="com_password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div>
        </div> -->


          <div class="social-auth-links text-center mt-3">
            <!-- <p>- OR -</p> -->
            <button type="submit" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Register
            </button>
            <a href="index.php" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i> Login
            </a>
          </div>
        </form>

        <!-- <a href="login.html" class="text-center">I already have a membership</a> -->
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="./plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="./dist/js/adminlte.min.js"></script>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js" integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script>
  $(document).ready(function() {
    var message = '<?php echo $message ?? "" ?>'
    var type    = '<?php echo $type ?? "" ?>'

    if (message) {
      if (type == 'success') {
        toastr.success(message);
      }
    }
    $("#myform").validate({
      rules: {
        name: {
          required: true
        },
        email: {
          required: true
        },
        password: {
          required: function() {
            if ($("#id").val()) {
              return false;
            } else {
              return true;
            }
          }
        },
        com_password: {
          required: function() {
            if ($("#id").val()) {
              return false;
            } else {
              return true;
            }
          },
          equalTo: ".password"
        },
      },
      errorPlacement: function(error, element) {
        if (element.attr("type") == "text") {
          error.insertAfter('.in1');
        } else if (element.attr("type") == "email") {
          error.insertAfter('.email');
        } else if (element.attr("name") == "password") {
          error.insertAfter('.pass');
        } else if (element.attr("name") == "com_password") {
          error.insertAfter('.com-pass');
        } else {
          error.insertAfter($(element));
        }
      },
      submitHandler: function() {
        return true;
      }
    });
  });
</script>