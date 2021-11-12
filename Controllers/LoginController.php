<?php
    namespace Controllers;

    use DAO\DAOS as DAOS;
    use DAO\StudentApiDAO as StudentApiDAO;
    use DAO\CareerApiDAO as CareerApiDAO;
    use Database\UserDAO as UserDAO;
    use Controllers\AppointmentController as AppointmentController;
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
            $jobOfferId = -1;
            if(intval($message) > 0)
            {
                $jobOfferId = $message;
                $message = "";
            } 
            require_once(VIEWS_PATH."login.php");
        }       

        public function ShowMyProfile($student = null) {

            if($_SESSION["loggeduser"]->getProfile() == "Estudiante") 
                require_once(VIEWS_PATH."my-profile.php");
            else {
                
                $user = $_SESSION["loggeduser"];
                require_once(VIEWS_PATH."view-user.php");
            } 


        }

        function login ($email, $password, $jobOfferId = -1) {
            $careerList = $this->careerApiDAO->GetAll();
            $studentList = $this->studentApiDAO->GetAll($careerList);
            $rta = 0;
            if(count($studentList) > 0){
                foreach ($studentList as $student){
                    if($student->getEmail() == $email && $student->getActive() == 1){
                        $user = $this->userDAO->Login($email,$password);
                        if(!empty($user)){
                          
                            if($user->getActive() == true){
                                $user->setStudent($student);
                                $rta = 1;
                            } else
                                $rta = 5;
                        } else 
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
                    $this->ShowLogin($message);
                    break;
                case 1:
                    // TODO OK
                    $_SESSION["loggeduser"] = $user;
                    
                    if(intval($jobOfferId) > 0){
                        if($user->getProfile() == "Estudiante"){
                            $appointmentController = new AppointmentController();
                            $appointmentController->ShowJobOffer($jobOfferId);
                        } else 
                            require_once(VIEWS_PATH."view-user.php");
                    } else 
                        $this->ShowMyProfile($user->getStudent());

                    break;
                case 2: 
                    // No está activo en la API
                    $message = "El email ingresado no se encuentra activo.";
                    $this->ShowLogin($message);
                    break;
                case 3:
                    // Pw incorrecto
                    $message = "La contraseña ingresada es incorrecta.";
                    $this->ShowLogin($message);
                    break;
                case 4:
                    // Error al conectar la API
                    $message = "Error al conectar con el sitio. Revise su conexión y vuelva a intentarlo.";
                    $this->ShowLogin($message);
                    break;
                case 5:
                    // El email está en la API, no tiene usuario.
                    $message = "El usuario no se encuentra registrado.";
                    $this->ShowLogin($message);
                    break;
            }
            
        }
}
?>