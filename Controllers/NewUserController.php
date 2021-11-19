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

    public function ShowMyProfile($user){
        require_once(VIEWS_PATH."my-profile.php");
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
        
        /* ARMO EL USUARIO PRIMERO PARA QUE SI HAY ERROR QUEDE CARGADO EN LA VISTA */
        $studentForUser = new Student();
        $company = null; 
            if($profile == "Administrador"){
                $studentForUser->setFirstName($firstName);
                $studentForUser->setLastName($lastName);
                $studentForUser->setEmail($email);
                $studentForUser->setPhoneNumber($phoneNumber); 
            
            } else if($profile == "Company") {
                $studentForUser->setEmail($email);
                $studentForUser->setPhoneNumber($phoneNumber); 
                $company = $this->companyDAO->GetCompanyById($companyId);
                $studentForUser->setFirstName($company->getDescription());
            } else {
                 $studentForUser = $this->SearchStudentByEmail($email);
            }
            
            $user = new User();
            $user->setUserId(0);
            $user->setStudent($studentForUser);
            $user->setPassword($password);
            $user->setProfile($profile);
            $user->setCompany($company);

        if($password == $confirmPassword ){
            if(strlen($password) > 5){
            
            $rta = $this->VerifyUser($email,$phoneNumber,0);

            if($rta == ""){
                
                $rta = $this->userDAO->Add($user);

                if($rta){
                    $message = "Usuario agregado con éxito.";
                    if(isset($_SESSION["loggeduser"]) && $_SESSION["loggeduser"]->getProfile() == 'Administrador')
                        $this->ShowListView($message);    
                    else
                        require_once(VIEWS_PATH.'login.php');
                    
                } else { 
                    $message = "Error al guardar el usuario. Por favor reintente.";
                    $this->RedirectView($_SESSION["loggeduser"]->getProfile(),$message);
                }

            } else if ($rta == "email") {
                $message = "El email ingresado ya se encuentra registrado.";
                $this->RedirectView($_SESSION["loggeduser"]->getProfile(),$message);
            } else {
                $message = "El número de teléfono ingresado ya se encuentra registrado.";
                $this->RedirectView($_SESSION["loggeduser"]->getProfile(),$message);
            } 

            } else { 
                $message = "Debe ingresar una contraseña de al menos 6 caracteres";
                $this->RedirectView($_SESSION["loggeduser"]->getProfile(),$message);
            }
        } else {
            $message = "Las contraseñas no coinciden. Por favor complete nuevamente.";
            $this->RedirectView($_SESSION["loggeduser"]->getProfile(),$message);
        }
    }

    private function RedirectView ($profile,$studentForUser="",$message=""){
        if($profile == "Estudiante")
            $this->ShowAddView($studentForUser, $message);
        else if($profile == "Administrador")
            $this->ShowAdminAddView($message);
        else 
            $this->ShowUserCompanyAddView($message);
    }

    public function RemoveItem($id) { 
        $this->userDAO->Delete($id);
        $message = "Usuario eliminado con éxito.";
        $this->ShowListView($message);
    }

    public function Modify($firstName, $lastName, $email, $phoneNumber, $password, $confirmPassword, $profile = "", $userId = "", $companyId = ""){

       
        /*Lo genero acá afuera para que cargue bien la vista si hay error*/ 
        $message = "";
        
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
        if($profile == "Company"){
            $company = $this->companyDAO->getCompanyById($companyId);
            $user->setCompany($company);
            $user->getStudent()->setFirstName($company->getDescription());
            
        }
           

        
        if($password == $confirmPassword ){
            if(strlen($password) > 5){
                $rta = $this->VerifyUser($email,$phoneNumber,$userId);

                if($rta == ""){
                    
                    if($this->userDAO->Update($user) == 1){
                        
                        $message = "Usuario editado con éxito.";
                        
                        if($_SESSION["loggeduser"]->getProfile() == "Administrador"){
                            $this->ShowListView($message);
                        } else if ($_SESSION["loggeduser"]->getProfile() == "Estudiante"){
                            $this->ShowMyProfile($user, $message);
                        } else {
                            $this->ShowUserView($user->getUserId(), $message);
                        }
                        
                    } else {
                        if($_SESSION["loggeduser"]->getProfile() == "Administrador"){
                            $this->ShowListView($message);
                        } else if ($_SESSION["loggeduser"]->getProfile() == "Estudiante"){
                            $this->ShowMyProfile($user);
                        } else {
                            $this->ShowUserView($user->getUserId());
                        }
                    }

                } else if ($rta == "email") {
                    $message = "El email ingresado ya se encuentra registrado.";
                    $this->ShowModifyView($userId, $message);
                } else if ($rta == "phoneNumber") {
                    $message = "El número de teléfono ingresado ya se encuentra registrado.";
                    $this->ShowModifyView($userId, $message);
                } 
               
            } else {
                $message = "La contraseña debe tener al menos 6 caracteres.";
                $this->ShowModifyView($userId, $message);
            }
        } else {
            $message = "Las contraseñas ingresadas no coinciden.";
            $this->ShowModifyView($userId, $message);
        }
        
    }

    public function VerifyUser ($email, $phoneNumber, $id){
        $userList = $this->userDAO->GetAll();
        $rta = "";
        if(is_array($userList)){
            foreach ($userList as $user){
                if($user->getStudent()->getEmail() == $email && $user->getUserId() != $id){
                    $rta = "email";
                    break;
                }
                if($user->getStudent()->getPhoneNumber() == $phoneNumber && $user->getUserId() != $id){
                    $rta = "phoneNumber";
                    break;
                }   
            }
        }
        return $rta;
    }

    public function ReActive($userId){
       $this->userDAO->ReActive($userId);
       $this->ShowListView();
    }
}
?>