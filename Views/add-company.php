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
        <li><a href="<?php echo FRONT_ROOT ?>Company/ShowListView">Company List/Remove</a></li>
        <li><a href="<?php echo FRONT_ROOT ?>Student/ShowListView">LIST/REMOVE</a></li>
        <li><a href="<?php echo FRONT_ROOT ?>Home/Index">CLOSE</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>AGREGAR UNA NUEVA EMPRESA</h2>

        <?php 
          if(isset($message)){
              echo $message;
          }
          
        ?>  
        
        <form action=<?php echo FRONT_ROOT ?>Company/AddIDUnico method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
        <table> 
            <tbody align="center">
            

            <input type="hidden" name="companyId" value="">

                <tr style="max-width: 100px;">
                  <div>
                    <label for="">CUIT:</label>
                    <input type="text" name="cuit" size="11" placeholder="11 dígitos sin espacios" value="" required>
                  </div>
                </tr>
                <tr>
                  <div>
                    <label for="">Descripción:</label>
                    <input type="text" name="description" size="100" placeholder="Nombre de la empresa" value="" required>
                  </div>
                </tr>
                <tr>
                  <div>
                    <label for="">Acerca de nosotros:</label>
                    <input type="text" name="aboutUs" size="300" placeholder="Breve resumen de la empresa"  value="" required>
                  </div>
                </tr>     
                <tr>
                  <div>
                    <label for="">  Link de la empresa:</label>
                    <input type="text" name="companyLink" size="" placeholder="Sitio web o Linkedin" value="" required>
                  </div>
                </tr>         
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="AGREGAR" style="background-color:#DC8E47;color:white;"/>
            <form action=<?php echo FRONT_ROOT ?>Student/ShowListView method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
              <input type="submit" class="btn" value="ELIMINAR" style="background-color:#DC8E47;color:white;" disabled/>  
            </form>
            <input onclick="location.href='ShowListView'"  type="submit" class="btn" value="VER LISTA" style="background-color:#DC8E47;color:white;"/>

          </div>
        </form>
      </div>
        
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php 
  include('footer.php');
?>