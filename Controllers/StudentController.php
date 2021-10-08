<?php
namespace Controllers;


use DAO\StudentDAO as StudentDAO;
use Models\Student as Student;

class StudentController
{
    private $studentDAO;

    public function __construct()
    {
        $this->studentDAO = new StudentDAO();
    }

    public function ShowAddView ($message = "")
    {
        require_once(VIEWS_PATH."add-student.php");

    }

    public function ShowListView ($message = "")
    {
        $studentList = $this->studentDAO->getAll();
        require_once(VIEWS_PATH."student-list.php");
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
}
?>