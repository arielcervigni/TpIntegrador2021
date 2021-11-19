<?php 

    namespace Models;

    class Appointment {

        private $appointmentId;
        private $student;
        private $jobOffer;
        private $resume;
        private $description;
        private $active;
        
        public function getAppointmentId () { return $this->appointmentId; }
        public function getStudent() { return $this->student; }
        public function getJobOffer() { return $this->jobOffer; }
        public function getResume() { return $this->resume; }
        public function getDescription () { return $this->description; }
        public function getActive () { return $this->active; }


        public function setAppointmentId ($appointmentId) { $this->appointmentId = $appointmentId; }
        public function setStudent ($student) { $this->student = $student; }
        public function setJobOffer ($jobOffer) { $this->jobOffer = $jobOffer; }
        public function setResume ($resume) { $this->resume = $resume; }
        public function setDescription ($description) { $this->description = $description; }
        public function setActive ($active) { $this->active = $active; }

}

?>