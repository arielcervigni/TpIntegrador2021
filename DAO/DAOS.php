<?php
namespace DAO;

use DAO\CareerApiDAO as CareerApiDAO;
use DAO\StudentApiDAO as StudentApiDAO;
use DAO\CompanyDAO as CompanyDAO;


class DAOS {

    private static $StudentApiDAO;
    private static $CareerApiDAO;
    private static $CompanyDAO;
    private static $JobPositionApiDAO;
    private static $instance;

    public function __construct() {
        
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

    static function getJobPositionApiDAO(){
        return ((self::$JobPositionApiDAO == null) ? self::$JobPositionApiDAO = new JobPositionApiDAO() : self::$JobPositionApiDAO);
    }

}

?>