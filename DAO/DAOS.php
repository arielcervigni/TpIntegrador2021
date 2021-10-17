<?php
namespace DAO;

use DAO\CareerApiDAO as CareerApiDAO;
use DAO\StudentApiDAO as StudentApiDAO;
use DAO\CompanyDAO as CompanyDAO;


class DAOS {

    private static $StudentApiDAO;
    private static $CareerApiDAO;
    private static $CompanyDAO;
    private static $instance;

    public function __construct() {
        $this->StudentApiDAO = new StudentApiDAO();
        $this->CareerApiDAO = new CareerApiDAO();
        $this->CompanyDAO = new CompanyDAO();
    }

    static function getStudentApiDAO() {
        return ((self::$StudentApiDAO == null) ? self::$StudentApiDAO = new StudentApiDAO() : self::$StudentApiDAO);
    }

    
    static function getCareerApiDAO() {
        return ((self::$CareerApiDAO == null) ? self::$CareerApiDAO = new CareerApiDAO() : self::$CareerApiDAO);
    }

    
    static function getCompanyDAO() {
        return ((self::$CompanyDAO == null) ? self::$CompanyDAO = new CompanyDAO() : self::$CompanyDAO);
    }

}

?>