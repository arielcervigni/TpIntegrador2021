<?php 
    include_once('header.php');
    include('nav-bar.php');
?>


<main class="">
  <div class="container text-center table loginTable  w-100" style="padding:0px;">

    <form action="<?php echo FRONT_ROOT . 'Login/login' ?>" method="POST" class="login-form bg-dark-alpha p-5 mx-auto text-white">

      <div class="form-group" text-align="center">
        <div class="col userIconCol">
          <span id="userIcon"><i class="far fa-user"></i></span>
        </div>
      </div>

      <div class="form-group inputContainer">
        <input type="text" name="username" class="form-control form-control-lg logInInputs" placeholder="Ingrese su email" required>

      </div>


      <div class="form-group inputContainer">
        <input type="password" name="password" class="form-control form-control-lg logInInputs" placeholder="Ingrese constraseña" required>

      </div>

      <input type="hidden" name="jobOffer" value="<?php echo $jobOfferId; ?>">
      <?php
      if (isset($message) && !empty($message)) {
        #echo "<small>" . $message . "</small>";
      ?>
        <div class="container">
          <?php if($message == "Usuario agregado con éxito."){ ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php } else { ?> 
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php } ?>
            <?php echo $message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      <?php } ?>
      <button class="btn btn-primary w-50 loginBoton" type="submit">Iniciar Sesión</button>
      
      <a type="button" class="btn btn-danger" href="<?php echo FRONT_ROOT . 'NewUser/ShowAddView' ?>">Registrarse</a>
      
      <br>
    </form>
    
  </div>
</main>

<?php 
   include('footer.php');
?>