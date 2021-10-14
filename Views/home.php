<?php 
    include_once('header.php');
?>
<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1>TP Integrador 2021</h1>
    </div>
    <!-- <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Actions</a>
          <ul>
            <li><a href="">ADD</a></li>
            <li><a href="">LIST/REMOVE</a></li>
      </ul>
    </nav> -->
  </header>
</div>
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="#">Bienvenido!</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- #######################################################################3 -->
<div>
  <div class="wrapper row3 img-login">
      <div class="div-login"><br>
        <h1 class="text-login">Ingresa tu email para iniciar sesión. </h1>
      </div>
    <div class="div-login">  

      <form action="<?php echo FRONT_ROOT ?>Student/login" method="post">
          <input class="input-login" type="text" name="email" placeholder="Email" required>
          <!-- <input class="input-login" type="password" name="password" placeholder="Contraseña" required> -->
          <br><button class="btn-login btn" type="submit" name="">Ingresar</button><br>
          <br>
          <br>
        </form>
          <?php 
          if (isset($message))
            echo $message;
          ?>
          <br>
          <br>
    </div>
  </div>
</div>
