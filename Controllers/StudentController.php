<?php
namespace Controllers;


use DAO\StudentDAO as StudentDAO;
use DAO\StudentApiDAO as StudentApiDAO;
use Models\Student as Student;

class StudentController
{
    private $studentDAO;
    private $studentApiDAO;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
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

    public function RemoveItem ($remove)
    {
        echo $remove;
        $cellphoneList = $this->cellphoneDAO->getAll();
        
        
        $pos = $this->buscarCode ($cellphoneList, $remove);
        
        if ($pos != -1)
        {
            //echo "Posicion:" . $pos;
            unset($cellphoneList[$pos]);
        }
    
        
        $this->cellphoneDAO->setCellphoneList($cellphoneList);
        $cellphoneList = $this->cellphoneDAO->getCellphoneList($cellphoneList);
        $this->cellphoneDAO->saveData();
        
        if(count($cellphoneList) == 0)
        {
            $message = "No hay celulares para mostrar";
            $this->ShowListView($message);
        }
        else
        $this->ShowListView();
            
        
        
        
    

    }

    public function buscarCode ($array, $code)
    {
        $i = 0;
        $rta = -1;
        while ($i < count($array))
        {
            if($code == $array[$i]->getCode() )
            {
                $rta = $i;
                break;
            }
            else
                $i++;
        }
        return $rta;
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
                    
                }       
            }
            
            if($rta == 0)
            {
                $message = "El email ingresado no se encuentra registrado.";
                require_once (VIEWS_PATH."home.php");
            }

        } else {
            $message = "Error al conectar con el sitio. Revise su conexión y vuelva a intentarlo.";
            require_once (VIEWS_PATH."home.php");
        }
        
    }
}
?>