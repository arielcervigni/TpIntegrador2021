<?php
namespace Controllers;

use Controllers\AppointmentController as AppointmentController;
use Controllers\HomeController as HomeController;
use Models\Appointment as Appointment;

class FileController
{
    private $appointmentController;
    private $homeController;

    public function __construct()
    {
       $this->appointmentController = new AppointmentController();
       $this->homeController = new HomeController();
    }

    public function ShowJobOffers($message = ""){
        $this->homeController->Index($message);
    }


    public function UpdateFile ($id, $description = "", $file)
    {
        
        if($_FILES['resume']['error'] == 4){
            $message = "No hay archivo seleccionado.";
            $this->appointmentController->ShowJobOffer($id,$message);
        } else {
            $file_name = $_FILES['resume']['name'];
            $file_size = $_FILES['resume']['size'];
            $file_tmp = $_FILES['resume']['tmp_name'];
            $file_type = $_FILES['resume']['type'];
            $file_ext_aux = explode('.',$file_name);
            $file_ext = end($file_ext_aux);
            
            $expensions = array('pdf','docx','doc');

            if(in_array($file_ext,$expensions)===false){
                $message = "El archivo seleccionado no tiene un formato válido.";
                $this->appointmentController->ShowJobOffer($id,$message);
            } 

            if($file_size > 5242880){
                $message = "El archivo seleccionado supera el límite (5MB).";
                $this->appointmentController->ShowJobOffer($id,$message);
            }

            move_uploaded_file($file_tmp,"Resumes/".$file_name);
            $message = "Postulación guardada con éxito!"; 

            $appointment = new Appointment();
            $appointment->setJobOffer($id);
            $appointment->setStudent($_SESSION['loggeduser']->getStudent()->getStudentId());
            $appointment->setDescription($description);
            $appointment->setResume($file_name);

            var_dump($appointment);

            $this->ShowJobOffers($message);

            
        }
    }



    

   
}
?>