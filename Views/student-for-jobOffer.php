<?php 

if(!isset($_SESSION["loggeduser"])){
     require_once(VIEWS_PATH."error.php");
 } else {
     include('header.php');
     include('nav-bar.php');
?>

<main class="mx-auto">
     <section id="listado" class="mb-5">
          
          <div class="container py-3">
          <h2 class="mb-4">Estudiantes postulados </h2>
               <table id="dt-vertical-scroll" class="table  table-striped bg-primary text-white" cellspacing="0">

                    <?php
                    if (isset($message) && !empty($message)) {
                         #echo "<small>" . $message . "</small>";
                    ?>
                         <div class="container">
                              <div class="alert alert-info alert-dismissible fade show" role="alert">
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
              <th style="width: 15%;">Nombre</th>
              <th style="width: 15%;">Apellido</th>
              <th style="width: 15%;">Dni</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 15%;">Tel</th>
              <th style="width: 15%;">Carrera</th>
              <th style="width: 15%;">CV</th>
              <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
              <th style="width: 15%;">Declinar</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
                <?php
               
               if(!empty($appointmentList)){
                foreach($appointmentList as $app) { ?>
                          
                   <tr>
                   <td><?php echo $app->getStudent()->getFirstName() ?></td>
                   <td><?php echo $app->getStudent()->getLastName() ?></td>
                   <td><?php echo $app->getStudent()->getDni() ?></td>
                   <td><?php echo $app->getStudent()->getEmail() ?></td>
                   <td><?php echo $app->getStudent()->getPhoneNumber() ?></td>   
                   <td><?php echo $app->getStudent()->getCareer()->getDescription() ?> </td>
                   <td><a class="btn btn-light btn-sm" href=<?php echo FRONT_ROOT.$app->getResume()?> target="_blank" rel="noopener noreferrer">Ver</a></td>
                   <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
                   <td>

                   <form action="<?php echo FRONT_ROOT . 'Appointment/Remove' ?>" method="POST">
                      
                      <button type="submit" value="<?php echo $app->getAppointmentId() ?>" class="btn btn-danger btn-sm" name="id">Declinar</button>
                      <input type="hidden" value="<?php echo $app->getjobOffer() ?>" name="jobOfferId">
                      <input type="hidden" value="<?php $app->getStudent()->getEmail() ?>" name="email">
                    </form>
                   </td>  
                   <?php } ?>    
                   </tr>
                <?php
                   }}
                ?>        
          </tbody>
        </table>
          <a type="button" class="btn btn-primary" href="<?php echo FRONT_ROOT . 'Home/Index' ?>">Ver Ofertas Laborales</a>
          </div>
          
     </section>

     <main>

<?php 
  include('footer.php');
 }
?>