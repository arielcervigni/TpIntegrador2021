<?php 
    

    if(!isset($_SESSION["loggeduser"])){
      ?>
      <form id="login" action="<?php echo FRONT_ROOT . 'Login/ShowLogin' ?>" method="POST">
        <input type=hidden name="message" value="<?php echo $jobOffer->getJobOfferId() ?>"></input>

      </form>

      <script>
      window.onload=function(){
                  // Una vez cargada la página, el formulario se enviara automáticamente.
                document.forms["login"].submit();
      }
    </script>

      <?php 

      
    } else {
      include_once('header.php');
      include('nav-bar.php');
?>


  <main class="mx-auto h-75">
     <section id="listado" class="mb-5">
          <div class="container">
         
                  <?php
                      if(isset($message) && !empty($message)) { ?>
                          <div class="container">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              <?php echo $message ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                  <?php } ?>   

                <h2 class="mb-4">Postularme</h2>

                      <div class="card text-center" style="width:100%;">
                        <div class="card-header">
                            <?php echo $jobOffer->getJobPosition()->getDescription()  ?>
                        </div>
                      <div class="card-body">
                            <lebel class="card-title"><?php echo "Empresa: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getCompany()->getDescription() ?> </span>
                            <lebel class="card-title"><?php echo "Ubicación: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getCity() . " , " . $jobOffer->getProvince();?> </span><br><br>                        
                            <lebel class="card-title"><?php echo "Modalidad de trabajo: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getModality() . " , " . $jobOffer->getAvailability();?> </span> 
                            <lebel class="card-title"><?php echo "Fecha límite de postulación: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getEndDate();?> </span><br><br>
                            <lebel class="card-title"><?php echo "Más información: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getDescription() ?> </span><br><br>
                          

                            
                            <form action="<?php echo FRONT_ROOT . 'Appointment/New' ?>" method="POST" enctype="multipart/form-data">
                            <input type="file" name="resume" />
                            <input type="hidden" name="id" value="<?php echo $jobOffer->getJobOfferId() ?>"><br><br>
                            <lebel style="color:red";>Formato pdf, doc, docx. Tamaño máximo 5MB.</lebel><br>
                            <textarea type="text" style="margin-top:15px; width:60%; height: 100%;" name="description" placeholder="Querés agregar algo más?"></textarea><br>   
                            <button class="btn btn-primary" type="submit"> FINALIZAR POSTULACIÓN </button>
                            </form>
                               
                  
                          

                      </div>
                    </div>
                          <br><br>
               
          </div>
     </section>
     <div>
 <?php include('footer.php'); }  ?>
                </div>
                
  </main>

