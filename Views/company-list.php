<?php 
 if(!isset($_SESSION["loggeduser"])){
      require_once(VIEWS_PATH."error.php");
  } else {
      include('header.php');
      include('nav-bar.php');
?>

<main class="mx-auto">
<div> 
     <section id="listado" class="mb-5">
          
          <div class="container py-3">
          <h2 class="mb-4">Empresas </h2>
          <form action= <?php echo FRONT_ROOT ?>ManageCompany/SearchFilter method="post">
            <div class="input-group mb-3">
              <input type="text" name="word" class="form-control" placeholder="Ingrese una descripción para buscar" aria-label="" aria-describedby="basic-addon2">
            <!-- <div class="input-group-append"> -->
              <button class="btn btn-primary btn-sm" type="submit">Buscar</button>
            <!-- </div> -->
          </form>
          </div>
               <table id="dt-vertical-scroll" class="table  table-striped bg-primary text-white" cellspacing="0">

               <?php
                         if(isset($message) && !empty($message))
                         {
                              ?>
                              <div class="container">
                                   <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <?php echo $message ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                   </div>
                              </div>
                              <?php
                         } 
                    ?>

          <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>Cuit</th>
              <th style="width:40%;">Descripcion</th>
              <th style="width:40%;">Acerca de</th>
              <th>Link</th>
              <th>Active</th>
              <th colspan="3" style="text-align:center;">Acciones</th>
            </tr>
          </thead>
          <tbody>
                <?php
                   foreach ($companyList as $company)
                   {
                ?>
                          
                   <tr>
<<<<<<< HEAD
                   <td style="vertical-align: middle;"><?php echo $company->getCompanyId() ?></td>
                   <td style="vertical-align: middle;"><?php echo $company->getCuit() ?></td>
                   <td style="vertical-align: middle;"><?php echo $company->getDescription() ?></td>
                   <td style="vertical-align: middle;"><?php echo $company->getAboutUs() ?></td>
                   <td style="vertical-align: middle;"><?php echo $company->getCompanyLink() ?></td>  
                   <td style="vertical-align: middle;"><?php if($company->getActive() == 1){ echo "Activo"; } else { echo "Inactivo"; }?></td> 
=======
                   <td><?php echo $company->getCompanyId() ?></td>
                   <td><?php echo $company->getCuit() ?></td>
                   <td><?php echo $company->getDescription() ?></td>
                   <td><?php echo $company->getAboutUs() ?></td>
                   <td><?php echo $company->getCompanyLink() ?></td>  
                   <td><?php if($company->getActive() == 1){ echo "Activo"; } else { echo "Inactivo"; }?></td> 
>>>>>>> 4819705e884678ac4f10251da54e249958e27161
                   
                   <td>
                    <div class="btn-group">
                      <form action="<?php echo FRONT_ROOT . 'ManageCompany/ShowViewCompany' ?>" method="POST">
                      <button type="submit" value="<?php echo $company->getCompanyId() ?>" class="btn btn-light btn-sm" name="Ver">Ver</button>
<<<<<<< HEAD
                    </form>
                      <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
                      <form action="<?php echo FRONT_ROOT . 'ManageCompany/ShowModifyView' ?>" method="POST">
                      <button type="submit" value="<?php echo $company->getCompanyId() ?>" class="btn btn-warning btn-sm" name="Editar">Editar</button>
=======
                      </form>
                      <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
                      <form action="<?php echo FRONT_ROOT . 'ManageCompany/ShowModifyView' ?>" method="POST">
                        <button type="submit" value="<?php echo $company->getCompanyId() ?>" class="btn btn-warning btn-sm" name="Editar">Editar</button>
>>>>>>> 4819705e884678ac4f10251da54e249958e27161
                      </form>
                      <form action="<?php echo FRONT_ROOT . 'ManageCompany/RemoveItem' ?>" method="POST">
                        <button type="submit" value="<?php echo $company->getCompanyId() ?>" class="btn btn-danger btn-sm" name="Borrar">Borrar</button>
                      </form>
                      <?php } ?>
                    </div>  
                  <td> 
                   </tr>
                <?php
                   }
                ?>        
          </tbody>
        </table>
          </div>
          <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
          <div class="container" style="display:flex; justify-content:flex-start">
               <a type="button" class="btn btn-primary" href="<?php echo FRONT_ROOT . 'ManageCompany/ShowAddView' ?>">Agregar Empresa</a>
          </div>
          <?php } ?>
     </section>

     <main>

<?php 
  include('footer.php');
<<<<<<< HEAD
}
=======
>>>>>>> 4819705e884678ac4f10251da54e249958e27161
?>
