<?php
namespace Controllers;

use DAO\DAOS as DAOS;
use DAO\StudentApiDAO as StudentApiDAO;
use Models\Student as Student;
use DAO\CareerApiDAO as CareerApiDAO;
use Models\Career as Career;
use Models\User as User;
//use DAO\User as UserDAO;
use Database\UserDAO as UserDAO;
use Database\CompanyDAO as CompanyDAO;
class NewUserController
{
    private $studentApiDAO;
    private $careerApiDAO;
    private $userDAO;
    private $companyDAO;

    public function __construct()
    {
        $this->careerApiDAO = DAOS::getCareerApiDAO();
        $this->studentApiDAO = DAOS::getStudentApiDAO();
        $this->userDAO = new UserDAO();
        $this->companyDAO = new CompanyDAO();
    }

    public function ShowAddView ($studentFilter = null, $message = "")
    {
        $careerList = $this->careerApiDAO->GetAll();
        
        $studentList = $this->studentApiDAO->GetAll($careerList);
    
        require_once(VIEWS_PATH."add-user.php");

    }

    public function ShowUserView($userId = -1, $message = ""){
        if($userId != -1){
            $user = $this->userDAO->GetUserById($userId);
        }

        
        require_once(VIEWS_PATH."view-user.php");
    }

    public function ShowListView ($message = "")
    {
        $userList = $this->userDAO->GetAll();
        require_once(VIEWS_PATH."user-list.php");
    }

    public function ShowAdminAddView($message = "", $firstName = "", $lastName = "", $email = "", $phoneNumber = "") {
        require_once(VIEWS_PATH."add-admin.php");
        
    }

    public function ShowUserCompanyAddView($message = "", $firstName = "", $lastName = "", $email = "", $phoneNumber = "") {

        $companyList = $this->companyDAO->GetAllActive();
        require_once(VIEWS_PATH."add-user-company.php");
        
    }

    public function ShowModifyView($userId, $message = ""){
        
        if($message == "changePassword"){
            $changePassword = true;
            $message = "";
        }
        $user = $this->userDAO->GetUserById($userId);
        $companyList = array();
        if($user->getProfile() == "Company")
            $companyList = $this->companyDAO->GetAllActive();

        require_once(VIEWS_PATH."modify-user.php");
    }

    public function SearchFilter($email) 
    {
        $studentFilter = $this->SearchStudentByEmail($email);
        
        if($studentFilter == null)
            $message = "No se encontró el usuario registrado con ese email.";
        else if($studentFilter->getActive() == false){
            $studentFilter = null;
            $message = "El usuario no se encuentra activo.";
        }
        
        require_once(VIEWS_PATH."add-user.php");
    }
   
    public function SearchStudentByEmail($email) {

        $careerList = $this->careerApiDAO->GetAll();
        $studentList = $this->studentApiDAO->GetAll($careerList);
        $studentFilter = null;
        foreach ($studentList as $student){
            if($email !== ""){
                if (strpos($student->getEmail(), $email) !== false) {
                    $studentFilter = $student;
                    break;
                }
            }
        }
        return $studentFilter;
    }

    public function AddUser ($firstName, $lastName, $email, $phoneNumber, $password, $confirmPassword, $companyId, $profile) {
        
        
        if($password == $confirmPassword)
        {

            $studentForUser = new Student();

            if($profile == "Administrador"){
                $studentForUser->setFirstName($firstName);
                $studentForUser->setLastName($lastName);
                $studentForUser->setEmail($email);
                $studentForUser->setPhoneNumber($phoneNumber); 
            
            } else if($profile == "Company") {
                $studentForUser->setEmail($email);
                $studentForUser->setPhoneNumber($phoneNumber); 
            } else {
                 $studentForUser = $this->SearchStudentByEmail($email);
            }
            
            $user = new User();
            $user->setUserId(0);
            $user->setStudent($studentForUser);
            $user->setPassword($password);
            $user->setProfile($profile);

            if($profile == "Company"){
                $company = $this->companyDAO->GetCompanyById($companyId);
                $user->setCompany($company);
            }
            
            // GUARDAR USUARIO EN LA BD.
            $rta = $this->userDAO->Add($user);

            if($rta){
                $message = "Usuario agregado con éxito.";
                if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == 'Administrador')
                    $this->ShowListView($message);    
                else
                    require_once(VIEWS_PATH.'login.php');
                
            } else { 
                $message = "Error al guardar el usuario. Por favor reintente.";
                $this->ShowAddView($message);
            }
            

        } else {
            $message = "Las contraseñas no coinciden. Por favor complete nuevamente.";
            $this->ShowAddView($studentForUser, $message);
        }
        
    }

    public function RemoveItem($id) { 
        $this->userDAO->Delete($id);
        $message = "Usuario eliminado con éxito.";
        $this->ShowListView($message);
    }

    public function Modify($firstName, $lastName, $email, $phoneNumber, $password, $confirmPassword, $profile, $userId, $companyId){

        $user = new User();
        $user->setUserId($userId);
        $student = new Student();
        $student->setFirstName($firstName);
        $student->setLastName($lastName);
        $student->setEmail($email);
        $student->setPhoneNumber($phoneNumber);
        $user->setStudent($student);
        $user->setPassword($password);
        $user->setProfile($profile);
        if($profile == "Company")
            $user->setCompany($companyId);
        if($this->userDAO->Update($user) == 1){
            $message = "Usuario editado con éxito.";
            $this->ShowListView($message);
        }

    }
}
?>