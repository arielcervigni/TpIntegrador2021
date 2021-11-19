<?php 
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

                <h2 class="mb-4">Ofertas de Trabajo de <?php echo $company->getDescription()?>.</h2>

                  
                <?php foreach ($jobOfferList as $jobOffer) { ?>
                      <div class="card text-center" style="width:100%;">
                        <div class="card-header">
                            <?php echo $jobOffer->getJobPosition()->getDescription()  ?>
                        </div>
                      <div class="card-body">
                            <lebel class="card-title"><?php echo "Empresa: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getCompany()->getDescription() ?> </span><br><br>
                            <lebel class="card-title"><?php echo "Ubicación: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getCity() . " , " . $jobOffer->getProvince();?> </span><br><br>                        
                            <lebel class="card-title"><?php echo "Modalidad de trabajo: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getModality() . " , " . $jobOffer->getAvailability();?> </span><br><br> 
                            <lebel class="card-title"><?php echo "Fecha límite de postulación: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getEndDate();?> </span><br><br>
                            <lebel class="card-title"><?php echo "Más información: "; ?></lebel><span class="card-text"> <?php echo $jobOffer->getDescription() ?> </span><br><br>
                          
                            <div class="btn-group">
                              <?php if(isset($_SESSION["loggeduser"])) { 
	
                                      if($_SESSION["loggeduser"]->getProfile() == "Company") { ?>
                                        <form action="<?php echo FRONT_ROOT . 'Appointment/ShowJobOffer' ?>" method="POST">
                                                                <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" 
                                                                    name="Borrar"><?php echo "Postulaciones";?> </button>
                                                                </form>
                                      <?php } else if($_SESSION["loggeduser"]->getProfile() == "Administrador") { ?>
                                      
                                            <form action="<?php echo FRONT_ROOT . 'Appointment/ShowJobOffer' ?>" method="POST">
                                                                <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" 
                                                                    name="Borrar"><?php echo "Postulaciones";?> </button>
                                                                </form>

                                            <form action="<?php echo FRONT_ROOT . 'JobOffer/ShowModifyView' ?>" method="POST">
                                                                <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-dark" 
                                                                  name="Edit"> Editar </button>
                                                                </form>

                                            <form action="<?php echo FRONT_ROOT . 'JobOffer/Remove' ?>" method="POST">
                                                                <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-danger" 
                                                                  name="Eliminar"> Eliminar </button>
                                                                </form>
                                      <?php } else { ?>
                                        
                                            <form action="<?php echo FRONT_ROOT . 'Appointment/ShowJobOffer' ?>" method="POST">
                                            <?php if($btnDisabled) { ?>   
                                              <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" 
                                                  name="Borrar" disabled><?php echo "Postularme"; ?> </button>
                                            <?php } else { ?>
                                               <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" 
                                                   name="Borrar"><?php echo "Postularme"; ?> </button>
                                            <?php } ?>
                                            </form>
                                       <?php } ?>

                          <?php } else { ?>
                              <form action="<?php echo FRONT_ROOT . 'Appointment/ShowJobOffer' ?>" method="POST">
                              <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" 
                                                          name="Borrar"><?php echo "Postularme"; ?> </button>
                              </form>
                          <?php } ?>
                          </div>
                      </div>
                    </div>
                          <br><br>
                <?php } ?>
               
          </div>
     </section>
     <div>
 <?php include('footer.php'); ?>
                </div>
                
  </main>

