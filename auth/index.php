<?php
session_start();
include('../cred/dbConnect.php');
if (isset($_SESSION["proAnalysisSession"]) == session_id()) {
    header("Location: ../dashboard.php");
    die();
} else {
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pro Analysis | Login</title>
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/vectors/Logo.svg">
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
  <!-- Header Navbar -->
  <div id="navbar-wrapper" class="sticky-top position-relative">
    <nav class="
          navbar navbar-expand-lg navbar-light
          mt-2
          col-11 col-xl-10
          mx-auto
        ">
      <a class="navbar-brand my-auto" href="#">
        <img src="../assets/vectors/MainLogo.svg" class="headerlogo" alt="Pro Analysis Logo" />
      </a>
      <button class="navbar-toggler mr-n3 shadow9 bg-white border-0" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item mx-3">
            <a class="nav-link active" id="home" onclick="menuClick(this.id)" href="#">What We Offer</a>
          </li>

          <li class="nav-item mx-3">
            <a class="nav-link" id="contactUs" onclick="menuClick(this.id)" href="#contactUsSection">About us</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link" id="roadmap" onclick="menuClick(this.id)" href="#roadmap">Why ProAnalysis</a>
          </li>
          <li class="nav-item mx-3">
            <a class="nav-link" id="packges" onclick="menuClick(this.id)" href="#roadmap">Packages</a>
          </li>
          <li class="nav-item mx-3">
            <a href="./register.php"><button>Sign up</button></a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <!-- Header Navbar End -->
    <!-- Alert for Register -->
    <?php
  if (isset($_SESSION['loginMessage'])) {
    echo "<center><div class='alert bg-danger text-light alert-dismissible fade show col-4' role='alert'>
                                <center><strong>" . $_SESSION['loginMessage'] . "</strong></center>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                            </div></center>";
    unset($_SESSION['loginMessage']);
  }

  ?>
  <!-- Main Content -->
  <div class="d-flex">
    <div class="main-content">
      <div class="maintext">
        <h2>Welcome Back !</h2>
      </div>
      <div class="subtext">Login to Stay Connected.</div>
      <div class="main-form">
        <form action="./authentication.php" method="POST">
          <div class="form-group">
            <input type="email" class="form-control custom-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
          </div>
          <div class="form-group">
            <input type="password" class="form-control custom-control" id="exampleInputPassword1" placeholder="Password" name="password" />
          </div>
          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" />
            <label class="form-check-label" for="exampleCheck1">Remember me</label>
          </div>
          <button type="submit" class="btn btn-primary button-sub" name="loginSubmit">
            Sign In
          </button>
        </form>
      </div>
    </div>
    <div class="ladyimg position-relative">
      <img src="../assets/vectors/loginGirl.png" alt="ladyimg" srcset="" />
    </div>
  </div>

  <div class="background-login position-relative">
    <img src="../assets/vectors/backgroundlogin.svg" class="position-absolute backgroundimg" alt="" srcset="" />
  </div>
  <script src="../assets/scripts/bootstrap.min.js"></script>

</body>

</html>
<?php
}
?>