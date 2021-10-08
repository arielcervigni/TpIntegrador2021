<?php
namespace Controllers;


use DAO\UserDAO as UserDAO;
use Models\User as User;

class UserController 
{
    private $userDAO;
    private $companayController;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
        $this->companyController = new CompanyController();
    }

    public function ShowAddView ($message = "")
    {
        //session_start();
        require_once(VIEWS_PATH."add-company.php");
    }

    public function ShowHome ($message = "")
    {
        require_once(VIEWS_PATH."home.php");
    }
    

    public function login ($username, $password)
    {
        $userList = $this->userDAO->getAll();
        $checkUser = 0;
        $checkPassword = 0;

        foreach ($userList as $user)
        {
            if($user->getUsername() == $username)
            {
                $checkUser = 1;

                if($user->getPassword() ==  $password)
                    $checkPassword = 1;
            }
        }

        if($checkUser == 1)
        {
            if($checkPassword == 1)
            {
                //session_start();
                $user = new User();
                $user->setUsername($username);
                $user->setPassword($password);
                $_SESSION["loggeduser"] = $user;
                echo $_SESSION["loggeduser"]->getUsername();

                $this->companyController->ShowAddView();

            }
            else
            {
                $message = "Contraseña incorrecto.";
                require_once (VIEWS_PATH."home.php");
            }
        }
        else
        {
            $message = "Usuario incorrecto.";
            require_once (VIEWS_PATH."home.php");
        }
    }
}

?>