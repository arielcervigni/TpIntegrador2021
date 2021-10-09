<?php 
 include('header.php');
 include('nav-bar.php');
?>
<!-- ################################################################################################ 
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="<?php echo FRONT_ROOT ?>Company/ShowAddView">Add Company</a></li> 
        <li><a href="<?php echo FRONT_ROOT ?>Student/ShowListView">LIST/REMOVE</a></li>
        <li><a href="<?php echo FRONT_ROOT ?>Home/Index">CLOSE</a></li>>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="hoc container clear"> 
  <h2>LISTA DE ESTUDIANTES</h2>
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action= <?php echo FRONT_ROOT ?>Cellphone/RemoveItem method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 15%;">First Name</th>
              <th style="width: 30%;">Last Name</th>
              <th style="width: 30%;">Dni</th>
              <th style="width: 15%;">Email</th>
              <th style="width: 10%;">Phone Number</th>
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
                   </tr>
                <?php
                   }
                ?>        
          </tbody>
        </table>
        <input onclick="location.href='ShowAddView'" type="button" class="btn" value="ADD" style="background-color:#DC8E47;color:white;"/>
        </form> 
      </div>
      <?php 
      if (isset($message))
        echo $message;
        ?>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>