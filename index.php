<?php
require_once "conn.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email    = $_POST['email'] ?? '';
  $password = $_POST['password'] ?? '';
  // echo "<pre>";
  // print_r($_POST);
  // exit(' CALL');
  $sql    = "SELECT * FROM auth_data WHERE email='$email'";
  $result = mysqli_query($con, $sql);
  $data   = [];

  if (mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // echo "<pre>";
    // print_r($data);
    // exit(' CALL');
    if (isset($data['stutas']) && $data['stutas'] == '1') {
      if (password_verify($password, $data['password'])) {

        $_SESSION['id']   = $data['id'];
        $_SESSION['name'] = $data['name'];
        header("Location:dashbored.php");
      } else {
        $_SESSION['flash_message'] = "Your Username And Password is incorrect";
        $_SESSION['flash_type']    = "error";
        // echo "Your Username And Password is incorrect";
      }
    } else {
      // echo "This user is block";
      $_SESSION['flash_message'] = "This user is block";
      $_SESSION['flash_type']    = "warning";
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
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

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <?php
        if (isset($_SESSION['flash_message'])) {
          $message = $_SESSION['flash_message'];
          $type    = $_SESSION['flash_type'];
          unset($_SESSION['flash_message']);
          unset($_SESSION['flash_type']);
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="myform">
          <div class="input-group mt-3 email">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mt-3 pass">
            <input type="password" class="form-control" placeholder="Password" name="password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
            <!-- /.col -->
            <!-- <div class="col-4">
            <a href="registration.php" type="submit" class="btn btn-primary btn-block">Sign In</a>
          </div> -->
            <!-- /.col -->
          </div>


          <div class="social-auth-links text-center mb-3">
            <!-- <p>- OR -</p> -->
            <button type="submit" class="btn btn-block btn-primary">
              <i class="fab fa-facebook mr-2"></i> Login
            </button>
            <a href="registration.php" class="btn btn-block btn-danger">
              <i class="fab fa-google-plus mr-2"></i>Regiter
            </a>
          </div>
        </form>
        <!-- /.social-auth-links -->

        <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

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
    var message = '<?php echo $message ?? ""?>';
    var type    = '<?php echo $type ?? ""?>';
    if(message){
      if(type == 'error'){
        toastr.error(message);
      }else if(type == 'warning'){
        toastr.info(message);
      }
    }
    $("#myform").validate({
      rules: {
        email: {
          required: true
        },
        password: {
          required: true
        },
      },
      errorPlacement: function(error, element) {
        if (element.attr("type") == "email") {
          error.insertAfter('.email');
        } else if (element.attr("type") == "password") {
          error.insertAfter('.pass');
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