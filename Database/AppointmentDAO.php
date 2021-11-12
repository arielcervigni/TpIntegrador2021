<?php 

    namespace Database; 

    use Database\Connection as Connection;
    use Models\JobOffer as JobOffer;
    use Models\Company as Company;
    use Models\JobPosition as JobPosition;
    use Models\Appointment as Appointment;
    use Models\Student as Student;
    use Database\CompanyDAO as CompanyDAO;
    use Database\JobOfferDAO as JobOfferDAO;
    use DAO\JobPositionApiDAO as JobPositionApiDAO;
    use DAO\StudentApiDAO as StudentApiDAO;
    use PDOException as PDOException;

    class AppointmentDAO {
        
        private $companyDAO;
        private $jobOfferDAO;
        private $jobPositionApiDAO;
        private $studentApiDAO;

        public function __construct(){
            $companyDAO = new CompanyDAO();
            $jobOfferDAO = new JobOfferDAO();
            $jobPositionApiDAO = new JobPositionApiDAO();
            $studentApiDAO = new StudentApiDAO();
        }


        public function Add($appointment){
            try{
                $con = Connection::getInstance();
                
                $query = 'INSERT INTO APPOINTMENTS (appointmentId,studentId,jobOfferId,cv,descrip,isActive) VALUES
                            (0,:studentId,:jobOfferId,:cv,:descrip,:isActive)';
                
                $params['studentId'] = $appointment->getStudent()->getStudentId();
                $params['jobOfferId'] = $appointment->getJobOffer()->getJobOfferId();
                $params['cv'] = $appointment->getResume();
                $params['descrip'] = $appointment->getDescription();
                $params['isActive'] = true;

                return $con->executeNonQuery($query,$params);
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAllByStudentId($studentId){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM APPOINTMENTS WHERE studentId ="'.$studentId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }


        public function mapping($value){
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($a){
                $appointment = new Appointment();
                $appointment->setAppointmentId($a['appointmentId']);
                //$student = $this->studentApiDAO->GetStudentById($a['studentId']);
                $appointment->setStudent($a['studentId']);

                //$jobOffer = $this->jobOfferDAO->GetJobOfferById($a['jobOfferId']);
                //$company = $this->companyDAO->GetCompanyById($jobOffer->getCompanyId());
                //$jobOffer->setCompany($company);
                //$jobPosition = $this->jobPositionApiDAO->GetJobPositionById($a['jobPositionId']);
                //$jobOffer->setJobPosition($jobPosition);
                $appointment->setJobOffer($a['jobOfferId']);
                
                $appointment->setResume($a['cv']);
                $appointment->setDescription($a['descrip']);
                $appointment->setActive($a['isActive']);

                    
                return $appointment;
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

        public function Update($user) {
            try{
                $query = 'UPDATE USERS SET firstName = :firstName, lastName = :lastName, email = :email,
                phoneNumber = :phoneNumber, pass = :password, isAdmin = :profile
                 WHERE userId = :userId;';
                $con = Connection::getInstance();
                $params['userId'] = $user->getUserId();
                $params['firstName'] = $user->getStudent()->getFirstName();
                $params['lastName'] = $user->getStudent()->getLastName();
                $params['email'] = $user->getStudent()->getEmail();
                $params['phoneNumber'] = $user->getStudent()->getPhoneNumber();
                $params['password'] = $user->getPassword();
                $params['profile'] = $user->getProfile();
                return $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
            }
        }

        
    }