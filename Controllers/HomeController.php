<?php
    namespace Controllers;

    use Database\JobOfferDAO as JobOfferDAO;
    use Database\CompanyDAO as CompanyDAO;
    use Database\AppointmentDAO as AppointmentDAO;
    use DAO\JobPositionApiDAO as JobPositionApiDAO;
    use DAO\CareerApiDAO as CareerApiDAO;
    use DAO\StudentApiDAO as StudentApiDAO;
    use Models\JobOffer as JobOffer;

    class HomeController
    {

        private $jobOfferDAO;
        private $companyDAO;
        private $jobPositionApiDAO;
        private $careerApiDAO;
        private $appointmentDAO;

        public function __construct()
    {
        $this->jobOfferDAO = new JobOfferDAO();
        $this->companyDAO = new CompanyDAO();
        $this->jobPositionApiDAO = new JobPositionApiDAO();
        $this->careerApiDAO = new CareerApiDAO();
        $this->appointmentDAO = new AppointmentDAO();
    }

        public function Index($career = 'all', $jobPosition = 'all', $message = "")
        {
            
           
            $jobPositionList = $this->jobPositionApiDAO->GetAll();
            $jobOffers = $this->jobOfferDAO->GetAllActive();
            $careerList = $this->careerApiDAO->GetAllActive();
            $btnDisabled = false;
           

                if($career !='all')
                    $jobOffers = $this->jobOfferDAO->GetAllByCareer($career);
                
                if($jobPosition != 'all')  
                    $jobOffers = $this->FindJobOffersByJobPosition($jobOffers,$jobPosition);
            
                if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == "Company"){
                    $companyId = $_SESSION["loggeduser"]->getCompany()->getCompanyId();
                    $jobOffersByCompany = array();
                    if(is_array($jobOffers)){
                        foreach($jobOffers as $jo){
                            if($jo->getCompany() == $companyId)
                                array_push($jobOffersByCompany, $jo);
                        }
                        $jobOffers = $jobOffersByCompany;
                    }
                }
                
                if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == 'Estudiante'){
                    //var_dump($appointmentDAO->IsAppointment($_SESSION["loggeduser"]->getStudent()->getStudentId()));
                    if($this->appointmentDAO->IsAppointment($_SESSION["loggeduser"]->getStudent()->getStudentId()) === false){
                        //echo "No hay postulaciones";
                        $btnDisabled = false;
                    } else {
                        $btnDisabled = true;
                    }
                }    
                    

            $jobOfferList = array();
            
            
            if($jobOffers == false){
                $message = "No hay ofertas laborales para mostrar.";
                require_once(VIEWS_PATH."home.php");
            } else if(is_array($jobOffers)){
               foreach ($jobOffers as $jo){

                $date = date('Y-m-d');
                //var_dump($date);

                if($jo->getEndDate() <= $date){
                    $this->FinishJobOffer($jo->getJobOfferId());

                }
                    $company = $this->companyDAO->GetCompanyById($jo->getCompany());
                    $jo->setCompany($company);
                    $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jo->getJobPosition());
                    $jo->setJobPosition($jobPosition);
                    //$date = $jo->getEndDate();
                    $jo->setEndDate(date('d-m-Y',strtotime($jo->getEndDate())));
                    array_push($jobOfferList,$jo);
                }
            }else {
                $company = $this->companyDAO->GetCompanyById($jobOffers->getCompany());
                $jobOffers->setCompany($company);
                $jobPosition = $this->jobPositionApiDAO->GetJobPositionById($jobOffers->getJobPosition());
                $jobOffers->setJobPosition($jobPosition);
                //$date = $jo->getEndDate();
                $jobOffers->setEndDate(date('d-m-Y',strtotime($jobOffers->getEndDate())));
                array_push($jobOfferList,$jobOffers);
            }

            $careerList = $this->careerApiDAO->GetAllActive();
            require_once(VIEWS_PATH."home.php");
        }

        private function FindJobOffersByJobPosition($jobOffers, $jobPositionId){

            $jobOfferList = array();
            if(is_array($jobOffers)) {
                foreach ($jobOffers as $jo){
                if($jo->getJobPosition() == $jobPositionId)
                    array_push($jobOfferList,$jo);

                }
            } else {
                if($jobOffers->getJobPosition() == $jobPositionId)
                    array_push($jobOfferList,$jobOffers);
            }
            return $jobOfferList;
        }

        public function SingOut(){
            if(isset($_SESSION["loggeduser"]))
                unset($_SESSION["loggeduser"]);
            
            $this->Index('all','all','Gracias por utilizar Ofertas Laborales.');
        }

        public function FinishJobOffer($jobOfferId){
            $careerApiDAO = new CareerApiDAO();
            $studentApiDAO = new StudentApiDAO();
            $jobOfferDAO = new JobOfferDAO();
            $careerList = $careerApiDAO->GetAll();
            $studentList = $studentApiDAO->GetAll($careerList);
    
            $studentsIds = $studentApiDAO->GetStudentsByJobOffer($jobOfferId);
            if(is_array($studentsIds)){
                foreach($studentsIds as $sid){

                
                $student = $studentApiDAO->GetStudentById($careerList,$sid,$studentList);

                $emailController = new EmailController();
                $asunto = "Fin de Oferta Laboral";
                
                 
                    $cuerpo = ' 
                    <html> 
                        <head> 
                                <title>Fin de Oferta Laboral.</title> 
                        </head> 
                    <body> 
                    <h1>Hola!</h1> 
                    <p> 
                    <b>Te informamos que en el día de hoy finalizó la oferta laboral a la cual te postulaste.</b>.
                         
                        <br>Queremos que sepas que la empresa tiene tu información de contacto.
                        <br>Recordá que ya estás habilitado para postularte a una nueva oferta.
                        <br><br>Te esperamos!
                        <br><br>Muchas Gracias.
                        <br>Ofertas Laborales.
                    </p> 
                </body> 
                </html> '; 
            
                
                if($emailController->SendMail($student->getEmail(), $asunto, $cuerpo)){
                    
                } else {
                    $message = "Error al realizar la declinación!";
                }
            }
                //$message = "JobOffer Vencidos Cerrados Correctamente!";
                $this->jobOfferDAO->Delete($jobOfferId);
                $jobOfferList = $this->jobOfferDAO->GetAllActive();
                $this->Index('all', 'all');
            }
    
        }
    }
?>