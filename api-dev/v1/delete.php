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
    
    
    $student_id = isset($_GET['id'])?$_GET['id']: ""; 
    
    
        if(!empty($student_id)){
            
            $student->id = $student_id; 
            
            if($student->delete_student()){
                
                http_response_code(200);

                echo json_encode(
                    array(
                        "status" => 1,
                        "message" => "Student deleted successfully"
                    )
                );
                
            }else{
                
                http_response_code(500);

                echo json_encode(
                    array(
                        "status" => 0,
                        "message" => "Failed to delete action"
                    )
                );
                
            }
            
        }else{
            
             http_response_code( 404 );

                echo json_encode(
                    array(
                        "status" => 0,
                        "message" => "Student ID Not Found"
                    )
                );
            
        }


       http_response_code( 200 );

            echo json_encode(
                array(
                    "status" => 1,
                    "message" => "Student has been created."
                )
            );


    } else{
        http_response_code( 503 );
        echo json_encode(
        array(
            "status" => 0,
            "message" => "Access Deined"
        )
        ); 
     }