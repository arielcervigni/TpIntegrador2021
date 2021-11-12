<?php 

if(!isset($_SESSION["loggeduser"])){
     require_once(VIEWS_PATH."error.php");
 } else {
     include('header.php');
     include('nav-bar.php');
?>


<main class="mx-auto h-75">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Agregar Oferta de Trabajo</h2>
               <form action="<?php echo FRONT_ROOT . 'JobOffer/AddOffer' ?>" method="POST" class="bg-dark-alpha p-5">
                    <div class="row justify-content-start">
                    <?php
                         if(isset($message) && !empty($message))
                         {
                              ?>
                              <div class="container">
                                   <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $message ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                        </button>
                                   </div>
                              </div>
                              <?php
                         } 
                    ?>
                         
                         <div class="col-lg-6">
                              <label for="">Empresa:</label>
                              <div class="form-group">
                                   <select name="companyId" class="form-control">
                                        <option selected="true" disabled="disabled">Seleccione Empresa</option>
                                        <?php foreach($companyList as $company) { ?>
                                             <option value="<?php echo $company->getCompanyId() ?>"><?php echo $company->getDescription() ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Fecha límite:</label><br>
                                   <input style="width:100%;" type="date" name="endDate" value="<?php echo date("Y-m-d",strtotime(date("Y-m-d")."+ 7 days"));?>" required>
                              </div>
                         </div>

                         <!-- <div class="col-lg-6">
                              <div class="form-group ">
                                   <label for="">País:</label><br>
                                   <input style="width:100%;" type="text" name="country" size="100" placeholder="Ingrese país" value="" required>
                              </div>
                         </div> -->

                         <div class="col-lg-6">
                              <div class="form-group ">
                                   <label for="">Provincia:</label><br>
                                   <input style="width:100%;" type="text" name="province" size="100" placeholder="Ingrese provincia" value="" required>
                              </div>
                         </div>
                         
                         <div class="col-lg-6">
                              <div class="form-group ">
                                   <label for="">Ciudad:</label><br>
                                   <input style="width:100%;" type="text" name="city" size="100" placeholder="Ingrese ciudad" value="" required>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Modalidad:</label><br>
                                   <select name="modality" class="form-control">
                                        <option selected="true" disabled="disabled">Seleccione Modalidad</option>
                                        <option value="<?php echo "Presencial" ?>"><?php echo "Presencial" ?></option>
                                        <option value="<?php echo "Remoto" ?>"><?php echo "Remoto" ?></option>
                                        <option value="<?php echo "Híbrido" ?>"><?php echo "Híbrido" ?></option>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group ">
                                   <label for="">Disponibilidad:</label><br>
                                   <select name="availability" class="form-control">
                                        <option selected="true" disabled="disabled">Seleccione Disponibilidad</option>
                                        <option value="<?php echo "Part-Time" ?>"><?php echo "Part-Time" ?></option>
                                        <option value="<?php echo "Full-Time" ?>"><?php echo "Full-Time" ?></option>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <label for="">Posición Laboral:</label>
                              <div class="form-group">
                                   <select name="jobPosition" class="form-control">
                                        <option selected="true" disabled="disabled">Seleccione Una Posición Laboral</option>
                                        <?php foreach($jobPositionList as $jobPosition) { ?>
                                             <option value="<?php echo $jobPosition->getJobPositionId() ?>"><?php echo $jobPosition->getDescription() ?></option>
                                        <?php } ?>
                                   </select>
                              </div>
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Descripción:</label><br>
                                   <textarea style="width:100%; height: 100%;" type="text" name="description" placeholder="Ingrese una descripción" value="" required></textarea>
                              </div>
                         </div>

                    <button type="submit" name="button" value ="AGREGAR" class="btn btn-primary ml-auto d-block">Agregar Oferta</button>
                    </div>
               </form>
          </div>
     </section>
</main>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php 
   include('footer.php');
 }
?>

