<!-- Header -->
<?php
    require "header.php";
?>
  <!-- Masthead -->
  <header class="masthead text-white text-center">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-9 mx-auto">
          <h1 class="mb-5">Cerca la tua barca</h1>
        </div>
        <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
          <form action="./dashboard.php" method="POST">
            <div class="form-row">
              <div class="col-12 col-md-9 mb-2 mb-md-0">
                <input type="search" name="search" class="form-control form-control-lg" placeholder="Cerca le barche disponibili più vicine a te">
              </div>
              <div class="col-12 col-md-3">
                <button type="submit" class="btn btn-block btn-lg btn-primary">Search</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </header>

  <!-- Icons Grid -->
  <section class="features-icons bg-light text-center">
    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <a href="https://www.ilmeteo.it/Italia?" target="_blank" class="m-auto"><i class="icon-screen-desktop text-primary"></i></a>
            </div>
            <h3>Meteo</h3>
            <p class="lead mb-0">Controlla il meteo prima di partire!</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <i class="icon-star m-auto text-primary"></i>
            </div>
            <h3>Premium</h3>
            <p class="lead mb-0">Scopri tutti i vantaggi nel diventare un utente Premium!</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-icons-item mx-auto mb-0 mb-lg-3">
            <div class="features-icons-icon d-flex">
              <?php
                if(isset($_SESSION['userId'])){
                  echo'<a href="./show_profile.php" class="m-auto"><i class="icon-check text-primary"></i></a>';
                }
                else {
                  echo'<a href="./login.php" class="m-auto"><i class="icon-check text-primary"></i></a>';
                }
              ?>
            </div>
            <h3>Newsletter</h3>
            <p class="lead mb-0">Ricevi notizie sugli ultimi annunci pubblicati.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Image Showcases -->
  <section class="showcase">
    <div class="container-fluid p-0">
      <div class="row no-gutters">

        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/index-img-2.jpg');"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Com'è nata la nostra idea</h2>
          <p class="lead mb-0">L'idea è nata dalla voglia di andare in barca sempre alla scoperta di nuovi luoghi e nuove compagnie.</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 text-white showcase-img" style="background-image: url('img/index-img-1.jpg');"></div>
        <div class="col-lg-6 my-auto showcase-text">
          <h2>Chi siamo</h2>
          <p class="lead mb-0">Siamo un gruppo di una persona, studente universitario di Genova.</p>
        </div>
      </div>
      <div class="row no-gutters">
        <div class="col-lg-6 order-lg-2 text-white showcase-img" style="background-image: url('img/index-img-3.jpg');"></div>
        <div class="col-lg-6 order-lg-1 my-auto showcase-text">
          <h2>Progetti per il futuro</h2>
          <p class="lead mb-0">Il nostro obiettivo è quello di espanderci anche in "acque" internazionali.</p>
        </div>
      </div>
    </div>
  </section>

<!--Footer-->
<?php 
    require "footer.php";
?>