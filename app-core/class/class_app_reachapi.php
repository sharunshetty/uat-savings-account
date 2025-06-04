<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 3.0.0
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** ReachWeb API (JSON Comm.) */
class ReachWebAPI {

    private $api_server;

    public function __construct() {
        $this->api_server = API_REMOTE_ADDRESS;
    }

    /** Change API IP/Host */
    public function ReachChangeServer($host) {
        $this->api_server = $host;
    }

    /** Reach API Connection */
    public function ReachConnect(array $data, $max_timeout = 10, $session = true) {
        $conn = new RemoteAPI;
        $response = $conn->connect( $this->api_server, 'get', $data, $max_timeout, $session);
        if($response) {
            $obj = json_decode($response);
            // No valid data
            if(isset($obj->{'DATA'})) {
                $response = json_decode($obj->{'DATA'}, true);
                //$response = json_decode(json_encode($obj->{'DATA'}), true);
            } else {
                $response = NULL;
            }
        }
        return $response;
    }

    /** Reach API Multi Connection */
    public function ReachMultiConnect(array $data, $max_timeout = 10, $session = true) {
        $conn = new RemoteAPI;
        $response = $conn->multi_connect( $this->api_server, 'get', $data, $max_timeout, $session);
        if($response) {
            if(is_array($response)) {
                foreach ($response as $key => $value ) {
                    $obj = json_decode($value);
                    // No valid data
                    if(isset($obj->{'DATA'})) {
                        $response = json_decode($obj->{'DATA'}, true);
                        //$response[$key] = json_decode(json_encode($obj->{'DATA'}), true);
                    } else {
                        $response[$key] = NULL;
                    }
                }
            } else {
                $obj = json_decode($response);
                // No valid data
                if(isset($obj->{'DATA'})) {
                    $response = json_decode($obj->{'DATA'}, true);
                    //$response = json_decode(json_encode($obj->{'DATA'}), true);
                } else {
                    $response = NULL;
                }
            }
        }
        return $response;
    }

}
