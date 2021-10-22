<?php 
 include('header.php');
 include('nav-bar.php');
?>

<main class="mx-auto">
     <section id="listado" class="mb-5">
          
          <div class="container py-3">
          <h2 class="mb-4">Estudiantes </h2>
               <table id="dt-vertical-scroll" class="table  table-striped bg-primary text-white" cellspacing="0">

                    <?php
                    if (isset($message) && !empty($message)) {
                         #echo "<small>" . $message . "</small>";
                    ?>
                         <div class="container">
                              <div class="alert alert-info alert-dismissible fade show" role="alert">
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
              <th style="width: 15%;">First Name</th>
              <th style="width: 20%;">Last Name</th>
              <th style="width: 15%;">Dni</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 15%;">Phone Number</th>
              <th style="width: 10%;">Active</th>
              <th style="width: 10%;">Career</th>

            </tr>
          </thead>
          <tbody>
                <?php
                   

                   foreach ($studentList as $student)
                   {
                ?>
                          
                   <tr>
                   <td><?php echo $student->getFirstName() ?></td>
                   <td><?php echo $student->getLastName() ?></td>
                   <td><?php echo $student->getDni() ?></td>
                   <td><?php echo $student->getEmail() ?></td>
                   <td><?php echo $student->getPhoneNumber() ?></td>   
                   <td><?php if($student->getActive() == 1){ echo "Activo"; } else { echo "Inactivo"; }?></td>   
                   <td><?php echo $student->getCareer()->getDescription() ?> </td>         
                   </tr>
                <?php
                   }
                ?>        
          </tbody>
        </table>
          </div>
          <!-- <div class="container" style="display:flex; justify-content:flex-start">
               <a type="button" class="btn btn-light" href="<?php echo FRONT_ROOT . 'Student/Add' ?>">Listado de Cines</a>
          </div> -->
     </section>

     <main>

<?php 
  include('footer.php');
?>