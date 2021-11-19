<?php 

    namespace Models;

    class JobOffer {

        private $jobOfferId;
        private $company;
        private $province;
        private $city;
        private $endDate;
        private $jobPosition;
        private $modality;
        private $availability;
        private $description;
        private $carrerId;
        private $active;
       
        public function getJobOfferId () { return $this->jobOfferId; }
        public function getCompany () { return $this->company; }
        public function getProvince () { return $this->province; }
        public function getCity () { return $this->city; }
        public function getEndDate () { return $this->endDate; }
        public function getJobPosition () { return $this->jobPosition; }
        public function getModality () { return $this->modality; }
        public function getAvailability () { return $this->availability; }
        public function getDescription () { return $this->description; }
        public function getCarrerId() { return $this->careerId; }
        public function getActive () { return $this->active; }

        public function setJobOfferId ($jobOfferId) { $this->jobOfferId = $jobOfferId; }
        public function setCompany ($company) { $this->company = $company; }
        public function setProvince ($province) { $this->province = $province; }
        public function setCity ($city) { $this->city = $city; }
        public function setEndDate ($endDate) { $this->endDate = $endDate; }
        public function setJobPosition ($jobPosition) { $this->jobPosition = $jobPosition; }
        public function setModality ($modality) { $this->modality = $modality; }
        public function setAvailability ($availability) { $this->availability = $availability; }
        public function setDescription ($description) { $this->description = $description; }
        public function setCareerId ($carrerId) { $this->carrerId = $carrerId; }
        public function setActive ($active) { $this->active = $active; }



}

?>