<?php
namespace DAO;

use DAO\ICompanyDAO as ICompanyDAO;
use Models\Company as Company;

class CompanyDAO implements ICompanyDAO {

    private $companyList = array();

    public function getCompanyList () { return $this->companyList; }
    public function setCompanyList ($companyList) { $this->companyList = $companyList; }

    function add (Company $newCompany)
    {
        $this->retriveData();
        array_push($this->companyList, $newCompany);
        $this->saveData();
    }

    function getAll()
    {
        $this->retriveData();
        return $this->companyList;
    }

    function retriveData()
    {
    
            $this->companyList = array();

            $jsonPath = $this->GetJsonFilePath();
            
            $jsonContent = file_get_contents($jsonPath);
    
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true): array();

            foreach ($arrayToDecode as $value)
            {
                $company = new Company();
                $company->setCompanyId($value["companyId"]);
                $company->setCuit($value["cuit"]);
                $company->setDescription($value["description"]);
                $company->setAboutUs($value["aboutUs"]);
                $company->setCompanyLink($value["companyLink"]);
                $company->setActive($value["active"]);

                array_push ($this->companyList, $company);
                sort($this->companyList);
            }
    }


    function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->companyList as $company)
        {
            $valueArray = array();

            $valueArray ['companyId'] = $company->getCompanyId(); 
            $valueArray ['cuit'] = $company->getCuit(); 
            $valueArray ['description'] = $company->getDescription(); 
            $valueArray ['aboutUs'] = $company->getAboutUs();
            $valueArray ['companyLink'] = $company->getCompanyLink(); 
            $valueArray ['active'] = $company->getActive();
        

            array_push($arrayToEncode, $valueArray);
           
        }

    
        $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents("Data/companys.json", $jsonContent);

    }


    function GetJsonFilePath(){

        $initialPath = "Data/Companys.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}

?>