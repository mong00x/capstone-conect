<?php 
include("includes.php");

?>

<!doctype html>
<html lang="en">
  <head>
      <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>HIT401- Group 1</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="./assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="./css/styles.css" rel="stylesheet" />
		<script src="./js/scripts.js"></script>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="./signin.css" rel="stylesheet">
  </head>
  <body class="text-center">
	  
	 
    <form class="form-signin" action="doLogin.php" method="post">
HIT401- Project management
  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
  <label for="inputEmail" class="sr-only">Email address</label>
  <input type="text" id="email" name="email" class="form-control" placeholder="Email address"  autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" id="pw" name="pw" class="form-control" placeholder="Password" >
  <button class="btn btn-lg btn-primary btn-block" type="submit" >Sign in</button><br><br>


	
</form>
	  
</body>
</html>
