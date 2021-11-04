<?php 

 if(!isset($_SESSION["loggeduser"])){
     require_once(VIEWS_PATH."error.php");
 } else {
     include('header.php');
     include('nav-bar.php');
?>

<main class="mx-auto">
     <section id="listado" class="mb-5">
          
          <div class="container py-3">
          <h2 class="mb-4">Carreras </h2>
               <table id="dt-vertical-scroll" class="table  table-striped bg-primary text-white" cellspacing="0">
<<<<<<< HEAD

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

=======

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

>>>>>>> 4819705e884678ac4f10251da54e249958e27161
          <thead class="thead-dark">
            <tr>
              <th style="width: 10%;">CareerID</th>
              <th style="width: 70%;">Descripcion</th>
              <th style="width: 20%;">Active</th>
              <!-- <th style="width: 10%;">Ver</th> -->
            </tr>
          </thead>
          <tbody>
                <?php
                   //var_dump($careerList);
                   if($_SESSION["loggeduser"]->getProfile() != "Administrador"){
                     $companyListActive = array();
                      foreach($careerList as $career)
                      {
                        if($career->getActive() == 1)
                          array_push($companyListActive,$career);
                      }
                      $careerList = $companyListActive;
                   }
                     
                   foreach ($careerList as $career)
                   {
                ?>       
                   <tr>
                      <td><?php echo $career->getCareerId() ?></td>
                      <td><?php echo $career->getDescription() ?></td>  
                      <td><?php if($career->getActive() == 1){ echo "Activo"; } else { echo "Inactivo"; }?></td>  
                      <!-- <input onclick="location.href='ShowAddView'" type="button" class="btn" value="Modificar" style="background-color:#DC8E47;color:white;"/></td>               -->
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
  }
?>