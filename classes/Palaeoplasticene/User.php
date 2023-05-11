<?php
namespace Palaeoplasticene {

    class User {
        // PROPERTIES
        private string $id;
        private string $pw;
        private string $fname;
        private string $sname;
        private string $name;
        private string $email;
        private string $created;
        private string $last_modified;
        private string $token;

        // CONSTRUCTOR
        public function __construct(
            string $id,
            string $pw,
            string $fname,
            string $sname,
            string $name,
            string $email,
            string $created,
            string $last_modified,
            string $token
        ) {
            // Validation and Exception Handling needed
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

        // DESTRUCTOR
        public function __destruct() {
            ;
        }

        // METHODS
        public function get_id(): string {
            return $this->id;
        }

        public function get_fname(): string {
            return $this->fname;
        }
        
        public function get_sname(): string {
            return $this->sname;
        }
        
        public function get_name(): string {
            return $this->name;
        }

        public function get_email(): string {
            return $this->email;
        }

        public function get_created(): string {
            return $this->created;
        }
        
        public function get_last_modified(): string{
            return $this->last_modified;
        }
        
        public function get_token(): string {
            return $this->token;
        }
    }

}

?>