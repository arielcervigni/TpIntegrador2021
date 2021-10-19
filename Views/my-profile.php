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
               <h2 class="mb-4">Mi Perfil </h2>
               <form action="" method="POST" class="bg-dark-alpha p-5">
                    <div class="row justify-content-start">

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Id Estudiante:</label>
                                   <br>
                                   <input style="width:100%" type="number" name="studentId" size="11" value="<?php echo $student->getStudentId() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group ">
                                   <label for="">Carrera:</label><br>
                                   <input style="width:100%" type="text" name="career" size="11" value="<?php echo $student->getCareer()->getDescription() ?>" disabled>
                              </div>
                         </div>
                         
                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Nombre:</label><br>
                                   <input style="width:100%" type="text" name="firstName" value="<?php echo $student->getfirstName() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Apellido:</label><br>
                                   <input style="width:100%" type="text" name="lastName" value="<?php echo $student->getlastName() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">DNI:</label><br>
                                   <input style="width:100%" type="text" name="dni" value="<?php echo $student->getDni() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">N° Archivo:</label><br>
                                   <input style="width:100%" type="text" name="fileNumber" value="<?php echo $student->getFileNumber() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Género:</label><br>
                                   <input style="width:100%" type="text" name="gendre" value="<?php echo $student->getGender() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Fecha de Nacimiento</label><br>
                                   <input style="width:100%" type="text" name="birthDate" value="<?php echo $student->getBirthDate() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Email:</label><br>
                                   <input style="width:100%" type="text" name="email" value="<?php echo $student->getEmail() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">N° Teléfono:</label><br>
                                   <input style="width:100%" type="text" name="phoneNumber" value="<?php echo $student->getPhoneNumber() ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Activo:</label><br>
                                   <input style="width:100%" type="text" name="active" value="<?php if($student->getActive() == 1) echo "Activo"; else echo "Inactivo"; ?>" disabled>
                              </div>
                         </div>

                         <div class="col-lg-6">
                              <div class="form-group">
                                   <label for="">Perfil:</label><br>
                                   <input style="width:100%" type="text" name="profile" value="<?php echo $student->getProfile() ?>" disabled>
                              </div>
                         </div>
                        
                         
                         
                    </div>
</form> 
          </div>
     </section>
</main>
<br><br><br><br><br><br>
<?php 
  
  include('footer.php');
 }
?>

    