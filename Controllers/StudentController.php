<?php
namespace Controllers;


use DAO\StudentApiDAO as StudentApiDAO;
use Models\Student as Student;

class StudentController
{
    private $studentApiDAO;

    public function __construct()
    {
        $this->studentApiDAO = new StudentApiDAO();
    }

    public function ShowAddView ($message = "")
    {
        require_once(VIEWS_PATH."add-student.php");

    }

    public function ShowListView ($message = "")
    {
        $studentList = $this->studentApiDAO->GetStudents();
        require_once(VIEWS_PATH."student-list.php");
    }

    public function ShowMyProfile($student = null) {
        if($student == null && $_SESSION["loggeduser"] != null)
            $student = $_SESSION["loggeduser"];
        require_once(VIEWS_PATH."my-profile.php");
    }

    function login ($email) {
        $studentList = $this->studentApiDAO->GetStudents();
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