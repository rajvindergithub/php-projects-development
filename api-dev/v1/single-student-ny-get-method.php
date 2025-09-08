<?php 
 
//display error 
//ini_set("display_error", 1);

header( "Access-Control-Allow-Origin: *" ); 
//header( "Content-type: application/json; charset: UTF-8" );
header( "Access-Control-Allow-Methods: GET" );

include( "../config/database.php" );
include( "../classes/student.php" );


$db = new Database(); 

$connection = $db->connect(); 

$student = new Student($connection); 

     if( $_SERVER['REQUEST_METHOD'] === "GET" ){
         
         $student_get_id = isset($_GET['id'])?intval($_GET['id']) : "";
         
         if( !empty( $student_get_id ) ){
             $student->id = $student_get_id; 
             $student_data = $student->get_single_data(); 
//             print_r($student_data); 
             
             if(!empty($student_data)){
                     
                 http_response_code(200);
             
                 echo json_encode(
                    array(
                        "status" => 1, 
                        "data" => $student_data
                    )    
                 ); 
                 
             }else{
                  http_response_code(404);
             
                 echo json_encode(
                    array(
                        "status" => 0, 
                        "data" => "ID not found in records"
                    )    
                 ); 
             }
             
         
             
         } 
         
         
     }else{
            http_response_code( 503 );
            echo json_encode(
                array(
                    "status" => 0,
                    "message" => "Access Deined"
                )
            ); 
     }


?>