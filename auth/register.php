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
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <style>
      body {
        overflow-y: hidden;
        overflow-x: hidden;
      }

      .custom-warning::placeholder {
        color: red !important;
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
        <a class="navbar-brand my-auto" href="../">
          <img src="../assets/vectors/MainLogo.svg" class="headerlogo" alt="MedclickLogo" />
        </a>
        <button class="navbar-toggler mr-n3 shadow9 bg-white border-0" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
          <ul class="navbar-nav  ml-auto">

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
    <div class="position-relative">
      <div class="position-absolute" style="left: 50px; z-index:-1">
        <img src="../assets/vectors/particle2.png" alt="" srcset="">
      </div>
      <div class="position-absolute" style="right: 50px; bottom:10px; z-index:-1">
        <img src="../assets/vectors/particle1.png" alt="" srcset="">
      </div>
      <div class="position-absolute" style="right: 50px; top:150px; z-index:-1">
        <img src="../assets/vectors/particle3.png" alt="" srcset="">
      </div>
    </div>
    <!-- Main Content -->
    <div class="d-flex">
      <div class="main-content">
        <div class="maintext">
          <h2>Hello !</h2>
        </div>
        <div class="subtext" id="subtext">Signup to make your admin account.</div>
        <div class="main-form">
          <form action="./authentication.php" method="POST" name="registerForm">
            <div class="form-group d-flex">
              <input type="text" class="form-control custom-control1" onblur="validate_name()" id="firstname" aria-describedby="emailHelp" placeholder="First Name" name="firstname" required />
              <input type="text" class="form-control custom-control1" id="lastname" onblur="validate_lname()" aria-describedby="emailHelp" placeholder="Last Name" name="lastname" required />
            </div>
            <div class="form-group d-flex">
              <input type="email" class="form-control custom-control1" onblur="validate_email()" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" required />
              <input type="number" class="form-control custom-control1" id="number" onblur="validate_mobile()" aria-describedby="emailHelp" placeholder="Enter Mobile" name="mobile" required />
            </div>
            <div class="form-group d-flex">
              <input type="password" class="form-control custom-control1" onblur="validate_password()" id="pass" aria-describedby="emailHelp" placeholder="Enter Password" name="password" required />
              <input type="password" class="form-control custom-control1" id="cpass" onblur="validate_confirm()" aria-describedby="emailHelp" placeholder="Enter Password Again" name="cpassword" required />
            </div>
            <div class="form-group d-flex" id="referalId">
              <a class="ml-3" onclick="checkReferal()">Apply Referal code</a>
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" name="checkBox" required />
              <label class="form-check-label" for="exampleCheck1">Agree Terms and conditions</label>
            </div>
            <button type="submit" name="registerSubmit" class="btn btn-primary button-sub">
              Sign Up
            </button>
          </form>
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Referal</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <center> <label class="form-check-label mx-auto">Enter the referal code of your friend</label></center>
                <input type="text" class="form-control custom-control1" onblur="referalCheck(this)" required />
                <span id="WebsiteError" style="display: none;" class="mt-2 ml-2 pl-4 text-danger"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                <span id="websiteSuccess" style="display: none;" class="mt-2 ml-2 pl-4 text-success"><i class="fa fa-check" aria-hidden="true"></i>
                </span>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal End -->
      <div class="ladyimg position-relative">
        <img src="../assets/vectors/registergirl.png" alt="ladyimg" srcset="" />
      </div>
    </div>

    <div class="background-login position-relative">
      <img src="../assets/vectors/backgroundregister.svg" class="position-absolute backgroundimg" alt="" srcset="" />
    </div>
    <script src="../assets/scripts/bootstrap.min.js"></script>
    <script src="../assets/scripts/app.js"></script>
    <!--Validation for first name and lastname-->
    <script>
      const checkReferal = () => {
        $('#exampleModal').modal('show');
      }
      const referalCheck = (e) => {
        let referal = e.value;
        $('#WebsiteError').css('display', 'none');
        $('#websiteSuccess').css('display', 'none');
        if (referal != "") {
          $.ajax({
            url: "./authentication.php",
            type: "POST",
            dataType: "json",
            data: {
              referalId: referal
            },
            success: function(data, status) {
              if (data.dataStatus == "true") {
                referal=data.referaluserId;
                $('#websiteSuccess').css('display', 'inline-block');
                $('#referalId').html(`<a class="ml-3 text-success">Referal Applied</a> <input type="hidden" name="referalId" value="${referal}">`);

              } else {
                $('#WebsiteError').css('display', 'inline-block');
              }
            }
          });
        }
      }

      function validate_name() {
        var name = document.forms["registerForm"]["firstname"];
        var pattern = /^[A-Za-z]+$/;
        if (name.value == "") {
          var error = "Please enter first name";
          document.getElementById("firstname").placeholder = error;
          document.getElementById("firstname").classList.add("custom-warning");
          name.focus();
          return false;
        } else if (name.value.match(pattern)) {
          document.getElementById("firstname").innerHTML = "";
          document.registerForm.lastname.focus();
          return true;
        } else {
          var error = "Invalid Name";
          document.getElementById("firstname").value = "";
          document.getElementById("firstname").placeholder = error;
          name.focus();
          return false;
        }
      }

      function validate_lname() {
        var name = document.forms["registerForm"]["lastname"];
        var pattern = /^[A-Za-z]+$/;
        if (name.value == "") {
          var error = "Please enter last name";
          document.getElementById("lastname").placeholder = error;
          document.getElementById("lastname").classList.add("custom-warning");
          name.focus();
          return false;
        } else if (name.value.match(pattern)) {
          document.getElementById("lastname").innerHTML = "";
          document.registerForm.email.focus();
          return true;
        } else {
          var error = "Invalid Name";
          document.getElementById("lastname").value = "";
          document.getElementById("lastname").placeholder = error;
          name.focus();
          return false;
        }
      }
      //validation for email
      function validate_email() {
        var gmail = document.forms["registerForm"]["email"];
        var pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
        if (gmail.value == "") {
          var error = "Please enter your email";
          document.getElementById("email").placeholder = error;
          document.getElementById("email").classList.add("custom-warning");
          document.form.email.focus();
          return false;
        } else if (gmail.value.match(pattern)) {
          document.getElementById("email").innerHTML = "";
          document.form.mobile.focus();
          return true;
        } else {
          document.getElementById("email").value = "";
          document.getElementById("email").placeholder = "Invalid email";
          document.form.email.focus();
          return false;
        }
      }
      //validation for phone
      function validate_mobile() {
        var name = document.forms["registerForm"]["mobile"];
        var pattern = /^\(?([1-9]{1})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{5})$/;
        if (name.value == "") {
          var error = "Please enter your mobile number";
          document.getElementById("number").placeholder = error;
          document.getElementById("number").classList.add("custom-warning");
          document.form.phone.focus();
          return false;
        } else if (name.value.match(pattern)) {
          document.getElementById("number").innerHTML = "";
          document.form.password.focus();
          return true;
        } else {
          document.getElementById("number").value = "";
          document.getElementById("number").placeholder = "Invalid mobile number";
          document.form.phone.focus();
          return false;
        }
      }
      //validation for password & confirm password

      function validate_password() {
        var name = document.forms["registerForm"]["password"];
        var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (name.value == "") {
          var error = "Please enter your password";
          document.getElementById("pass").placeholder = error;
          document.getElementById("pass").classList.add("custom-warning");
          document.form.password.focus();
          return false;
        } else if (name.value.match(pattern)) {
          document.getElementById("pass").innerHTML = "";
          document.form.cpassword.focus();
          return true;
        } else {
          document.getElementById("pass").value = "";
          document.getElementById("pass").placeholder = "Invalid password";
          document.form.password.focus();
          return false;
        }
      }

      function validate_confirm() {
        var name1 = document.forms["registerForm"]["password"];
        var name2 = document.forms["registerForm"]["cpassword"];

        if (name2.value == "") {
          var error = "Please enter password";
          document.getElementById("cpass").placeholder = error;
          document.getElementById("cpass").classList.add("custom-warning");
          document.form.cpassword.focus();
          return false;
        } else if (name1.value == name2.value) {
          document.getElementById("cpass").innerHTML = "";
          document.form.checkBox.focus();
          return true;
        } else {
          document.getElementById("cpass").value = "";
          document.getElementById("cpass").placeholder = "Password doesnot match";
          document.form.cpassword.focus();
          return false;
        }
      }
    </script>

  </body>

  </html>
<?php
}
?>