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
               <h2 class="mb-4">Modificar Usuario </h2>
               
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
                         
                         
                         <form action=<?php echo FRONT_ROOT ?>NewUser/Modify method="POST">
                         
                              <div class="row justify-content-start">
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Nombre:</label><br>
                                             <input style="width:100%;" type="text" placeholder="Nombre" name="firstName" value="<?php if($user != null) echo $user->getStudent()->getFirstName(); else echo ""; ?>" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Apellido:</label><br>
                                             <input style="width:100%;" type="text" placeholder="Apellido" name="lastName" value="<?php if($user != null) echo $user->getStudent()->getLastName(); else echo ""; ?>" required>
                                        </div>
                                   </div>
                              
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Email:</label><br>
                                             <input style="width:100%;" type="text" name="email" size="100" placeholder="Email" value="<?php if($user != null) echo $user->getStudent()->getEmail(); else echo ""; ?>" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Teléfono:</label><br>
                                             <input style="width:100%;" type="text" name="phone" size="15" placeholder="Teléfono" value="<?php if($user != null) echo $user->getStudent()->getPhoneNumber(); else echo ""; ?>" required>
                                        </div>
                                   </div>      
                                   
                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Contraseña:</label><br>
                                             <input style="width:100%;" type="password" name="password" size="10" placeholder="Ingrese su contraseña" value="<?php if($user != null) echo $user->getPassword(); else echo ""; ?>" required>
                                        </div>
                                   </div>

                                   <div class="col-lg-6">
                                        <div class="form-group">
                                             <label for="">Confirme Contraseña:</label><br>
                                             <input style="width:100%;" type="password" name="confirmPassword" size="10" placeholder="Ingrese nuevamente su contraseña" value="<?php if($user != null) echo $user->getPassword(); else echo ""; ?>" required>
                                        </div>
                                   </div>       

                                   <input style="width:100%;" type="hidden" name="profile" value="<?php if($user != null) echo $user->getProfile(); else echo ""; ?>" readonly>

                                   <a type="button" class="btn btn-secondary" href="<?php echo FRONT_ROOT . 'NewUser/ShowListView' ?>">Ver Usuarios</a>
                                   <!-- <form action="<?php echo FRONT_ROOT . 'NewUser/RemoveItem' ?>" method="POST">
                                   <button type="submit" value="<?php echo $user->getUserId() ?>" class="btn btn-danger ml-auto d-block" name="Borrar">Borrar</button>
                                   </form> -->
                                   <button type="submit" name="button" value ="<?php echo $userId; ?>" class="btn btn-primary ml-auto d-block">Guardar</button>
                                   
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

    