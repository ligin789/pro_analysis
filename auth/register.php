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
    <title>Pro Analysis | Register</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/vectors/Logo.svg">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <style>
      body {
        overflow-y: hidden;
        overflow-x: hidden;
      }
    </style>
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
          <img src="../assets/vectors/MainLogo.svg" class="headerlogo" alt="MedclickLogo" />
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
            <li class="btn nav-item mx-3">
              <a href="./"><button>Sign in</button></a>
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
          <h2>Hello !</h2>
        </div>
        <div class="subtext">Signup to make your admin account.</div>
        <div class="main-form">
          <form action="./authentication.php" method="POST">
            <div class="form-group d-flex">
              <input type="text" class="form-control custom-control1" id="firstname" aria-describedby="emailHelp" placeholder="First Name" name="firstname" required />
              <input type="text" class="form-control custom-control1" id="lastname" aria-describedby="emailHelp" placeholder="Last Name" name="lastname" required />
            </div>
            <div class="form-group d-flex">
              <input type="email" class="form-control custom-control1" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" required />
              <input type="number" class="form-control custom-control1" id="number" aria-describedby="emailHelp" placeholder="Enter Mobile" name="mobile" required />
            </div>
            <div class="form-group d-flex">
              <input type="password" class="form-control custom-control1" id="pass" aria-describedby="emailHelp" placeholder="Enter Password" name="password" required />
              <input type="password" class="form-control custom-control1" id="cpass" aria-describedby="emailHelp" placeholder="Enter Password Again" name="cpassword" required />
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" required />
              <label class="form-check-label" for="exampleCheck1">Agree Terms and conditions</label>
            </div>
            <button type="submit" name="registerSubmit" class="btn btn-primary button-sub">
              Sign Up
            </button>
          </form>
        </div>
      </div>
      <div class="ladyimg position-relative">
        <img src="../assets/vectors/registergirl.png" alt="ladyimg" srcset="" />
      </div>
    </div>

    <div class="background-login position-relative">
      <img src="../assets/vectors/backgroundregister.svg" class="position-absolute backgroundimg" alt="" srcset="" />
    </div>
    <script src="../assets/scripts/bootstrap.min.js"></script>
  </body>

  </html>
<?php
}
?>