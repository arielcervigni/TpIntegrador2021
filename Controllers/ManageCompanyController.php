<?php
namespace Controllers;


use DAO\DAOS as DAOS;
use Database\CompanyDAO as CompanyDAO;
use Models\Company as Company;

class ManageCompanyController
{
    private $companyDAO;

    public function __construct()
    {
        $this->companyDAO = DAOS::getCompanyDAO();
    }

    public function ShowAddView ($message = "", $cuit = "", $description = "", $aboutUs = "", $companyLink = "")
    {
        require_once(VIEWS_PATH."add-company.php");
    }

    public function ShowViewCompany ($companyId)
    {
        $companyList = $this->companyDAO->getAll();
        $pos = $this->searchPositionAtId($companyList, $companyId); 
        
        $companyId = $companyList[$pos]->getCompanyId();
        $cuit = $companyList[$pos]->getCuit();
        $description = $companyList[$pos]->getDescription();
        $aboutUs = $companyList[$pos]->getAboutUs();
        $companyLink = $companyList[$pos]->getCompanyLink();
        
        require_once(VIEWS_PATH."view-company.php");
    }

    public function ShowModifyView ($companyId, $cuit = "", $description = "", $aboutUs = "", $companyLink = "", $message = "")
    {
        $companyList = $this->companyDAO->getAll();
        $pos = $this->searchPositionAtId($companyList, $companyId); 
        
        $companyId = $companyList[$pos]->getCompanyId();
        if($cuit == "")
            $cuit = $companyList[$pos]->getCuit();
        if($description == "")
            $description = $companyList[$pos]->getDescription();
        if($aboutUs == "")
            $aboutUs = $companyList[$pos]->getAboutUs();
        if($companyLink == "")
            $companyLink = $companyList[$pos]->getCompanyLink();
        
        require_once(VIEWS_PATH."modify-company.php");
    }

    public function ShowListView ($message = "")
    {
        $companyList = $this->companyDAO->getAllActive();
        if(empty($companyList)){
            $message = "No hay empresas para mostrar.";
        } 
        require_once(VIEWS_PATH."company-list.php");
        
    }

    private function Add ($companyId, $cuit, $description, $aboutUs, $companyLink, $active)
    {
        $company = new Company();
        $company->setCompanyId($companyId);
        $company->setCuit($cuit);
        $company->setDescription($description);
        $company->setAboutUs($aboutUs);
        $company->setCompanyLink($companyLink);
        $company->setActive($active);

        $this->companyDAO->Add($company);
        $message = "Empresa agregada correctamente.";
        $this->ShowAddView($message);
       
    }

    public function Modify ($cuit, $description, $aboutUs, $companyLink, $companyId) {
        
        $companyList = $this->companyDAO->getAll();
        $companyPos = $this->searchPositionAtId($companyList, $companyId);
        // acá tengo que pasarle el id de la empresa así se si el id == $company->getID() se está editando a si misma.
        $verifyCompany = $this->verifyNewCompany($companyList, $cuit, $description, $companyLink, $companyId);
                //var_dump($verifyCompany);

        if($verifyCompany == "OK"){
            $company = new Company();
            $company->setCompanyId($companyId);
            $company->setCuit($cuit);
            $company->setDescription($description);
            $company->setCompanyLink($companyLink);
            $company->setAboutUs($aboutUs);

            if($this->companyDAO->Update($company) == 1){
                $this->ShowListView("Empresa editada correctamente.");
            }
        
        } else {
            if($verifyCompany == "CUIT")
                $message = "El CUIT ingresado ya se encuentra registrado.";
                    
            if($verifyCompany == "DESCRIPTION")
                $message = "La descripción ingresada ya se encuentra registrada.";
                    
            if($verifyCompany == "COMPANYLINK")
                $message = "El link ingresado ya se encuentra registrado.";

            $this->ShowModifyView($companyId, $cuit, $description, $aboutUs, $companyLink, $message);
        }

        
    }

    public function AddIDUnico ($cuit, $description, $aboutUs, $companyLink)
    {    
        $companyList = $this->companyDAO->getAll();
        $active = true;


        $verifyCompany = $this->verifyNewCompany($companyList, $cuit, $description, $companyLink, 0);
                //var_dump($verifyCompany);


        if($verifyCompany == "OK"){
            $this->Add(0, $cuit, $description, $aboutUs, $companyLink, $active);
        } else {
            if($verifyCompany == "CUIT")
                $message = "El CUIT ingresado ya se encuentra registrado.";
            if($verifyCompany == "DESCRIPTION")
                $message = "La descripción ingresada ya se encuentra registrada.";
            if($verifyCompany == "COMPANYLINK")
                $message = "El link ingresado ya se encuentra registrado.";

            $this->ShowAddView($message, $cuit, $description, $aboutUs, $companyLink);
        }
        
        
    }


    public function RemoveItem ($remove)
    {
        if($this->companyDAO->Delete($remove) == 1){
            $this->ShowListView("Empresa borrada con éxito.");
        }
            
        if(!empty($companyList)) {
            $message = "No hay empresas para mostrar";
            $this->ShowListView($message);
        } else
            $this->ShowListView();
    
    }
        

    private function searchPositionAtId ($array, $companyId)
    {
        $i = 0;
        $rta = -1;
        while ($i < count($array))
        {
            if($companyId == $array[$i]->getCompanyId() )
            {
                $rta = $i;
                break;
            }
            else
                $i++;
        }
        return $rta;
    }

    private function getLastId ($array)
    {
        //$size = count($array);
        if(!empty($array)) {
        //if($size > 0) {
            $i = count($array)-1;
            $id = $array[$i]->getCompanyId();
        } else 
            $id = 0;
        
        return $id+1;
    }

    public function SearchFilter($word) {

        $companyList = $this->companyDAO->getAll();
        $companyFilter = array();
        
        foreach ($companyList as $company) {

            if($word !== ""){
                if (stripos($company->getDescription(), $word) !== false) 
                    array_push($companyFilter, $company);
                
                $companyList = $companyFilter;
            }
        }

        if(empty($companyList))
            $message = "No hay empresas para mostrar con esa palabra.";
        
        require_once(VIEWS_PATH."company-list.php");
    }

    private function verifyNewCompany($companyList, $cuit, $description, $companyLink, $companyId) {
        if(!empty($companyList)){
            foreach ($companyList as $company){
                if($company->getCuit() == $cuit && $company->getCompanyId() != $companyId && $company->getActive() == 1)
                    return "CUIT";

                if(strcasecmp($description,$company->getDescription()) == 0 && $company->getCompanyId() != $companyId && $company->getActive() == 1)
                    return "DESCRIPTION";

                if(strcasecmp($companyLink,$company->getCompanyLink()) == 0 && $company->getCompanyId() != $companyId && $company->getActive() == 1)
                    return "COMPANYLINK";

            }
        } 
    
        return "OK";
    }


}
?>