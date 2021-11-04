
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
  
    <?php if(!isset($_SESSION["loggeduser"])) { ?> 
      <li class="nav-item">
        <a class="nav-link" href="<?php echo FRONT_ROOT. "Login/ShowLogin"?>">Iniciar Sesión</a>
      </li>
      
      <!-- Dropdown -->
      <?php } else { ?> 
        <li class="nav-item">
          <a class="nav-link" href="<?php echo FRONT_ROOT ?>Home/Index">Cerrar Sesión</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">Menú</a>
          <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Login/ShowMyProfile">Mi perfil</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Career/ShowListView">Carreras</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>ManageCompany/ShowListView">Empresas</a>
            <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador"){ ?>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>ManageCompany/ShowAddView">Agregar Empresa</a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>Student/ShowListView">Estudiantes</a></a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>JobPosition/ShowListView">Posiciones de trabajo</a></a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>NewUser/ShowAddView">Registrar Usuario</a></a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>NewUser/ShowAdminAddView">Registrar Administrador</a></a>
            <a class="dropdown-item" href="<?php echo FRONT_ROOT ?>NewUser/ShowListView">Mostrar Usuarios</a></a>
              <?php } ?>
            
          </div>
      </li>
        </li>
      <?php } ?>

    </ul>
    <!-- Links -->

  </div>
  <!-- Collapsible content -->
</div>
</nav>
