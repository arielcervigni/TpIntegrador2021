<div class="wrapper row1">
  <header id="header" class="clear"> 
    <div id="logo" class="fl_left">
      <h1>Tp Integrador 2021</h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a class="drop" href="#">Menu</a>
          <ul>
          <li><a href="<?php echo FRONT_ROOT ?>Login/ShowMyProfile">MI PERFIL</a></li>
          <li><a href="<?php echo FRONT_ROOT ?>ManageCompany/ShowListView">EMPRESAS</a></li>
          <li><a href="<?php echo FRONT_ROOT ?>Career/ShowListView">CARRERAS</a></li>
          <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador"){ ?>
              <li><a href="<?php echo FRONT_ROOT ?>ManageCompany/ShowAddView">AGREGAR EMPRESA</a></li> 
              <li><a href="<?php echo FRONT_ROOT ?>Student/ShowListView">ESTUDIANTES</a></li>
          <?php } else { ?>
              
          <?php } ?>
          <li><a href="<?php echo FRONT_ROOT ?>Home/Index">SALIR</a></li>
        </ul>
    </nav>
  </header>
</div>