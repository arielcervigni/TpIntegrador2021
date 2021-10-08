<?php 

    namespace Models;

    class Cellphone {

        private $code;
        private $brand;
        private $model;
        private $price;

        public function getCode () { return $this->code; }
        public function getBrand () { return $this->brand; }
        public function getModel () { return $this->model; }
        public function getPrice () { return $this->price; }

        public function setCode ($code) { $this->code = $code; }
        public function setBrand ($brand) { $this->brand = $brand; }
        public function setModel ($model) { $this->model = $model; }
        public function setPrice ($price) { $this->price = $price; }
}

?>