<?php

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

use \Firebase\JWT\Key;

header( "Access-Control-Allow-Origin: *" );
header( "Access-Control-Allow-Methods: POST" );
header( "Content-type: application/json; charst=UTF-8" );

include_once( "../config/database.php" );
include_once( "../classes/users.php" );

$db = new Database();

$connection = $db->connect();

$user_obj = new Users( $connection );

if ( $_SERVER['REQUEST_METHOD'] === "POST" ) {

    //$data = json_decode( file_get_contents( "php://input" ) );

    //print_r( $data );


    //$jwt_data = $data->jwt;

    //data from header

    $all_headers = getallheaders();

    $jwt_data = $all_headers['Authorization'];

    if ( !empty(  $jwt_data ) ) {

        try {

            $secret_key = "token123456";

            $jwt_decode = JWT::decode( $jwt_data, new Key( $secret_key, 'HS256' ) );

            http_response_code( 200 );

            echo json_encode(
                array(
                    "status" => 1,
                    "message" => "JWT Token Recevied",
                    "JWT Decode" => $jwt_decode
                )
            );

        } catch( Exception $ex ) {

            http_response_code( 500 );

            echo json_encode(
                array(
                    "status" => 0,
                    "message" => $ex->getMessage()
                )
            );

        }

    }

}

?>