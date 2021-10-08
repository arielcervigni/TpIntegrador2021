<?php
namespace DAO;

use DAO\IUserDAO as IUserDAO;
use Models\User as User;

class UserDAO implements IUserDAO {

    private $userList = array();

    public function getUserList () { return $this->userList; }
    public function setUserList ($userList) { $this->userList = $userList; }

    function add (User $newUser)
    {
        $this->retriveData();
        array_push($this->userList, $newUser);
        $this->saveData();
    }

    function getAll()
    {
        $this->retriveData();
        return $this->userList;
    }

    function retriveData()
    {
    
            $this->userList = array();

            $jsonPath = $this->GetJsonFilePath();
            
            $jsonContent = file_get_contents($jsonPath);
    
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true): array();

            foreach ($arrayToDecode as $value)
            {
                $user = new user();
                $user->setUsername($value["username"]);
                $user->setPassword($value["password"]);
                array_push ($this->userList, $user);
                sort($this->userList);
            }
    }


    function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->userList as $user)
        {
            $valueArray = array();

            $valueArray ['username'] = $user->getUsername(); 
            $valueArray ['password'] = $user->getPassword();
        
            array_push($arrayToEncode, $valueArray);
           
        }

    
        $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents("Data/users.json", $jsonContent);

    }


    function GetJsonFilePath(){

        $initialPath = "Data/users.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}

?>