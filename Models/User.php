<?php 

    namespace Models;

    class User {

        private $userId;
        private $student;
        private $password;
        private $profile;
        private $active;
        private $company;

        public function getUserId() { return $this->userId; }
        public function getStudent() { return $this->student; }
        public function getPassword() { return $this->password; }
        public function getProfile() { return $this->profile; }
        public function getActive() { return $this->active; }
        public function getCompany() { return $this->company; }

        public function setUserId($userId) { $this->userId = $userId; }
        public function setStudent($student) { $this->student = $student; }
        public function setPassword($password) { $this->password = $password; }
        public function setProfile($profile) { $this->profile = $profile; }
        public function setActive($active) { $this->active = $active; }
        public function setCompany($company) { $this->company = $company; }

    }