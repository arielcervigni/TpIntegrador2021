<?php
namespace Controllers;


use DAO\DAOS as DAOS;
use DAO\companyDAO as companyDAO;
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
        $companyList = $this->companyDAO->getAll();
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
            $companyList[$companyPos]->setCuit($cuit);
            $companyList[$companyPos]->setDescription($description);
            $companyList[$companyPos]->setAboutUs($aboutUs);
            $companyList[$companyPos]->setCompanyLink($companyLink);
            $this->companyDAO->setcompanyList($companyList);
            $companyList = $this->companyDAO->getcompanyList($companyList);
            $this->companyDAO->saveData();
        
            $this->ShowListView("Empresa editada correctamente.");
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
        $companyId = $this->getLastId($companyList);
        $active = true;

        if($companyId > 0){

            $verifyCompany = $this->verifyNewCompany($companyList, $cuit, $description, $companyLink, $companyId);
                //var_dump($verifyCompany);

                if($verifyCompany == "OK"){
                    $this->Add($companyId, $cuit, $description, $aboutUs, $companyLink, $active);
                } else {
                    if($verifyCompany == "CUIT")
                        $message = "El CUIT ingresado ya se encuentra registrado.";
                    
                    if($verifyCompany == "DESCRIPTION")
                        $message = "La descripción ingresada ya se encuentra registrada.";
                    
                    if($verifyCompany == "COMPANYLINK")
                        $message = "El link ingresado ya se encuentra registrado.";

                    $this->ShowAddView($message, $cuit, $description, $aboutUs, $companyLink);
                }
        } else {
            $message = "Error al cargar la empresa. Código duplicado";
            $this->ShowAddView($message);
        }
        
    }


    public function RemoveItem ($remove)
    {
        $companyList = $this->companyDAO->getAll();

        $pos = $this->searchPositionAtId ($companyList, $remove);

        if ($pos != -1)
            unset($companyList[$pos]);
        
        $this->companyDAO->setcompanyList($companyList);
        $companyList = $this->companyDAO->getcompanyList($companyList);
        $this->companyDAO->saveData();
            
        if(count($companyList) == 0) {
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
        $size = count($array);
        if($size > 0) {
            $i = $size-1;
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
                if (strpos($company->getDescription(), $word) !== false) 
                    array_push($companyFilter, $company);
                
                $companyList = $companyFilter;
            }
        }

        if(empty($companyList))
            $message = "No hay empresas para mostrar con esa palabra.";
        
        require_once(VIEWS_PATH."company-list.php");
    }

    private function verifyNewCompany($companyList, $cuit, $description, $companyLink, $companyId) {
        foreach ($companyList as $company)
        {
            if($company->getCuit() == $cuit && $company->getCompanyId() != $companyId)
                return "CUIT";

            if($company->getDescription() == $description && $company->getCompanyId() != $companyId)
                return "DESCRIPTION";

            if($company->getCompanyLink() == $companyLink && $company->getCompanyId() != $companyId)
                return "COMPANYLINK";

        }
    
        return "OK";
    }


}
?>