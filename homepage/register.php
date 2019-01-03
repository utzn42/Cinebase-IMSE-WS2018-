<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cinebase</title>
  <link rel="stylesheet"
        type="text/css"
        href="css/main.css"/>
  <script src="js/main.js"></script>
</head>
<body>
<div class="wrapper">
  <div class="topLine" id="topLine">
    cinebase
    <button onclick="window.location='index.php';"
            style="margin-left: 20px"
            class="buttonBig">Home
    </button>
    <button onclick="window.location='movies.php';" class="buttonBig">Movies</button>
    <button onclick="window.location='screening.php';" class="buttonBig">Screenings</button>
    <button onclick="window.location='news.php';" class="buttonBig">News</button>
    <button onclick="window.location='aboutUs.php';" class="buttonBig">About Us</button>
    <button id="signIn" onclick="document.getElementById('popUpLogin').style.display='block'"
            class="buttonLogin">
      Sign In
    </button>
    <button style="border-bottom: 2px solid whitesmoke; font-weight: bold" id="register"
            class="buttonRegister">Register
    </button>
  </div>
</div>

<!-- Start of the part taken from: https://www.w3schools.com/howto/howto_css_signup_form.asp -->
<div class="register" id="popUpRegister">
  <span onclick="window.location='index.php'" class="close" title="Close Modal">&times;</span>
  <form action="index.php" method="post">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label for="email"><b>Email</b></label>
      <input class="signInInputs" type="text" placeholder="Enter Email" name="email" required>

      <label for="password"><b>Password</b></label>
      <input class="signInInputs" type="password" placeholder="Enter Password" name="password"
             required>

      <label for="passwordRepeat"><b>Repeat Password</b></label>
      <input class="signInInputs" type="password" placeholder="Repeat Password"
             name="passwordRepeat" required>

      <label>
        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
        Remember me
      </label>

      <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms &
          Privacy</a>.</p>

      <div class="clearfix">
        <button type="submit" class="buttonLoginModal">Sign Up</button>
      </div>
    </div>
  </form>
</div>
<!-- End of the part taken from: https://www.w3schools.com/howto/howto_css_signup_form.asp -->


<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<p style="text-align:center">Yasin Ergüven Utz Nisslmüller Alexander Ramharter Oliver
  Schweiger</p>

</body>
</html>