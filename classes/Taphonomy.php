<?php

namespace Palaeoplasticene {

    class Taphonomy extends Experiment {
        // Properties
        public string $location;
        public string $surroundings;
    
        // Constructor
        public function __construct(
            string $id,
            string $name,
            string $userId,
            string $license,
            string $location,
            string $surroundings
            )
            
            {
                $this->id = $id;
                $this->name = $name;
                $this->userId = $userId;
                $this->license = $license;
                $this->location = $location;
                $this->surroundings = $surroundings;
        }

        // DESTRUCTOR
        public function __destruct() {
            ;
        }
    
        // Methods
        function get_location(): string {
            return $this->location;
        }
        function get_surroundings(): string {
            return $this->surroundings;
        }
    }

}
?>