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

                <h2 class="mb-4">Ofertas de Trabajo</h2>

                <div style="margin-bottom: 20px;" class="bg-dark-alpha p-2" >
                  <form action="<?php echo FRONT_ROOT . 'Home/Index' ?>" method="POST" enctype="multipart/form-data">
                    <div class="row justify-content-start">   
                  
                      <div class="col-lg-5">                
                        <div class="form-group">
                          <lebel>Carrera: </lebel>  
                            <select id="career"name="carrer" class="form-control" onchange="this.submit">
                              <option selected="true" value= "all" >Todas las carreras</option>
                                  <?php foreach($careerList as $career) { ?>
                                    <option value="<?php echo $career->getCareerId() ?>"><?php echo $career->getDescription() ?></option>
                                  <?php } ?>
                            </select>
                        </div>
                      </div>
              
              
                      <div class="col-lg-5">                
                        <div class="form-group">
                          <lebel>Posición Laboral: </lebel>     
                            <select id="jobPosition" name="jobPosition" class="form-control">
                              <option selected="true" value= "all" >Todas las posiciones laborales</option>
                                <?php foreach($jobPositionList as $jobPosition) { ?>
                                  <option data-tag="<?php echo $jobPosition->getCareerId() ?> "value="<?php echo $jobPosition->getJobPositionId() ?>"><?php echo $jobPosition->getDescription() ?></option>
                                <?php } ?>
                            </select>
                        </div>
                      </div>

                      <div class="col-lg-2">
                        <button class="btn btn-primary btn-sm" type="submit"> Aplicar Filtro </button>
                      </div>
                    </div>
                  </form>
               </div>
               
               
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
                          
                          <!-- <a href="#" class="btn btn-primary">Postularme</a> -->
                          <form action="<?php echo FRONT_ROOT . 'Appointment/ShowJobOffer' ?>" method="POST">
                              <button type="submit" value="<?php echo $jobOffer->getJobOfferId() ?>" class="btn btn-primary" name="Borrar"><?php if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == "Administrador") echo "Ver Postulantes"; else echo "Postularme"; ?> </button>
                          </form>
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

