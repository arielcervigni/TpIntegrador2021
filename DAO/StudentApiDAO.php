<?php

    namespace DAO;

    use Models\Student as Student;
    use Models\Career as Career;
    use DateTime as DateTime;
    use Database\Connection as Connection;

    class StudentApiDAO
    {

        function GetAll($list){

            $get_data = $this->callAPI('GET', 'https://utn-students-api.herokuapp.com/api/Student/',false);
            $response = json_decode($get_data, true);
            //$errors = $response['response']['errors'];
            //var_dump($response);
            $studentList = array();
            //if(!empty($careerList)){
               foreach ($response as $studentAPI){
                  $student = new Student();
                  $career = new Career();

                  $student->setStudentId($studentAPI['studentId']);
                  $career = $this->searchInArray($list, $studentAPI['careerId']);
                  $student->setCareer($career);
                  $student->setFirstName($studentAPI['firstName']);
                  $student->setLastName($studentAPI['lastName']);
                  $student->setDni($studentAPI['dni']);
                  $student->setFileNumber($studentAPI['fileNumber']);
                  $student->setGender($studentAPI['gender']);
                  $d = new DateTime($studentAPI['birthDate']);
                  $student->setBirthDate($d->format('Y-m-d'));
                  $student->setEmail($studentAPI['email']);
                  $student->setPhoneNumber($studentAPI['phoneNumber']);
                  $student->setActive($studentAPI['active']);
                  $student->setProfile("Student");

                  array_push($studentList,$student);
               //}
            }

            // array_push($studentList,$this->createUserAdmin($list));
            return $studentList;
            
        }

      //   function createUserAdmin ($careerList) {
      //    $student = new Student();
      //    $career = new Career();
      //    $career = $this->searchInArray($careerList, 1);
      //    //var_dump($career);
      //    $student->setStudentId(9999999999);
      //    $student->setCareer($career);
      //    $student->setFirstName("Ariel");
      //    $student->setLastName("Cervigni");
      //    $student->setDni("37098210");
      //    $student->setFileNumber("21-891-4548");
      //    $student->setGender("Masculino");
      //    $student->setBirthDate("1992-07-18");
      //    $student->setEmail("arielcervigni@gmail.com");
      //    $student->setPhoneNumber("2235939221");
      //    $student->setActive(true);
      //    $student->setProfile("Administrador");

      //    return $student;
      //   }

        function callAPI($method, $url, $data){
            $curl = curl_init();
            switch ($method){
               case "POST":
                  curl_setopt($curl, CURLOPT_POST, 1);
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                  break;
               case "PUT":
                  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                  if ($data)
                     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
                  break;
               default:
                  if ($data)
                     $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            // OPTIONS:
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
               'x-api-key: 4f3bceed-50ba-4461-a910-518598664c08',
               'Content-Type: application/json',
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            // EXECUTE:
            $result = curl_exec($curl);
            if(!$result){die("Connection Failure");}
            curl_close($curl);
            return $result;
         }

         function searchInArray($careerList, $id) {
            foreach ($careerList as $career){
               if($career->getCareerId() == $id){
                  return $career;
               }
            }
            return null;
         }

         function Remove($id){

         }

         function Modify($id){

         }

         function Add($data){

         }

         function GetStudentById($careerList, $studentId, $studentList = null) {
            if($studentList == null)
               $studentList = $this->GetAll($careerList);
            $student = null;
            foreach($studentList as $student){
               if($student->getStudentId() == $studentId)
                  return $student;
            }
         }

      
    }
?>
