<?php 

    namespace Database; 

    use Database\Connection as Connection;
    use Models\User as User;
    use Models\Student as Student;
    use PDOException as PDOException;

    class UserDAO {
        
        public function Add($user){
            try{
                $con = Connection::getInstance();
                
                $query = 'INSERT INTO USERS (userId,firstName,lastName,phoneNumber,email,pass,isAdmin,isActive,companyId) VALUES
                            (0,:firstName,:lastName,:phoneNumber,:email,:pass,:isAdmin,:isActive,:companyId)';
                
                $params['firstName'] = $user->getStudent()->getFirstName();
                $params['lastName'] = $user->getStudent()->getLastName();
                $params['phoneNumber'] = $user->getStudent()->getPhoneNumber();
                $params['email'] = $user->getStudent()->getEmail();
                $params['pass'] = $user->getPassword();
                $params['isAdmin'] = $user->getProfile();
                $params['isActive'] = true;
                $params['companyId'] = ($user->getCompany() != null) ? $user->getCompany()->GetCompanyId() : null ;

                // (:firstName,:lastName,:phoneNumber,:email,:pass,:isAdmin,:active)';

                return $con->executeNonQuery($query,$params);
            }catch(PDOException $e){
                var_dump($e);
                throw $e;
            }
        }

        public function GetAll(){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM USERS';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetUserById($userId){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM USERS WHERE USERID ="'.$userId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function Login($email,$password){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM USERS WHERE EMAIL ="'.$email.'"' . 'AND PASS ="'.$password.'"';
              
                $array = $con->execute($query);
                
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                echo $e->getMessage();
                throw $e;
                
            }
        }

        public function mapping($value){
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($a){
                $student = new Student();
                $student->setFirstName($a['firstName']);
                $student->setLastName($a['lastName']);
                $student->setPhoneNumber($a['phoneNumber']);
                $student->setEmail($a['email']);                
                
                $user = new User();
                $user->setUserId($a['userId']);
                $user->setStudent($student);
                $user->setPassword($a['pass']);
                $user->setProfile($a['isAdmin']);
                $user->setActive($a['isActive']);
                $user->setCompany($a['companyId']);
                    
                return $user;
            },$value);
            return count($resp)>1 ? $resp : $resp[0];
        }

        public function Delete ($id){
            try{
                $query = 'UPDATE USERS SET isActive = 0 WHERE userId = :userId;';
                $con = Connection::getInstance();
                $params['userId'] = $id;
                $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
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

        public function ReActive($userId){
            try{
                $query = 'UPDATE USERS SET isActive = 1 WHERE userId = :userId;';
                $con = Connection::getInstance();
                $params['userId'] = $userId;
                $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
            }
        }
    }