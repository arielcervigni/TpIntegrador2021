<?php
namespace DAO;

use Models\Company as Company;

interface ICompanyDAO{

    function add (Company $company);
    function getAll();
    
}

?>