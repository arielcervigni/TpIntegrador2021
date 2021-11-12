<?php
    namespace Controllers;

    use Database\JobOfferDAO as JobOfferDAO;
    use Database\CompanyDAO as CompanyDAO;
    use DAO\JobPositionApiDAO as JobPositionApiDAO;
    use DAO\CareerApiDAO as CareerApiDAO;
    use Models\JobOffer as JobOffer;

    class HomeController
    {

        public function Index($career = 'all', $jobPosition = 'all', $message = "")
        {
            
            $jobOfferDAO = new JobOfferDAO();
            $companyDAO = new CompanyDAO();
            $jobPositionApiDAO = new JobPositionApiDAO();
            $careerApiDAO = new CareerApiDAO();
            $jobPositionList = $jobPositionApiDAO->GetAll();
            $jobOffers = $jobOfferDAO->GetAll();

           
                if($career !='all')
                    $jobOffers = $jobOfferDAO->GetAllByCareer($career);
                
                if($jobPosition != 'all')  
                    $jobOffers = $this->FindJobOffersByJobPosition($jobOffers,$jobPosition);
            
                

            $jobOfferList = array();
            
            
            if($jobOffers == false){
                $message = "No hay ofertas laborales para mostrar.";
                require_once(VIEWS_PATH."home.php");
            } else if(is_array($jobOffers)){
               foreach ($jobOffers as $jo){
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
                $jobOffers->setEndDate(date('d-m-Y',strtotime($jo->getEndDate())));
                array_push($jobOfferList,$jobOffers);
            }

            $careerList = $careerApiDAO->GetAllActive();
            require_once(VIEWS_PATH."home.php");
        }

        private function FindJobOffersByJobPosition($jobOffers, $jobPositionId){

            $jobOfferList = array();
            foreach ($jobOffers as $jo){
                if($jo->getJobPosition() == $jobPositionId)
                    array_push($jobOfferList,$jo);

            }
            return $jobOfferList;
        }

        public function SingOut(){
            if(isset($_SESSION["loggeduser"]))
                unset($_SESSION["loggeduser"]);
            
            $this->Index('all','all','Gracias por utilizar Ofertas Laborales.');
        }
    }
?>