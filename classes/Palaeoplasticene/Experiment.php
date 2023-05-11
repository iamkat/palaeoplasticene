<?php
namespace Palaeoplasticene {

    class Experiment {
        // PROPERTIES
        private string $id;
        private string $name;
        private string $category;
        private string $userId;
        private string $license;
    
        // CONSTRUCTOR
        public function __construct(
            string $id,
            string $name,
            string $category,
            string $userId,
            string $license
        ) {
            // Validation and Exception Handling needed
            $this->id = $id;
            $this->name = $name;
            $this->category = $category;
            $this->userId = $userId;
            $this->license = $license;
        }

        // DESTRUCTOR
        public function __destruct() {
            ;
        }
    
        // METHODS
        function get_id(): string {
            return $this->id;
        }
    
        public function get_name(): string {
            return $this->name;
        }

        public function get_category(): string {
            return $this->category;
        }

        public function get_userId(): string {
            return $this->userId;
        }

        public function get_license(): string {
            return $this->license;
        }
    }

}
?>