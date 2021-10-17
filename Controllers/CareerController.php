<?php
namespace Controllers;

use DAO\DAOS as DAOS;
use DAO\CareerApiDAO as CareerApiDAO;
use Models\Career as Career;

class CareerController
{
    private $careerApiDAO;

    public function __construct()
    {
        $this->careerApiDAO = DAOS::getCareerApiDAO();
    }

   
    public function ShowListView ($message = "")
    {
        $careerList = $this->careerApiDAO->getCareers();
        require_once(VIEWS_PATH."career-list.php");
    }

}
?>