<?php
class User {
    // Properties
    private $id;
    private $pw;
    public $fname;
    public $sname;
    public $name;
    public $email;
    public $created;
    public $last_modified;
    public $token;

    // Constructor
    public function __construct($id, $pw, $fname, $sname, $name, $email, $created, $last_modified, $token) {
        $this->id = $id;
        $this->pw = $pw;
        $this->fname = $fname;
        $this->sname = $sname;
        $this->name = $name;
        $this->email = $email;
        $this->created = $created;
        $this->last_modified = $last_modified;
        $this->token = $token;
    }

    // Methods
    function get_id() {
        return $this->id;
    }
    function get_fname() {
        return $this->fname;
    }
    function get_sname() {
        return $this->sname;
    }
    function get_name() {
        return $this->name;
    }
    function get_email() {
        return $this->email;
    }
    function get_created() {
        return $this->created;
    }
    function get_last_modified() {
        return $this->last_modified;
    }
    function get_token() {
        return $this->token;
    }
}
?>