<?php 
    include_once('header.php');
    // include('nav-bar.php');
?>
<nav class="navbar navbar-expand-lg navbar-dark primary-color">

<div class="container">
  <!-- Navbar brand -->
  <a class="navbar-brand js-scroll-trigger" href="<?php  echo FRONT_ROOT . "Home/Index"   ?>">
    <i class="fas fa-book-reader"></i><span class="nameHeader text-white">Ofertas Laborales</span>
  </a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav ml-auto">
  
      
      <li class="nav-item">
        <a class="nav-link" href="<?php echo FRONT_ROOT. "Login/ShowLogin"?>">Iniciar Sesión</a>
      </li>

    </ul>
  </div>
</nav>

<main class="">
  <div class="container text-center table loginTable  w-100" style="padding:0px;">

    <form action="<?php echo FRONT_ROOT . 'Login/login' ?>" method="POST" class="login-form bg-dark-alpha p-5 mx-auto text-white">

      <div class="form-group" text-align="center">
        <div class="col userIconCol">
          <span id="userIcon"><i class="far fa-user"></i></span>
        </div>
      </div>

      <div class="form-group inputContainer">
        <input type="text" name="username" class="form-control form-control-lg logInInputs" placeholder="Ingrese su email">

      </div>


      <!-- <div class="form-group inputContainer">
        <input type="password" name="password" class="form-control form-control-lg logInInputs" placeholder="Ingrese constraseña">

      </div> -->
      <?php
      if (isset($message) && !empty($message)) {
        #echo "<small>" . $message . "</small>";
      ?>
        <div class="container">
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      <?php
      }
      ?>
      <button class="btn btn-primary w-50 loginBoton" type="submit">Iniciar Sesión</button>
      <br>
    </form>
    
  </div>
</main>