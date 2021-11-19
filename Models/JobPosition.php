<?php 

    namespace Models;

    class JobPosition {

        private $jobPositionId;
        private $careerId;
        private $description;
        
        public function getCareerId () { return $this->careerId; }
        public function getDescription () { return $this->description; }
        public function getJobPositionId () { return $this->jobPositionId; }


        public function setCareerId ($careerId) { $this->careerId = $careerId; }
        public function setDescription ($description) { $this->description = $description; }
        public function setJobPositionId ($jobPositionId) { $this->jobPositionId = $jobPositionId; }

}

?>