<?php 

    class Users{
        
        public $name; 
        public $email; 
        public $password; 
        public $user_id; 
        public $project_name; 
        public $description; 
        public $status; 
        
        private $conn;
        private $users_tbl;
        private $projects_tbl;
        
        public function __construct($db){
            
            $this->conn = $db;
            $this->users_tbl = 'tbl_user';
            $this->projects_tbl = 'tbl_projects';
            
        }
        
        public function create_user(){
            
            $user_query= "INSERT INTO ".$this->users_tbl." SET name = ?, email = ?, password = ?";
            
            $user_obj = $this->conn->prepare($user_query); 
            
            $user_obj->bind_param("sss", $this->name, $this->email, $this->password);
            
            if($user_obj->execute()){
                return true;
            }else{
                return false; 
            }
            
        }
        
        public function check_email(){
            
            $email_query = "SELECT * from ".$this->users_tbl." WHERE email = ?";
            
            $obj_email = $this->conn->prepare($email_query); 
            
            $obj_email->bind_param("s", $this->email);
            
            if($obj_email->execute()){
                $data = $obj_email->get_result(); 
                return $data->fetch_assoc(); 
            }
            
            return array(); 
        }
        
        public function check_login(){
            
            $email_query = "SELECT * FROM ".$this->users_tbl." WHERE email = ?"; 
            
            $email_obj = $this->conn->prepare($email_query);
            
            $email_obj->bind_param("s", $this->email);
            
            if($email_obj->execute()){
                $data = $email_obj->get_result(); 
                return $data->fetch_assoc(); 
            }
            
            return array();
            
        }
        
        public function create_project(){
            
            $project_query = "Insert into ".$this->projects_tbl." SET user_id = ?, name = ?, description = ?, status = ?"
            
            $project_obj = $this->conn->prepare($project_query);
            
            $project_name = htmlspecialchars(strip_tags($this->project_name));
            $description = htmlspecialchars(strip_tags($this->description));
            $status = htmlspecialchars(strip_tags($this->status));
            
            $project_obj->bind_param("isss", $this->user_id, $this->project_name, $this->description, $this->status );
            
            if( $project_obj->execute()){
                return true;
            }else{
                return false; 
            }    
        }
        
        
    }



?>