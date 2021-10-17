<?php
    namespace Controllers;

    use DAO\DAOS as DAOS;
    use DAO\StudentApiDAO as StudentApiDAO;
    use DAO\CareerApiDAO as CareerApiDAO;

    class LoginController
    {

        private $careerApiDAO;
        private $studentApiDAO;

        public function __construct()
    {
        $this->careerApiDAO = DAOS::getCareerApiDAO();
        $this->studentApiDAO = DAOS::getStudentApiDAO();
    }

        public function ShowLogin($message = "")
        {
            require_once(VIEWS_PATH."login.php");
        }       

        public function ShowMyProfile($student = null) {
            //var_dump($student->getCareer()->getDescription());
            if($student == null && $_SESSION["loggeduser"] != null)
                $student = $_SESSION["loggeduser"];
            require_once(VIEWS_PATH."my-profile.php");
        }

        function login ($email) {
            $careerList = $this->careerApiDAO->GetAll();
            $studentList = $this->studentApiDAO->GetAll($careerList);
            $rta = 0;
            if(count($studentList) > 0){
                foreach ($studentList as $student){
                    if($student->getEmail() == $email && $student->getActive() == 1){
                        $rta = 1;
                        $_SESSION["loggeduser"] = $student;
                        
                        $this->ShowMyProfile($student);
                        
                    } else if ($student->getActive() != 1){
                        $rta = 2;
                    }      
                }
                
                if($rta == 0)
                {
                    $message = "El email ingresado no se encuentra registrado.";
                    require_once (VIEWS_PATH."login.php");
                } else if ($rta == 2){
                    $message = "El email ingresado no se encuentra activo.";
                    require_once (VIEWS_PATH."login.php");
                }

            } else {
                $message = "Error al conectar con el sitio. Revise su conexión y vuelva a intentarlo.";
                require_once (VIEWS_PATH."login.php");
            }
            
        }
}
?>