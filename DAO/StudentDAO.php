<?php
namespace DAO;

use DAO\IStudentDAO as IStudentDAO;
use Models\Student as Student;

class StudentDAO implements IStudentDAO {

    private $studentList = array();

    public function getStudentList () { return $this->studentList; }
    public function setCellphoneList ($studentList) { $this->studentList = $studentList; }

    function add (Student $newStudent)
    {
        $this->retriveData();
        array_push($this->studentList, $newStudent);
        $this->saveData();
    }

    function getAll()
    {
        $this->retriveData();
        return $this->studentList;
    }

    function retriveData()
    {
    
            $this->studentList = array();

            $jsonPath = $this->GetJsonFilePath();
            
            $jsonContent = file_get_contents($jsonPath);
    
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true): array();

            foreach ($arrayToDecode as $value)
            {
                $student = new Student();
                $student->setFirstName($value["firstName"]);
                $student->setLastName($value["lastName"]);
                $student->setDni($value["dni"]);
                $student->setEmail($value["email"]);
                $student->setPhoneNumber($value["phoneNumber"]);

                array_push ($this->studentList, $student);
                sort($this->studentList);
            }
    }


    function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->cellphoneList as $cellphone)
        {
            $valueArray = array();

            $valueArray ['code'] = $cellphone->getCode(); 
            $valueArray ['brand'] = $cellphone->getBrand();
            $valueArray ['model'] = $cellphone->getModel();
            $valueArray ['price'] = $cellphone->getPrice();
        
            array_push($arrayToEncode, $valueArray);
           
        }

    
        $jsonContent = json_encode($arrayToEncode,JSON_PRETTY_PRINT);
        file_put_contents("Data/cellphones.json", $jsonContent);

    }


    function GetJsonFilePath(){

        $initialPath = "Data/students.json";
        if(file_exists($initialPath)){
            $jsonFilePath = $initialPath;
        }else{
            $jsonFilePath = "../".$initialPath;
        }

        return $jsonFilePath;
    }
}

?>