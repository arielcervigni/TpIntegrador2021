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

        public function Index($career = 'all', $jobPosition = 'all', $message = "")
        {
            
            $jobOfferDAO = new JobOfferDAO();
            $companyDAO = new CompanyDAO();
            $jobPositionApiDAO = new JobPositionApiDAO();
            $careerApiDAO = new CareerApiDAO();
            $appointmentDAO = new AppointmentDAO();
            $jobPositionList = $jobPositionApiDAO->GetAll();
            $jobOffers = $jobOfferDAO->GetAllActive();
            $careerList = $careerApiDAO->GetAllActive();
            $btnDisabled = false;
           

                if($career !='all')
                    $jobOffers = $jobOfferDAO->GetAllByCareer($career);
                
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
                    if($appointmentDAO->IsAppointment($_SESSION["loggeduser"]->getStudent()->getStudentId()) === false){
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
                    $company = $companyDAO->GetCompanyById($jo->getCompany());
                    $jo->setCompany($company);
                    $jobPosition = $jobPositionApiDAO->GetJobPositionById($jo->getJobPosition());
                    $jo->setJobPosition($jobPosition);
                    //$date = $jo->getEndDate();
                    $jo->setEndDate(date('d-m-Y',strtotime($jo->getEndDate())));
                    array_push($jobOfferList,$jo);
                }
            }else {
                $company = $companyDAO->GetCompanyById($jobOffers->getCompany());
                $jobOffers->setCompany($company);
                $jobPosition = $jobPositionApiDAO->GetJobPositionById($jobOffers->getJobPosition());
                $jobOffers->setJobPosition($jobPosition);
                //$date = $jo->getEndDate();
                $jobOffers->setEndDate(date('d-m-Y',strtotime($jobOffers->getEndDate())));
                array_push($jobOfferList,$jobOffers);
            }

            $careerList = $careerApiDAO->GetAllActive();
            require_once(VIEWS_PATH."home.php");
        }

        private function FindJobOffersByJobPosition($jobOffers, $jobPositionId){

            $jobOfferList = array();
            if(is_array($jobOffers)) {
                foreach ($jobOffers as $jo){
                if($jo->getJobPosition() == $jobPositionId)
                    array_push($jobOfferList,$jo);

                }
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
                $jobOfferDAO->Delete($jobOfferId);
                $jobOfferList = $jobOfferDAO->GetAllActive();
                $this->Index('all', 'all');
            }
    
        }
    }
?>