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
        $this->careerApiDAO = new CareerApiDAO();
    }

   
    public function ShowListView ($message = "")
    {
        $careerList = $this->careerApiDAO->GetAll();
        require_once(VIEWS_PATH."career-list.php");
    }

}
?>