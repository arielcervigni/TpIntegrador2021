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

    

   
}
?>