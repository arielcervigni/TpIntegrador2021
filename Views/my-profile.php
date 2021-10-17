<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ 
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="<?php echo FRONT_ROOT ?>ManageCompany/ShowAddView">Add Company</a></li> 
        <li><a href="<?php echo FRONT_ROOT ?>Student/ShowListView">LIST/REMOVE</a></li>
        <li><a href="<?php echo FRONT_ROOT ?>Home/Index">CLOSE</a></li>>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
  <h2>MI PERFIL</h2>
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
     
          <table> 
            <tbody align="left">
            <tr style="max-width: 50px;">
              <td>
                <label for="">ID de Estudiante:</label>
                <input style="width:100%" type="number" name="studentId" size="11" value="<?php echo $student->getStudentId() ?>" disabled>
              </td>
              <td>
                <label for="">Carrera:</label>
                <input style="width:100%" type="text" name="career" size="11" value="<?php echo $student->getCareer()->getDescription() ?>" disabled>
              </td>
            </tr> 

            <tr style="max-width: 50px;">
              <td>
                <label for="">Nombre:</label>
                <input style="width:100%" type="text" name="firstName" value="<?php echo $student->getfirstName() ?>" disabled>
              </td>
              <td>
                <label for="">Apellido</label>
                <input style="width:100%" type="text" name="lastName" value="<?php echo $student->getlastName() ?>" disabled>
              </td>
            </tr> 

            <tr style="max-width: 50px;">
              <td>
                <label for="">DNI:</label>
                <input style="width:100%" type="text" name="dni" value="<?php echo $student->getDni() ?>" disabled>
              </td>
              <td>
                <label for="">N° Archivo:</label>
                <input style="width:100%" type="text" name="fileNumber" value="<?php echo $student->getFileNumber() ?>" disabled>
              </td>
            </tr> 

            <tr style="max-width: 50px;">
              <td>
                <label for="">Genero:</label>
                <input style="width:100%" type="text" name="gendre" value="<?php echo $student->getGender() ?>" disabled>
              </td>
              <td>
                <label for="">Fecha de Nacimiento:</label>
                <input style="width:100%" type="text" name="birthDate" value="<?php echo $student->getBirthDate() ?>" disabled>
              </td>
            </tr> 

            <tr style="max-width: 50px;">
              <td>
                <label for="">Email:</label>
                <input style="width:100%" type="text" name="email" value="<?php echo $student->getEmail() ?>" disabled>
              </td>
              <td>
                <label for="">N° Telefono:</label>
                <input style="width:100%" type="text" name="phoneNumber" value="<?php echo $student->getPhoneNumber() ?>" disabled>
              </td>
            </tr> 

            <tr style="max-width: 50px;">
              <td>
                <label for="">Activo:</label>
                <input style="width:100%" type="text" name="active" value="<?php if($student->getActive() == 1) echo "Activo"; else echo "Inactivo"; ?>" disabled>
              </td>
              <td>
                <label for="">Perfil:</label>
                <input style="width:100%" type="text" name="profile" value="<?php echo $student->getProfile() ?>" disabled>
              </td>
            </tr> 

      </tbody>
          </table>

      
      
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>