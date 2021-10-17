<?php
namespace Controllers;

use DAO\DAOS as DAOS;
use DAO\StudentApiDAO as StudentApiDAO;
use Models\Student as Student;
use DAO\CareerApiDAO as CareerApiDAO;
use Models\Career as Career;

class StudentController
{
    private $studentApiDAO;
    private $careerApiDAO;

    public function __construct()
    {
        $this->careerApiDAO = DAOS::getCareerApiDAO();
        $this->studentApiDAO = DAOS::getStudentApiDAO();
    }

    public function ShowAddView ($message = "")
    {
        require_once(VIEWS_PATH."add-student.php");

    }

    public function ShowListView ($message = "")
    {
        $careerList = $this->careerApiDAO->GetAll();
        $studentList = $this->studentApiDAO->GetAll($careerList);
        require_once(VIEWS_PATH."student-list.php");
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
                require_once (VIEWS_PATH."home.php");
            } else if ($rta == 2){
                $message = "El email ingresado no se encuentra activo.";
                require_once (VIEWS_PATH."home.php");
            }

        } else {
            $message = "Error al conectar con el sitio. Revise su conexión y vuelva a intentarlo.";
            require_once (VIEWS_PATH."home.php");
        }
        
    }
}
?>