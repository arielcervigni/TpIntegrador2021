<?php 
 include('header.php');
 include('nav-bar.php');
?>

<div class="wrapper row4">
  <main class="hoc container clear"> 
    <!-- main body -->
    <h2>LISTA DE EMPRESAS: </h2>
    <?php 
      if (isset($message))
        echo $message;
        ?>
    <div class="content"> 
      <div class="scrollable">
      
      <form action= <?php echo FRONT_ROOT ?>Company/ShowViewView method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 5%;">CompanyID</th>
              <th style="width: 15%;">Cuit</th>
              <th style="width: 25%;">Descripcion</th>
              <th style="width: 35%;">Acerca de</th>
              <th style="width: 15%;">Link</th>
              <th style="width: 5%;">Active</th>
              <th style="width: 10%;">Ver</th>
            </tr>
          </thead>
          <tbody>
                <?php
                   foreach ($companyList as $company)
                   {
                ?>
                          
                   <tr>
                   <td><?php echo $company->getCompanyId() ?></td>
                   <td><?php echo $company->getCuit() ?></td>
                   <td><?php echo $company->getDescription() ?></td>
                   <td><?php echo $company->getAboutUs() ?></td>
                   <td><?php echo $company->getCompanyLink() ?></td>  
                   <td><?php echo $company->getActive() ?></td>  
                   <td><button type="submit" class="btn" value="<?php echo $company->getCompanyId()?>" name="view"> Ver </button></td>
                   
                   <!-- <td><button type="submit" class="btn" value="<?php echo $company->getCompanyId()?>" name="remove"> Eliminar </button></td> -->
                   <!-- <td><button type="submit" class="btn" value="<?php echo $company->getCuit()?>" name="modify"> Modificar </button></td> -->
                   
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