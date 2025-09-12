<?php 

require '../vendor/autoload.php';
use \Firebase\JWT\JWT; 


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charst=UTF-8");

include_once("../config/database.php");
include_once("../classes/users.php");


$db = new Database(); 

$connection = $db->connect(); 

$user_obj = new Users($connection); 

if($_SERVER['REQUEST_METHOD'] === "POST"){
    
    $data = json_decode(file_get_contents("php://input"));
    
//    echo '<pre>';
//    print_r($data);
//    echo '</pre>';
    
    if(!empty($data->email) && !empty($data->password)){
        
        $user_obj->email = $data->email;
//        $user_obj->password = $data->password;
        
        
        $user_data = $user_obj->check_login(); 
        
        if(!empty($user_data )){
            
            $name = $user_data['name'];
            $email = $user_data['email'];
            $password = $user_data['password'];
            
//            echo '<pre>';
//            print_r($user_data);
//            echo '</pre>';
//            echo $password; 
            
            if(password_verify($data->password, $password)){
                
                $iss = "localhost";
                $iat = time(); 
                $nbf = $iat+10;
                $ext = $iat+70;
                $aud = "my_user";
                $user_arr_data = array(
                    "id" => $user_data['id'],
                    "name" =>  $user_data['name'], 
                    "email" => $user_data['email']
                ); 
                    
                $secret_key = "token123456";     
                
                $payload_info = array(
                    "iss" => $iss,
                    "iat" => $iat,
                    "nbf" => $nbf,
                    "exp" => $ext, 
                    "aud" => $aud,
                    "data" => $user_arr_data
                ); 
                
               $jwt = JWT::encode($payload_info, $secret_key, 'HS256');
                
                   http_response_code(200);
                    echo json_encode(
                    array(
                        "status" => 1,
                        "jwt" => $jwt, 
                        "message" => "All Done! Login Credentials Matched"
                    )
                );

                
            }else{
                    http_response_code(404);
                    echo json_encode(
                    array(
                        "status" => 0,
                        "message" => "Credentials Password Not Matched"
                    )
                );
            }
            
        }else{
            http_response_code(404);
                echo json_encode(
                array(
                    "status" => 0,
                    "message" => "Input Data Empty"
                )
            );

        }
        
    }else{
        http_response_code(404);
        echo json_encode(
            array(
                "status" => 0,
                "message" => "Not Found "
            )
        );
        
    }
    
}


?>