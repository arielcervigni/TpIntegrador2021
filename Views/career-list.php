<?php 
 include('header.php');
 include('nav-bar.php');
?>

<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <h2>LISTA DE CARRERAS: </h2>
    <?php 
      if (isset($message))
        echo $message;
        ?>
    
    <!-- <div class="content" style="width:100%"> 
        <form style="width:100%" action= <?php echo FRONT_ROOT ?>Careers/SearchFilter method="post">
            <div style="width:70%">
              <input type="text" name="word" size="" placeholder="Ingrese una palabra" value=""> 
            </div>
            <div style="width:30% ">
              <input type="submit" class="btn" value="BUSCAR" name="search"></input>  
            </div>
        </form>
      </div> -->

    <div class="content"> 
      <div class="scrollable">
      
      <form action= <?php echo FRONT_ROOT ?>Career/ShowViewView method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 33%;">CareerID</th>
              <th style="width: 34%;">Descripcion</th>
              <th style="width: 33%;">Active</th>
              <!-- <th style="width: 10%;">Ver</th> -->
            </tr>
          </thead>
          <tbody>
                <?php
                   //var_dump($careerList);
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
        <?php if($_SESSION["loggeduser"]->getProfile() == "Administrador") {?>
          <input onclick="location.href='ShowAddView'" type="button" class="btn" value="AGREGAR" style="background-color:#DC8E47;color:white;"/>
        <?php }?>  
      </form> 
      </div>
      
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>