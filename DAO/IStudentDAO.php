<?php
namespace DAO;

use Models\Student as Student;

interface IStudentDAO{

    function add (Student $Student);
    function getAll();
    
}

?>