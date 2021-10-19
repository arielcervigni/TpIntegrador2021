<?php
    namespace Controllers;

    class HomeController
    {
        public function Index($message = "")
        {
            if(isset($_SESSION["loggeduser"])){
                unset($_SESSION["loggeduser"]);
            }
            require_once(VIEWS_PATH."home.php");
        }

    }
?>