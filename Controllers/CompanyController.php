<?php
namespace Controllers;


use DAO\companyDAO as companyDAO;
use Models\Company as Company;

class CompanyController
{
    private $companyDAO;

    public function __construct()
    {
        $this->companyDAO = new CompanyDAO();
    }

    public function ShowAddView ($message = "", $company = null)
    {
        require_once(VIEWS_PATH."add-company.php");

    }

    public function ShowListView ($message = "")
    {
        $companyList = $this->companyDAO->getAll();
        require_once(VIEWS_PATH."company-list.php");
    }

    public function Add ($companyId, $cuit, $description, $aboutUs, $companyLink, $active)
    {
        $company = new Company();
        $company->setCompanyId($companyId);
        $company->setCuit($cuit);
        $company->setDescription($description);
        $company->setAboutUs($aboutUs);
        $company->setCompanyLink($companyLink);
        $company->setActive($active);

        $this->companyDAO->Add($company);

        $message = "Empresa agregada correctamente";
        $this->ShowAddView($message);
       
    }

    public function Modify ($cuit, $description, $aboutUs, $companyLink, $companyPos) {

        $companyList = $this->companyDAO->getAll();
        $companyList[$companyPos]->setCuit($cuit);
        $companyList[$companyPos]->setDescription($description);
        $companyList[$companyPos]->setAboutUs($aboutUs);
        $companyList[$companyPos]->setCompanyLink($companyLink);

        $this->companyDAO->setcompanyList($companyList);
        $companyList = $this->companyDAO->getcompanyList($companyList);
        $this->companyDAO->saveData();

        $this->ShowListView("Empresa editada correctamente.");
    }

    public function AddIDUnico ($cuit, $description, $aboutUs, $companyLink)
    {    
        $companyList = $this->companyDAO->getAll();
        $companyPos = $this->searchPositionAtCuit($companyList,$cuit);
        
        if($companyPos == -1){
            $companyId = $this->getLastId($companyList);
            $active = true;

            if($companyId > 0)
                $this->Add($companyId, $cuit, $description, $aboutUs, $companyLink, $active);
            else
            {
                $message = "Error al cargar el celular. Código duplicado";
                $this->ShowAddView($message);
            }
        } else {
            $this->Modify($cuit, $description, $aboutUs, $companyLink, $companyPos);
        }
        
    }


    public function RemoveItem ($remove)
    {
        $companyList = $this->companyDAO->getAll();
        
        if(gettype($remove) == 'int') {
            $pos = $this->searchPositionAtId ($companyList, $remove);

            if ($pos != -1)
                unset($companyList[$pos]);
        
            $this->companyDAO->setcompanyList($companyList);
            $companyList = $this->companyDAO->getcompanyList($companyList);
            $this->companyDAO->saveData();
            
            if(count($companyList) == 0)
            {
                $message = "No hay empresas para mostrar";
                $this->ShowListView($message);
            }
            else
            $this->ShowListView();
        } else if (gettype($remove) == 'string') {

            $i = $this->searchPositionAtCuit($companyList, $remove);
            $company = $companyList[$i];
            var_dump($company);
            $this->ShowAddView("",$company);
        }
        
    }

    public function searchPositionAtId ($array, $companyId)
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

    public function searchPositionAtCuit ($array, $cuit)
    {
        $i = 0;
        $rta = -1;
        while ($i < count($array))
        {
            if($cuit == $array[$i]->getCUIT() )
            {
                $rta = $i;
                break;
            }
            else
                $i++;
        }
        return $rta;
    }

    public function getLastId ($array)
    {
        $size = count($array);
        if($size > 0) {
            $i = $size-1;
            $id = $array[$i]->getCompanyId();
        } else 
            $id = 0;
        
        return $id+1;
    }
}
?>