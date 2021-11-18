<?php 

    namespace Database; 

    use Database\Connection as Connection;
    use Models\JobOffer as JobOffer;
    use Models\Company as Company;
    use Models\JobPosition as JobPosition;
    // use Database\CompanyDAO as CompanyDAO;
    //use DAO\JobPositionApiDAO as JobPositionApiDAO;
    use PDOException as PDOException;

    class JobOfferDAO {
        

        public function Add($jobOffer){
            try{
                $con = Connection::getInstance();
                
                $query = 'INSERT INTO JOBOFFERS (jobOfferId,companyId,province,city,endDate,jobPositionId,modality,availability,descrip,careerId,isActive) VALUES
                            (0,:companyId,:province,:city,:endDate,:jobPositionId,:modality,:availability,:descrip,:careerId,:isActive)';
                
                $params['companyId'] = $jobOffer->getCompany()->getCompanyId();
                $params['province'] = $jobOffer->getProvince();
                $params['city'] = $jobOffer->getCity();
                $params['endDate'] = $jobOffer->getEndDate();
                $params['jobPositionId'] = $jobOffer->getJobPosition()->getJobPositionId();
                $params['modality'] = $jobOffer->getModality();
                $params['availability'] = $jobOffer->getAvailability();
                $params['descrip'] = $jobOffer->getDescription();
                $params['careerId'] = $jobOffer->getJobPosition()->getCareerId();
                $params['isActive'] = true;

                return $con->executeNonQuery($query,$params);
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAll(){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM JOBOFFERS order by isActive, endDate asc';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAllActive(){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM JOBOFFERS WHERE isActive = 1 order by endDate asc';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetJobOfferById($jobOfferId){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM JOBOFFERS WHERE jobOfferId ="'.$jobOfferId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAllByCareer($careerId){
            
            //$jobPositions = $this->jobPositionApiDAO->

            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM JOBOFFERS WHERE careerId ="'.$careerId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAllByCompany($companyId){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM JOBOFFERS WHERE companyId ="'.$companyId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }


        public function mapping($value){
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($a){
                $jobOffer = new JobOffer();
                $jobOffer->setJobOfferId($a['jobOfferId']);
                //$company = new Company();
                //$company = $this->companyDAO->GetCompanyById($a['companyId']);
                $jobOffer->setCompany($a['companyId']);
                //$jobOffer->setCompany($company);
                $jobOffer->setProvince($a['province']);
                $jobOffer->setCity($a['city']);
                $jobOffer->setEndDate($a['endDate']);
                //$jobPosition = $this->jobPosition->GetJobPositionById($a['jobPositionId']);
                $jobOffer->setJobPosition($a['jobPositionId']);
                //$jobOffer->setJobPosition($jobPosition);
                $jobOffer->setModality($a['modality']);
                $jobOffer->setAvailability($a['availability']);
                $jobOffer->setDescription($a['descrip']);
                $jobOffer->setCareerId($a['careerId']);
                $jobOffer->setActive($a['isActive']);

                    
                return $jobOffer;
            },$value);
            return count($resp)>1 ? $resp : $resp[0];
        }

        public function Delete ($id){
            try{
                $query = 'UPDATE JOBOFFERS SET isActive = 0 WHERE jobOfferId = :jobOfferId;';
                $con = Connection::getInstance();
                $params['jobOfferId'] = $id;
                $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Delete='.$e->getMessage();
            }
        }

        public function Update($jobOffer) {
            try{
                $query = 'UPDATE JOBOFFERS SET companyId = :companyId, endDate = :endDate, province = :province,
                city = :city, modality = :modality, availability = :availability, jobPositionId = :jobPositionId, descrip = :description
                 WHERE jobOfferId = :jobOfferId;';
                $con = Connection::getInstance();
                $params['jobOfferId'] = $jobOffer->getJobOfferId();
                $params['companyId'] = $jobOffer->getCompany()->getCompanyId();
                $params['endDate'] = $jobOffer->getEndDate();
                $params['province'] = $jobOffer->getProvince();
                $params['city'] = $jobOffer->getCity();
                $params['modality'] = $jobOffer->getModality();
                $params['availability'] = $jobOffer->getAvailability();
                $params['jobPositionId'] = $jobOffer->getJobPosition()->getJobPositionId();
                $params['description'] = $jobOffer->getDescription();
                return $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
            }
        }

        
    }