<?php
namespace Palaeoplasticene {

    class User {
        // PROPERTIES
        private string $id;
        private string $pw;
        public string $fname;
        public string $sname;
        public string $name;
        public string $email;
        public string $created;
        public string $last_modified;
        public string $token;

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
            )
            
            {
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
        // for Id
        public function get_id(): string {
            return $this->id;
        }

        function get_fname(): string {
            return $this->fname;
        }
        function get_sname(): string {
            return $this->sname;
        }
        function get_name(): string {
            return $this->name;
        }
        function get_email(): string {
            return $this->email;
        }
        function get_created(): string {
            return $this->created;
        }
        function get_last_modified(): string{
            return $this->last_modified;
        }
        function get_token(): string {
            return $this->token;
        }
    }

}

?>