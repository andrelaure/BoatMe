<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>BoatMe-Home</title>

  <!-- Bootstrap -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
 
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Style -->
  <link href="css/landing-page.css" rel="stylesheet">
  <link href="css/mystyle.css" rel="stylesheet">
  <link href="css/pagination_style.css" rel="stylesheet">
  <link href="css/dropmenu_style.css" rel="stylesheet">

  
  <script src="./js/jquery-3.6.0.js"></script>

</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">BoatMe</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="aboutus.php">About us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">Bacheca</a>
        </li>
        <?php
      if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
          session_start();
      }

      if(isset($_SESSION['userId'])){
        echo '
        <li class="nav-item dropdown">       
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-circle"></i>
          </a>
          <div class="dropdown-menu pull-right" aria-labelledby="navbarDropdown">            
            <a class="dropdown-item" href="show_profile.php">Profilo Personale</a>            
            <a class="dropdown-item" href="my_boats.php">Le mie Barche</a>         
            <a class="dropdown-item" href="my_announcement.php">I miei Annunci</a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="php/logout.php">Esci</a>
          </div>
        </li>';
      }
      else{
        echo '        
        <li class="nav-item">
          <a class="nav-link" href="login.php">Accedi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Registrati</a>
        </li>';
      }

    ?>
      </ul>
      <form action="./dashboard.php" method="POST" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cerca barca" aria-label="Search">
        <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" name="submit">Search</button>
      </form>
    </div>
  </nav>





