
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

      <!-- Dropdown -->
      <!-- <?php if(!empty($_SESSION["loggeduser"])) { ?>  -->
                
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Menú</a>
          <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Login/ShowMyProfile">Mi perfil</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Career/ShowListView">Carreras</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>ManageCompany/ShowListView">Empresas</a>
            <!-- <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador"){ ?> -->
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>ManageCompany/ShowAddView">Agregar Empresa</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Estudiantes</a></a>
            <!-- <?php } ?> -->
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Home/Index">Salir</a>
          </div>
      </li>
        </li>
      <!-- <?php } ?> -->

    </ul>
    <!-- Links -->

  </div>
  <!-- Collapsible content -->
</div>
</nav>





<!-- <div class="wrapper row1">
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
</div> -->