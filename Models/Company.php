<?php 

    namespace Models;

    class Company {

        private $companyId;
        private $cuit;
        private $description;
        private $aboutUs;
        private $companyLink;
        private $active;
        
        public function getCompanyId () { return $this->companyId; }
        public function getCuit () { return $this->cuit; }
        public function getDescription () { return $this->description; }
        public function getAboutUs () { return $this->aboutUs; }
        public function getCompanyLink () { return $this->companyLink; }
        public function getActive () { return $this->active; }


        public function setCompanyId ($companyId) { $this->companyId = $companyId; }
        public function setCuit ($cuit) { $this->cuit = $cuit; }
        public function setDescription ($description) { $this->description = $description; }
        public function setAboutUs ($aboutUs) { $this->aboutUs = $aboutUs; }
        public function setCompanyLink ($companyLink) { $this->companyLink = $companyLink; }
        public function setActive ($active) { $this->active = $active; }

}

?>