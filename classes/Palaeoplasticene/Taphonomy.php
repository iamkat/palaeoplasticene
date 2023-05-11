<?php
namespace Palaeoplasticene {

    class Taphonomy {
        // PROPERTIES
        private string $id;
        private string $name;
        private string $userId;
        private string $license;
        private string $location;
        private string $surroundings;
        private Array $images;
    
        // CONSTRUCTOR
        public function __construct(
            string $id,
            string $name,
            string $userId,
            string $license,
            string $location,
            string $surroundings,
            Array $images
        ) {
            // Validation and Exception Handling needed
            $this->id = $id;
            $this->name = $name;
            $this->userId = $userId;
            $this->license = $license;
            $this->location = $location;
            $this->surroundings = $surroundings;
            $this->images = $images;
        }

        // DESTRUCTOR
        public function __destruct() {
            ;
        }
    
        // METHODS
        public function get_id(): string {
            return $this->id;
        }

        public function get_name(): string {
            return $this->name;
        }

        public function get_userId(): string {
            return $this->userId;
        }

        public function get_license(): string {
            return $this->license;
        }

        public function get_location(): string {
            return $this->location;
        }

        public function get_surroundings(): string {
            return $this->surroundings;
        }

        public function get_images(): Array {
            return $this->images;
        }
    }

}
?>