<?php
class Experiment {
    // Properties
    private $id;
    public $name;
    public $category;
    private $userId;
    public $license;

    // Constructor
    public function __construct($id, $name, $category, $userId, $license) {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->userId = $userId;
        $this->license = $license;
    }

    // Methods
    function get_id() {
        return $this->id;
    }
    function get_name() {
        return $this->name;
    }
    function get_category() {
        return $this->category;
    }
    function get_userId() {
        return $this->userId;
    }
    function get_license() {
        return $this->license;
    }
}
?>