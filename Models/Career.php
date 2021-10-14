<?php 

    namespace Models;

    class Career {

        private $careerId;
        private $description;
        private $active;
        
        public function getCareerId () { return $this->careerId; }
        public function getDescription () { return $this->description; }
        public function getActive () { return $this->active; }


        public function setCareerId ($careerId) { $this->careerId = $careerId; }
        public function setDescription ($description) { $this->description = $description; }
        public function setActive ($active) { $this->active = $active; }

}

?>