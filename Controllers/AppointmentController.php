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
use Controllers\LoginController as LoginController;
use Controllers\EmailController as EmailController;

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
        if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == 'Estudiante'){
            $jobOffer = $this->jobOfferDAO->GetJobOfferById($id);
            $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobOffer->getJobPosition());
            $jobOffer->setJobPosition($jobPosition);
            $company = $this->companyDAO->GetCompanyById($jobOffer->getCompany());
            $jobOffer->setCompany($company);
            require_once(VIEWS_PATH."add-appointment.php");

        } else if(isset($_SESSION["loggeduser"])){
            $appointmentList = $this->appointmentDAO->GetStudentByJobOffer($id);
            $careerList = $this->careerApiDAO->GetAll();
            $studentList = $this->studentApiDAO->GetAll($careerList);
            //var_dump($appointmentList);
            if(is_array($appointmentList)){
                foreach ($appointmentList as $app){
                    $student = $this->studentApiDAO->GetStudentById($careerList,$app->getStudent(),$studentList);
                    $app->setStudent($student);
                }
            } else if(is_object($appointmentList)){
                $app = $appointmentList;
                $appointmentList = array();
                $student = $this->studentApiDAO->GetStudentById($careerList,$app->getStudent(),$studentList);
                $app->setStudent($student);
                array_push($appointmentList,$app);
            } else {
                $message = "No hay postulaciones para esta oferta laboral.";
            }
            
            require_once(VIEWS_PATH."student-for-jobOffer.php");
        } else {
            $message = $id;
            $loginController = new LoginController();
            $loginController->ShowLogin($message);
        }
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

            $file_name = str_replace(' ', '-', $file_name);
            $file_name = "Resumes/".time().$file_name;
            move_uploaded_file($file_tmp, $file_name);
            

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

    public function ShowListAppointments($message = "") {
        
        $appointments = $this->appointmentDAO->GetAllActiveByStudentId($_SESSION["loggeduser"]->getStudent()->getStudentId());
        $appointmentList = array();

        $companyList = $this->companyDAO->GetAll();
        $careerList = $this->careerApiDAO->GetAll();
        $studentList = $this->studentApiDAO->GetAll($careerList);
        $jobOfferList = $this->jobOfferDAO->GetAll();
        $jobPositionList = $this->jobPositionApiDAO->GetAll();

        if($appointments == false){
            $message = "No hay postulaciones para mostrar.";
        } else if (is_array($appointments)) {
            
            $student = null;
            $company = null;
            $jobOffer = null;
            $jobPosition = null;

            foreach ($appointments as $app){
                
                $student = $this->FindByIdInList($studentList,$app->getStudent(),'getStudentId');
                $app->setStudent($student);
                
                $jobOffer = $this->jobOfferDAO->GetJobOfferById($app->getJobOffer());
                
                $company = $this->FindByIdInList($companyList,$jobOffer->getCompany(),'getCompanyId');
                $jobOffer->setCompany($company);
                
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
            $student = $this->FindByIdInList($studentList,$appointments->getStudent(),'getStudentId');
                $appointments->setStudent($student);
                
                $jobOffer = $this->jobOfferDAO->GetJobOfferById($appointments->getJobOffer());
                
                $company = $this->FindByIdInList($companyList,$jobOffer->getCompany(),'getCompanyId');
                $jobOffer->setCompany($company);
                
                $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobOffer->getJobPosition());

                if(is_int($jobOffer->getJobPosition())){
                    $jobPosition = $this->FindByIdInList($jobPositionList, $jobOffer->getJobPosition(), 'getJobPositionId');
                    $jobOffer->setJobPosition($jobPosition);
                }
                else 
                    $jobOffer->setJobPosition($jobPosition);

                $appointments->setJobOffer($jobOffer);

            array_push($appointmentList,$appointments);
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

    public function Remove($id, $jobOfferId = 0, $email = "") {
        
        
        if($_SESSION["loggeduser"]->getProfile()=='Estudiante'){

            $this->ShowListAppointments();
            
        } else {
            
                $emailController = new EmailController();
                $asunto = "Declinación por administrador.";
                
                 
                    $cuerpo = ' 
                    <html> 
                        <head> 
                                <title>Declinación de postulación.</title> 
                        </head> 
                    <body> 
                    <h1>Hola!</h1> 
                    <p> 
                    <b>Te informamos que un administrador de Ofertas Laborales ha declinado tu postulación a una oferta laboral."</b>.
                        <br>Te invitamos a comunicarte con Ofertas Laborales si necesitas obtener más información. 
                        <br>Esperamos que esto no te desanime y sigas postulandote a nuevas ofertas. 
                        <br><br>Muchas Gracias.
                        <br>Ofertas Laborales.
                    </p> 
                </body> 
                </html> '; 
            
            
                if($emailController->SendMail($email, $asunto, $cuerpo)){
                    $message = "Declinación realizada con éxito.!";
                    $this->appointmentDAO->Delete($id);
                } else {
                    $message = "Error al realizar la declinación!";
                }
                
                $this->ShowJobOffer($jobOfferId, $message);
        }
    }
}

    
?>