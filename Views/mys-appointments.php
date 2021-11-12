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
          <h2 class="mb-4">Mis postulaciones </h2>
          
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
              <th style="width:20%;">Empresa</th>
              <th style="width:20%;">Puesto Laboral</th>
              <th style="width:20%;">Modalidad</th>
              <th style="width:15%;">Fecha Fin</th>
              <th style="width:15%;">CV</th>
              <th style="width:15%;">Comentario</th>
            </tr>
          </thead>
          <tbody> 
                <?php
                if(empty($appointmentList))
                  $message = "No hay postulaciones para mostrar.";
                else{
                   foreach ($appointmentList as $appointment){
                    
                ?>
                          
                   <tr>
                   <td style="vertical-align: middle;"><?php echo $appointment->getJobOffer()->getCompany()->getDescription() ?></td>
                   <td style="vertical-align: middle;"><?php echo $appointment->getJobOffer()->getJobPosition()->getDescription() ?></td>
                   <td style="vertical-align: middle;"><?php echo $appointment->getJobOffer()->getModality() ?></td>
                   <td style="vertical-align: middle;"><?php echo $appointment->getJobOffer()->getEndDate() ?></td>
                   <td style="vertical-align: middle;"><?php echo $appointment->getResume() ?></td>
                   <td style="vertical-align: middle;"><?php echo $appointment->getDescription() ?></td>
                   </tr>
                <?php
                   }
                  }
                ?>        
          </tbody>
        </table>
          </div>
     </section>

     <main>

<?php 
  include('footer.php');
}
?>
