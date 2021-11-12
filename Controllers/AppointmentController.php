<?php
namespace Controllers;

use Database\JobOfferDAO as JobOfferDAO;
use Database\CompanyDAO as CompanyDAO;
use Database\AppointmentDAO as AppointmentDAO;
use DAO\JobPositionApiDAO as JobPositionApiDAO;
use DAO\StudentApiDAO as StudentApiDAO;
use DAO\CareerApiDAO as CareerApiDAO;

use Models\JobOffer as JobOffer;
use Models\JobPosition as JobPosition;
use Models\Appointment as Appointment;
use Models\Student as Student;
use Models\Company as Company;
use Models\Career as Career;
use Controllers\HomeController as HomeController;

class AppointmentController
{
    private $jobOfferDAO;
    private $jobPositionApiDAO;
    private $companyDAO;
    private $homeController;
    private $appointmentDAO;
    private $studentApiDAO;
    private $careerApiDAO;

    public function __construct()
    {
        $this->jobOfferDAO = new JobOfferDAO();
        $this->jobPositionApiDAO = new JobPositionApiDAO();
        $this->companyDAO = new CompanyDAO();
        $this->homeController = new HomeController();
        $this->appointmentDAO = new AppointmentDAO();
        $this->studentApiDAO = new StudentApiDAO();
        $this->careerApiDAO = new CareerApiDAO();
    }

    public function ShowJobOffers($message = ""){
        $this->homeController->Index('all','all', $message);
    }

    public function ShowJobOffer ($id = 0, $message = "")
    {
        $jobOffer = $this->jobOfferDAO->GetJobOfferById($id);
        $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobOffer->getJobPosition());
        //var_dump($jobPosition);
        $jobOffer->setJobPosition($jobPosition);
        $company = $this->companyDAO->GetCompanyById($jobOffer->getCompany());
        $jobOffer->setCompany($company);
        //var_dump($jobOffer->getJobPosition());

        require_once(VIEWS_PATH."add-appointment.php");
    }

    public function New ($id, $description = "", $file) {
        $message = "";
        if($_FILES['resume']['error'] == 4){
            $message = "No hay archivo seleccionado.";
            $this->appointmentController->ShowJobOffer($id,$message);
        } else {
            $file_name = $_FILES['resume']['name'];
            $file_size = $_FILES['resume']['size'];
            $file_tmp = $_FILES['resume']['tmp_name'];
            $file_type = $_FILES['resume']['type'];
            $file_ext_aux = explode('.',$file_name);
            $file_ext = end($file_ext_aux);
            
            $expensions = array('pdf','docx','doc');

            if(in_array($file_ext,$expensions)===false){
                $message = "El archivo seleccionado no tiene un formato válido.";
                $this->appointmentController->ShowJobOffer($id,$message);
            } 

            if($file_size > 5242880){
                $message = "El archivo seleccionado supera el límite (5MB).";
                $this->appointmentController->ShowJobOffer($id,$message);
            }

            move_uploaded_file($file_tmp,"Resumes/".$file_name);
            $file_name = "Resumes/".$file_name;
            

            $appointment = new Appointment();
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($id);
            $appointment->setJobOffer($jobOffer);
            $appointment->setStudent($_SESSION['loggeduser']->getStudent());
            $appointment->setDescription($description);
            $appointment->setResume($file_name);

            $rta = $this->appointmentDAO->Add($appointment);
            if($rta == 1){
                $message = "Postulación guardada con éxito!"; 
                $this->ShowJobOffers($message);
            }
            
           

        
        }
    }

    public function ShowListAppointments() {
        //echo "id estudiante: ".$_SESSION["loggeduser"]->getStudent()->getStudentId();
        $message = "";
        $appointments = $this->appointmentDAO->GetAllByStudentId($_SESSION["loggeduser"]->getStudent()->getStudentId());
        $appointmentList = array();

        
        if($appointments == false){
            $message = "No hay postulaciones para mostrar.";
        } else if (is_array($appointments)) {
            
            $companyList = $this->companyDAO->GetAll();
            $careerList = $this->careerApiDAO->GetAll();
            $studentList = $this->studentApiDAO->GetAll($careerList);
            $jobOfferList = $this->jobOfferDAO->GetAll();
            $jobPositionList = $this->jobPositionApiDAO->GetAll();
            

            $student = null;
            $company = null;
            $jobOffer = null;
            $jobPosition = null;

            foreach ($appointments as $app){
                /* Seteo Estudiante */
                
                //$student = new Student();
                //$student = $this->studentApiDAO->GetStudentById($careerList, $app->getStudent());
                $student = $this->FindByIdInList($studentList,$app->getStudent(),'getStudentId');
                $app->setStudent($student);
                /* Seteo JobOffer */
                //$jobOffer = new JobOffer();
                $jobOffer = $this->jobOfferDAO->GetJobOfferById($app->getJobOffer());
                //$jobOffer = $this->FindByIdInList($jobOfferList,$app->getJobOffer(),'getJobOfferId');
                /* Seteo la empresa en la JobOffer */
                //$company = new Company();
                //$company = $this->companyDAO->GetCompanyById($jobOffer->getCompany());
                $company = $this->FindByIdInList($companyList,$jobOffer->getCompany(),'getCompanyId');
                $jobOffer->setCompany($company);
                /* Seteo la JobPosition */
                //$jobPosition = new JobPosition();
                $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobOffer->getJobPosition());
                if(is_int($jobOffer->getJobPosition())){
                    $jobPosition = $this->FindByIdInList($jobPositionList, $jobOffer->getJobPosition(), 'getJobPositionId');
                    $jobOffer->setJobPosition($jobPosition);
                }
                else 
                    $jobOffer->setJobPosition($jobPosition);

                $app->setJobOffer($jobOffer);
                
                array_push($appointmentList,$app);
            }
            
        } else {
            $student = $this->studentApiDAO->GetStudentById($this->careerApiDAO->GetAll(),$app->getStudent());
            $app->setStudent($student);
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($app->getJobOffer());
            $company = $this->companyDAO->GetCompanyById($jobOffer->getCompanyId());
            $jobOffer->setCompany($company);
            $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($app->getJobPosition());
            $jobOffer->setJobPosition($jobPosition);
            array_push($appointmentList,$app);
        }

        require_once(VIEWS_PATH."mys-appointments.php");
    }


    public function FindByIdInList($list, $id, $name){
       
        $obj = null;

        foreach ($list as $l) {
            if($l->$name() == $id)
            return $l;
        }
        return $obj;
    }
}
?>