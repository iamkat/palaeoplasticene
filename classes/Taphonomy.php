<?php
class Taphonomy extends Experiment {
    // Properties
    public $location;
    public $surroundings;

    // Constructor
    public function __construct($id, $name, $userId, $license, $location, $surroundings) {
        $this->id = $id;
        $this->name = $name;
        $this->userId = $userId;
        $this->license = $license;
        $this->location = $location;
        $this->surroundings = $surroundings;
    }

    // Methods
    function get_location() {
        return $this->location;
    }
    function get_surroundings() {
        return $this->surroundings;
    }
}
?>