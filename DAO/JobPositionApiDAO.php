<?php

    namespace DAO;
    
    use Models\JobPosition as JobPosition;

    class JobPositionApiDAO
    {

        function GetAll($list = ""){

            $get_data = $this->callAPI('GET', 'https://utn-students-api.herokuapp.com/api/JobPosition/',false);
            $response = json_decode($get_data, true);
            
            $jobPositionList = array();
            foreach ($response as $JobPositionAPI){
               $jobPosition = new JobPosition();
               $jobPosition->setJobPositionId($JobPositionAPI['jobPositionId']);
               $jobPosition->setCareerId($JobPositionAPI['careerId']);
               $jobPosition->setDescription($JobPositionAPI['description']);
               //var_dump($career);
               array_push($jobPositionList,$jobPosition);
            }
            var_dump($jobPositionList);
            return $jobPositionList;
            
        }


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
    }

    function Add($data){

    }

    function Remove($id){

    }

    function Modify($id){

    }
?>
