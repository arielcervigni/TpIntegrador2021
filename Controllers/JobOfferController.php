<?php
namespace Controllers;

use DAO\DAOS as DAOS;
use DAO\CareerApiDAO as CareerApiDAO;
use Models\Career as Career;
use Database\JobOfferDAO as JobOfferDAO;
use Models\JobOffer as JobOffer;
use DAO\JobPositionApiDAO as JobPositionApiDAO;
use Models\JobPosition as JobPosition;
use Database\CompanyDAO as CompanyDAO;
use Database\AppointmentDAO as AppointmentDAO;
use Models\Company as Company;
use Controllers\HomeController as HomeController;
use DAO\StudentApiDAO as StudentApiDAO;

class JobOfferController
{
    private $careerApiDAO;
    private $companyDAO;
    private $jobPositionApiDAO;
    private $jobOfferDAO;
    private $studentApiDAO;
    private $appointmentDAO;

    public function __construct()
    {
        $this->careerApiDAO = new CareerApiDAO();
        $this->companyDAO = new CompanyDAO();
        $this->jobPositionApiDAO = new JobPositionApiDAO();
        $this->jobOfferDAO = new JobOfferDAO();
        $this->studentApiDAO = new StudentApiDAO();
        $this->appointmentDAO = new AppointmentDAO();
    }

    public function ShowListByCompany($companyId){
        $company = $this->companyDAO->getCompanyById($companyId);
        $jobOffers = $this->jobOfferDAO->GetAllByCompany($companyId);
        $jobPositionList = $this->jobPositionApiDAO->GetAll();
        $jobOfferList = array();

        if($jobOffers == false){
            $message = "No hay ofertas laborales de esta empresa.";
        } else if (is_object($jobOffers)) {
            $jobOffers->setCompany($company);
            $jobPosition = $this->FindById($jobPositionList,$jobOffers->getJobPosition());
            $jobOffers->setJobPosition($jobPosition);
            array_push($jobOfferList,$jobOffers);
        } else {
            foreach ($jobOffers as $jo){
                $jo->setCompany($company);
                $jobPosition = $this->FindById($jobPositionList,$jo->getJobPosition());
                $jo->setJobPosition($jobPosition);
                array_push($jobOfferList,$jo);
            }      
        }
        
        if($this->appointmentDAO->IsAppointment($_SESSION["loggeduser"]->getStudent()->getStudentId()) === false){
            $btnDisabled = false;
        } else {
            $btnDisabled = true;
        }
        require_once(VIEWS_PATH."view-joboffer-company.php");
    }

    private function FindById ($jobPositions, $id) {
        foreach ($jobPositions as $jp){
            if($jp->getJobPositionId() == $id){
                return $jp;
            }
        }
    }

    public function ShowAddView ($message = "")
    {
        $companyList = $this->companyDAO->GetAllActive();
        $careerList = $this->careerApiDAO->GetAllActive();
        $jobPositionList = $this->jobPositionApiDAO->GetAll();

        require_once(VIEWS_PATH."add-joboffer.php");
    }

    public function AddOffer($companyId,$endDate,$province,$city,$modality,$availability,$jobPositionId,$description,$accion){
    //    echo "Estoy en AddOffer. " . $companyId.$endDate.$province.$city.$modality.$availability.$jobPositionId.$description.$accion;
        
        $jobOffer = new JobOffer();
        $company = $this->companyDAO->GetCompanyById($companyId);
        $jobOffer->setCompany($company);
        $jobOffer->setEndDate($endDate);
        $jobOffer->setProvince($province);
        $jobOffer->setCity($city);
        $jobOffer->setModality($modality);
        $jobOffer->setAvailability($availability);
        $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobPositionId);
        //var_dump($jobPosition);
        $jobOffer->setJobPosition($jobPosition);
        $jobOffer->setDescription($description);


        if($this->jobOfferDAO->Add($jobOffer) == 1){
           $this->ShowAddView("Oferta laboral agregada con éxito.");
        }
    }

    public function ShowModifyView($jobOfferId, $message = ""){
        $jobOffer = $this->jobOfferDAO->GetJobOfferById($jobOfferId);
        $jobPositionList = $this->jobPositionApiDAO->GetAll();
        $companyList = $this->companyDAO->GetAllActive();
        require_once(VIEWS_PATH."modify-joboffer.php");
    }

    public function Modify($companyId, $endDate, $province, $city, $modality, $availability, $jobPosition, $description, $jobOfferId){
        //echo $companyId. $endDate. $province. $city. $modality. $availability. $jobPosition. $description. $jobOfferId;
        $jobOffer = new JobOffer();
        $jobOffer->setJobOfferId($jobOfferId);
        $company = $this->companyDAO->GetCompanyById($companyId);
        $jobOffer->setCompany($company);
        $jobOffer->setEndDate($endDate);
        $jobOffer->setProvince($province);
        $jobOffer->setCity($city);
        $jobOffer->setModality($modality);
        $jobOffer->setAvailability($availability);
        $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobPosition);
        $jobOffer->setJobPosition($jobPosition);
        $jobOffer->setDescription($description);


        $jobOfferList = $this->jobOfferDAO->GetAll();
        foreach($jobOfferList as $jo) {
            $company = $this->companyDAO->GetCompanyById($jo->getCompany());
            $jo->setCompany($company);
            $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jo->getJobPosition());
            $jo->setJobPosition($jobPosition);
        }

        $homeController = new HomeController();

        if($this->jobOfferDAO->Update($jobOffer) == 1){
            $message = "Oferta laboral editada con éxito.";
            $homeController->Index("all","all",$message);
        } else {
            $message = "Error al editar la oferta laboral.";
            $homeController->Index("all","all",$message);
        }
    }

    public function Remove($jobOfferId){
        $this->jobOfferDAO->Delete($jobOfferId);
        $homeController = new HomeController();
        $message = "Oferta laboral eliminada con éxito.";
        $homeController->Index("all","all",$message);
    }

  
}
?>