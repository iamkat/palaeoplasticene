<?php
namespace Palaeoplasticene {

    class Experiment {
        // PROPERTIES
        private string $id;
        public string $name;
        public string $category;
        private string $userId;
        public string $license;
    
        // CONSTRUCTOR
        public function __construct(
            string $id,
            string $name,
            string $category,
            string $userId,
            string $license
            )
            
            {
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
        // for Id
        function set_id(): void {
    
        }
    
        function get_id(): string {
            return $this->id;
        }
    
    
        function get_name(): string {
            return $this->name;
        }
        function get_category(): string {
            return $this->category;
        }
        function get_userId(): string {
            return $this->userId;
        }
        function get_license(): string {
            return $this->license;
        }
    }

}
?>