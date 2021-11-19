<?php 

    namespace Database; 

    use Database\Connection as Connection;
    use Models\Company as Company;
    use PDOException as PDOException;

    class CompanyDAO {
        
        public function Add($company){
            try{
                $con = Connection::getInstance();
                
                $query = 'INSERT INTO COMPANYS (companyId,cuit,descrip,aboutUs,companyLink,isActive) VALUES
                            (0,:cuit,:descrip,:aboutUs,:companyLink,:isActive)';
                
                $params['cuit'] = $company->getCuit();
                $params['descrip'] = $company->getDescription();
                $params['aboutUs'] = $company->getAboutUs();
                $params['companyLink'] = $company->getCompanyLink();
                $params['isActive'] = true;

                return $con->executeNonQuery($query,$params);
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAll(){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM COMPANYS';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetAllActive(){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM COMPANYS WHERE ISACTIVE = 1';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function GetCompanyById($companyId){
            try{
                $con = Connection::getInstance();
                $query = 'SELECT * FROM COMPANYS WHERE COMPANYID ="'.$companyId.'"';
                $array = $con->execute($query);
                return (!empty($array)) ? $this->mapping($array) : false;
            }catch(PDOException $e){
                throw $e;
            }
        }

        public function mapping($value){
            $value = is_array($value) ? $value : [];
            $resp = array_map(function($a){
                $company = new Company();
                $company->setCompanyId($a['companyId']);
                $company->setCuit($a['cuit']);
                $company->setDescription($a['descrip']);
                $company->setAboutUs($a['aboutUs']); 
                $company->setCompanyLink($a['companyLink']); 
                $company->setActive($a['isActive']);  
                //var_dump($company);              
                return $company;
            },$value);
            return count($resp)>1 ? $resp : $resp[0];
        }

        public function Delete ($id){
            try{
                $query = 'UPDATE COMPANYS SET isActive = 0 WHERE companyId = :companyId;';
                $con = Connection::getInstance();
                $params['companyId'] = $id;
                $con->executeNonQuery($query, $params);
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
            }
        }

        public function Update($company) {
            try{
                    $query = 'UPDATE COMPANYS SET cuit = :cuit, descrip = :descrip, aboutUs = :aboutUs,
                    companyLink = :companyLink
                     WHERE companyId = :companyId;';
                    $con = Connection::getInstance();
                    $params['companyId'] = $company->getCompanyId();
                    $params['cuit'] = $company->getCuit();
                    $params['descrip'] = $company->getDescription();
                    $params['aboutUs'] = $company->getAboutUs();
                    $params['companyLink'] = $company->getCompanyLink();
                    return $con->executeNonQuery($query, $params);
                
            }catch(PDOException $e){
                echo 'Exception en Update='.$e->getMessage();
            }
        }
    }