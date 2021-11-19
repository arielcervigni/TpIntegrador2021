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
               <h2 class="mb-4">Nuevo Administrador </h2>
               
               <div class="bg-dark-alpha p-5">
                    <div class="row justify-content-start">

                         <?php
                              if(isset($message) && !empty($message))
                              {
                                   ?>
                                   <div class="container">
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                             <?php echo $message;?>
                                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                             </button>
                                        </div>
                                   </div>
                                   <?php
                              } 
                         ?>

                         <br><br>
                         
                         
                         <form action=<?php echo FRONT_ROOT ?>NewUser/AddUser method="POST">
                         
                              <div class="row justify-content-start">
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Nombre:</label><br>
                                             <input style="width:100%;" type="text" placeholder="Nombre" name="firstName" value="<?php echo $firstName; ?>" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Apellido:</label><br>
                                             <input style="width:100%;" type="text" placeholder="Apellido" name="lastName" value="<?php echo $lastName; ?>"" required>
                                        </div>
                                   </div>
                              
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Email:</label><br>
                                             <input style="width:100%;" type="text" name="email" size="100" placeholder="Email" value="<?php echo $email; ?>"" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Teléfono:</label><br>
                                             <input style="width:100%;" type="text" name="phone" size="15" placeholder="Teléfono" value="<?php echo $phoneNumber; ?>"" required>
                                        </div>
                                   </div>      
                                   
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Contraseña:</label><span style="color:#FF0000;">Mínimo 6 caracteres.</span><br>
                                             <input style="width:100%;" type="password" name="password" size="10" placeholder="Ingrese su contraseña" value="" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Confirme Contraseña:</label><br>
                                             <input style="width:100%;" type="password" name="confirmPassword" size="10" placeholder="Ingrese nuevamente su contraseña" value="" required>
                                        </div>
                                   </div>       

                                   <input type="hidden" value="-1" name="companyId"></input>

                                   <a type="button" class="btn btn-success" href="<?php echo FRONT_ROOT . 'NewUser/ShowAddUserCompanyView' ?>">Nuevo Usuario Empresa</a>
                                   <a type="button" class="btn btn-secondary" href="<?php echo FRONT_ROOT . 'NewUser/ShowListView' ?>">Ver Usuarios</a>
                                   <a type="button" class="btn btn-danger" href="<?php echo FRONT_ROOT . 'NewUser/ShowAddView' ?>">Nuevo Usuario</a>
                                   <button type="submit" name="button" value ="Administrador" class="btn btn-primary ml-auto d-block">Agregar Administrador</button>
                                   
                              </form> 
                              <div>
                              </div>
                         </div>    
                    </div>
               </div>
          </div>
     </section>
</main>
<br><br><br><br><br><br>
<?php 
  
  include('footer.php');
 }
?>

    