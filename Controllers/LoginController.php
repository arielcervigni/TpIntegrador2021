<?php
    namespace Controllers;

    use DAO\DAOS as DAOS;
    use DAO\StudentApiDAO as StudentApiDAO;
    use DAO\CareerApiDAO as CareerApiDAO;
    use Database\UserDAO as UserDAO;
    use Models\User as User;
    
    class LoginController
    {

        private $careerApiDAO;
        private $studentApiDAO;

        public function __construct()
    {
        $this->careerApiDAO = DAOS::getCareerApiDAO();
        $this->studentApiDAO = DAOS::getStudentApiDAO();
        $this->userDAO = new UserDAO();
    }

        public function ShowLogin($message = "")
        {
            require_once(VIEWS_PATH."login.php");
        }       

        public function ShowMyProfile($student = null) {
            //var_dump($student);
            if($student == null && $_SESSION["loggeduser"] != null)
                $student = $_SESSION["loggeduser"];
            
            //if(!empty($studentList) || !empty($careerList))
                require_once(VIEWS_PATH."my-profile.php");
            //else {
                //$_SESSION["loggeduser"] = null;
                //$message = "Error al conectar con el servidor (API).";
                //$this->ShowLogin($message);
            //}
        }

        function login ($email, $password) {
            $careerList = $this->careerApiDAO->GetAll();
            $studentList = $this->studentApiDAO->GetAll($careerList);
            $rta = 0;
            if(count($studentList) > 0){
                foreach ($studentList as $student){
                    if($student->getEmail() == $email && $student->getActive() == 1){
                        $user = $this->userDAO->Login($email,$password);
                        if(!empty($user)){
                           
                            if($user->getActive() == true)
                                $rta = 1;
                            else
                                $rta = 5;
                        }
                         else 
                            $rta = 3;
                           
                    } else if ($student->getEmail() == $email && $student->getActive() != 1)
                        $rta = 2;
                    
                }
                
            } else 
                $rta = 4;
            

            switch ($rta){
                case 0:
                    // No lo encuentra en la API
                    $message = "El email ingresado no se encuentra registrado.";
                    break;
                case 1:
                    // TODO OK
                    $_SESSION["loggeduser"] = $user;
                    $this->ShowMyProfile($student);
                    break;
                case 2: 
                    // No está activo en la API
                    $message = "El email ingresado no se encuentra activo.";
                    break;
                case 3:
                    // Pw incorrecto
                    $message = "La contraseña ingresada es incorrecta.";
                    break;
                case 4:
                    // Error al conectar la API
                    $message = "Error al conectar con el sitio. Revise su conexión y vuelva a intentarlo.";
                    break;
                case 5:
                    // El email está en la API, no tiene usuario.
                    $message = "El usuario no se encuentra registrado.";
                    break;
            }
            require_once (VIEWS_PATH."login.php");
        }
}
?>