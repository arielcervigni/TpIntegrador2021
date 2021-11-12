<?php
namespace Controllers;

use DAO\DAOS as DAOS;
use DAO\JobPositionApiDAO as JobPositionApiDAO;


class JobPositionController
{
    private $jobPositionApiDAO;

    public function __construct()
    {
        $this->jobPositionApiDAO = DAOS::getJobPositionApiDAO();
    }


    public function ShowListView ($message = "")
    {
        $jobPoisitionList = $this->jobPositionApiDAO->GetAll();
        //var_dump($jobPoisitionList);
        require_once(VIEWS_PATH."student-list.php");
    }

    

   
}
?>