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
               <h2 class="mb-4">Modificar Empresa</h2>
               <form action="<?php echo FRONT_ROOT . 'ManageCompany/Modify' ?>" method="POST" class="bg-dark-alpha p-5">
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
                    
                    
                    

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Cuit:</label>
                                   <br>
                                   <input style="width:100%;" type="text" name="cuit" size="11" placeholder="11 dígitos sin espacios" value="<?php echo $cuit?>" required>
                              </div>
                              
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group ">
                                   <label for="">Descripción:</label><br>
                                   <input style="width:100%;" type="text" name="description" size="100" placeholder="Nombre de la empresa" value="<?php echo $description?>" required>
                              </div>
                         </div>
                         
                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Acerca de:</label><br>
                                   <input style="width:100%;" type="text" name="aboutUs" size="300" placeholder="Breve resumen de la empresa"  value="<?php echo $aboutUs?>" required>
                              </div>
                         </div>

                         <div class="col-lg-12">
                              <div class="form-group">
                                   <label for="">Link de la Empresa:</label><br>
                                   <input style="width:100%;" type="text" name="companyLink" size="" placeholder="Sitio web o Linkedin" value="<?php echo $companyLink?>" required>
                              </div>
                         </div>
                        
                         <input type="hidden" name="companyId" value="<?php echo $companyId ?>">
                         
                    </div>
                    <button type="submit" name="button" value ="" class="btn btn-primary ml-auto d-block">Guardar Empresas</button>
               </form>
          </div>
     </section>
</main>

<?php 
  include('footer.php');
<<<<<<< HEAD
}
=======
>>>>>>> 4819705e884678ac4f10251da54e249958e27161
?>
