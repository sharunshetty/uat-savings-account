<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : LCode PHP WebFrame
 * @version     : 2.2.0
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

/** Reach MB API (For jBoss Comm.) */
class ReachMobApi {

    private $api_server;

    private $public_key = "-----BEGIN CERTIFICATE-----
MIIDYDCCAkigAwIBAgIJAMdFlpRd/u/OMA0GCSqGSIb3DQEBCwUAMEUxCzAJBgNV
BAYTAklOMQswCQYDVQQIDAJLQTEMMAoGA1UEBwwDTUxSMQ4wDAYDVQQKDAVMQ29k
ZTELMAkGA1UECwwCSVQwHhcNMjEwOTE3MTA1ODE5WhcNMzEwOTE1MTA1ODE5WjBF
MQswCQYDVQQGEwJJTjELMAkGA1UECAwCS0ExDDAKBgNVBAcMA01MUjEOMAwGA1UE
CgwFTENvZGUxCzAJBgNVBAsMAklUMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIB
CgKCAQEAv3YF+oYn3jk0PwhOp+WRkmN3CuV/zJeMDN1x2G1KxPK1wiOAdNhVaQ1S
J2PvKHUZf6Aj+jAYwPPAE6OpgUFrDdVSRcpcIAECPjVUNY+YklBQC8+8WOjn3PLq
In1bs+0PFiVK61bPNnI4tdPYPh41FxOG/a2pf54sFUhpIiGJSU9mJUooCrIbvB84
NJbRX5/8IgSIhUBVg76I8Xa3PZqsGfyrB5A7A3GU7lUHz5CKN7wqeKpBq0o2S6Q2
wFtxfrRRWqhS33vrfRcB1xW3HEG0m4o38VZCPowxiFyV858I4Xy+4OGgpdek92LZ
sh2/BLMKRkGVAyS3g1gUIbii9H4s+wIDAQABo1MwUTAdBgNVHQ4EFgQUePkuKpH6
24Ee8AY34Ghh8HVWkTkwHwYDVR0jBBgwFoAUePkuKpH624Ee8AY34Ghh8HVWkTkw
DwYDVR0TAQH/BAUwAwEB/zANBgkqhkiG9w0BAQsFAAOCAQEAN49gkJQ/U0efYkys
eyCmooT+VZyzX94KvVJg3ivJ6sD+9n5ECBQHuqtZR+iP20Xb94DbvuEvQTnwSaBQ
QfhZTHzPpA1qvHN5dDxaFw90MOTEsmKfms3uodPZXyDmnQt6JfS32tgIqRe8xPCx
6oYSp1FkKdQgx9qlSdQ2PimqH+U/Lp63XG805SZmLk4pxvxVJlijR08BnBA3wYdG
h21W/v6SQwW10iJxNc8x0hJlSzTvnrEjXNBDj+juw/R2dB3EZP8VuGB/A54SF10X
nWOZrHmyaLdSgDU6Lrr1twAZwOmVaPqdo703uYvJTrYyyi1uHLOOZAWEozEtxeBi
sdgA2A==
-----END CERTIFICATE-----";

    private $private_key = "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEAv3YF+oYn3jk0PwhOp+WRkmN3CuV/zJeMDN1x2G1KxPK1wiOA
dNhVaQ1SJ2PvKHUZf6Aj+jAYwPPAE6OpgUFrDdVSRcpcIAECPjVUNY+YklBQC8+8
WOjn3PLqIn1bs+0PFiVK61bPNnI4tdPYPh41FxOG/a2pf54sFUhpIiGJSU9mJUoo
CrIbvB84NJbRX5/8IgSIhUBVg76I8Xa3PZqsGfyrB5A7A3GU7lUHz5CKN7wqeKpB
q0o2S6Q2wFtxfrRRWqhS33vrfRcB1xW3HEG0m4o38VZCPowxiFyV858I4Xy+4OGg
pdek92LZsh2/BLMKRkGVAyS3g1gUIbii9H4s+wIDAQABAoIBABlpFp4LVBtASFjd
R2MtKsbdAJ2nm/CRZHsIoOVyi+vbspfTkmbvl1Zb+D1WHBWohPvVSzEXVRG2yBVT
MVoATq8FUugEVXnB6IRNG6IILt2sXxNSPNMoBi3i54QwUw1sNwZfaLQXT2UQf8pS
FW8ZHz6yzsW4WLihS4R/mcR34vqhnhEhCk4zL/jgbMKe+96/GDUbBOMIyvrN1Wji
qxbUgGVFa4F9vjFGIF6AvT0LpjlIeC/qCvnDIYaoDm0SiZRCuDCIcyrhDboWNTsv
pNDS273pY5wWGQuxeAo1p/EAief3UZ9Mb730HMpYgPM4wh5h6KNsWUz129C5Xpgn
nGzLiDECgYEA8loInIo6JGs+iZZZs3+/IpohxijDEqNHOAuI4SscF14YszEddRs8
3CpT/mfTDdVsBD4DIRG9m9SFknLEAJJnvi81JhoxMf8XB//zflqdE5wz+eUdMQ2v
E3UK4EmelGgm+OHWN2263N55HTFbsJ/eBI/Ouo9WDlsjJNbvlwwArAUCgYEAyj5N
gs/zOPKQ0G8nrPspsgbv8ewCaVOytB8zl0ds4rxO16vLQVCuKzzg2H7Y/zYlBH0a
iJ5QaAZoP7rftQFdGjnaUEkVBc4su5R5SBsvWt4ar5yvHX/nMOvjoRnjaIJ7V0E0
wwjKO3UdcJOLVP9KbRkEWBa1gMJWRZnVcyTTxP8CgYAIUgL9rNk2KuBoxNqriPU8
8OG79eZMm4J0cCDw6hP60WYzsLn8LUU3odRkZZgfX3Zn5uEgn4VM9kznrD0CcART
yTcf6cJKnyFhSu5HJkFCTRiTucP4zSl3l4saDCz/l1vPK6G5IXFK5/BsiidFtxde
PLmyOf2QXJymRSLQor7bKQKBgQCrIYL3AL1fX6l4JcZd0f1bHhGlFL6Jn4AkeA5w
oMibJxpT1pNbxkhKX+4mY1d8xLUYEkAEgGmrTFikLJ2lDO1aBsAblWuLiQVDCISD
pjUw36WXGa73+EWJmOD5be2Gfnqdv5hEvEhbfWMW4lJQ7uBsZnHNlBGrTUYxCNWb
4/qpwwKBgQDNZoEABA/G40BLVO6qFE5nqzsCKB+QNUrlJFdgwQs5x9zzrLuv37KT
QkdxBNXNu6lPO41iKfuh8QQ0ZIu8sg/7rFRFKNZiKY24Oc2kRGNU/GvSCdYtVxtr
DRtpWFLvBi6raJiF5XAR6E/Iocx1IneQtJxHAijNFDbdaQ4wEO9wpg==
-----END RSA PRIVATE KEY-----"; // 2048-bits Key

    public function __construct() {
        $this->api_server = API_REMOTE_ADDRESS;
    }

    /** Change API IP/Host */
    public function ChangeServer($host) {
        $this->api_server = $host;
    }

    /**  AES Encryption : AES/ECB/PKCS5PADDING */
    public function aes_encrypt($str, $key) {
        $data = openssl_encrypt($str, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return base64_encode($data);
    }

    /** AES Decryption : AES/ECB/PKCS5PADDING */
    public function aes_decrypt($str, $key) {
        $data = openssl_decrypt(base64_decode($str), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);
        return $data;
    }

    /** RSA Encryption : RSA/ECB/PKCS1Padding */
    public function rsa_encrypt($data) {
        if(openssl_public_encrypt($data, $encrypted, $this->public_key)) {
            return base64_encode($encrypted);
        }
        return false;
    }

    /** RSA Decryption : RSA/ECB/PKCS1Padding */
    public function rsa_decrypt($data) {
        if(openssl_private_decrypt(base64_decode($data), $decrypted, $this->private_key)) {
            return $decrypted;
        }
        return false;
    }

    /** API Connection */
    public function ReachMobConnect($data, $max_timeout = null) {

        global $main_app;
        $api_channel_id = API_REACH_MB_CHANNEL;

        if(!isset($_SESSION['SAFE_AES128_KEY']) || $_SESSION['SAFE_AES128_KEY'] == NULL) {
            $main_app->session_set([ 'SAFE_AES128_KEY' => substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 16) ]); // New random key
        }
        
        $build_data = array();
        $build_data['CHANNEL_ID'] = $api_channel_id;
        $build_data['ENC_DATA'] = $this->aes_encrypt(json_encode($data, JSON_UNESCAPED_SLASHES), $_SESSION['SAFE_AES128_KEY']);
        $build_data['ENC_KEY'] = $this->rsa_encrypt($_SESSION['SAFE_AES128_KEY']);

        if($build_data['ENC_DATA'] == false) {
            throw new Exception('A01: Unable to build API request');
        }
        elseif($build_data['ENC_KEY'] == false) {
            throw new Exception('A02: Unable to build API request');
        }

        //Log API Create
        $ApiLogId = $main_app->sql_sequence("LOG_EXTAPI_SENT_SEQ"); // Seq. No.
        
        if($ApiLogId == false || $ApiLogId == "" || $ApiLogId == "1" || $ApiLogId == NULL) {
            throw new Exception('Unable to build API reference number');
        }

        $api_log = array();
        $api_log['REQ_NUM'] = $ApiLogId;
        $api_log['REQ_CHANNEL_CODE'] = $api_channel_id;
        $api_log['REQ_SERVICE_CODE'] = isset($data['METHOD_NAME']) ? $data['METHOD_NAME'] : NULL;
        $api_log['REQ_RAW_DATA'] = is_array($data) ? json_encode($data) : $data;
        if($data != $build_data) {
            $api_log['REQ_DATA'] = is_array($build_data) ? json_encode($build_data) : $build_data;
        }
        $api_log['CR_ON'] = date("Y-m-d H:i:s");
        $api_log['CR_BY'] = isset($_SESSION['USER_REF_NUM']) ? $_SESSION['USER_REF_NUM'] : NULL;
        $api_sent_logs = $main_app->sql_insert_data("LOG_EXTAPI_SENT", $api_log); // API Log

        //Send request to API
        $conn = new RemoteAPI;
        $response = $conn->connect( $this->api_server, 'post', $build_data, $max_timeout);
        $raw_resp = $response;

        try {

            if($response && $response != "") {

                $resp_data = json_decode($response, true);

                if(!isset($resp_data['CHANNEL_ID']) || $resp_data['CHANNEL_ID'] == "") {
                    if(isset($resp_data['responseCode']) && $resp_data['responseCode'] != "") {
                        return $resp_data;
                    }
                    throw new Exception('A03: Invalid response from API server');
                }
                elseif ($resp_data['CHANNEL_ID'] != $api_channel_id) {
                    throw new Exception('A04: Invalid API Channel');
                }
                elseif (!isset($resp_data['ENC_DATA']) || $resp_data['ENC_DATA'] == "") {
                    throw new Exception('A05: Invalid response from API server');
                }
                elseif (!isset($resp_data['ENC_KEY']) || $resp_data['ENC_KEY'] == "") {
                    throw new Exception('A06: Invalid response from API server');
                }
                else {

                    $resp_aes_key = $this->rsa_decrypt($resp_data['ENC_KEY']);

                    if($resp_aes_key == false) {
                        throw new Exception('A07: Invalid key from API server');
                    }
                    elseif (strlen($resp_aes_key) != "16") {
                        throw new Exception('A08: Invalid key length from API server');
                    }
                    else {

                        $decoded_data = $this->aes_decrypt($resp_data['ENC_DATA'], $resp_aes_key);
                        $response = ($decoded_data) ? json_decode($decoded_data, true) : false;

                        if($response == false || !is_array($response)) {
                            throw new Exception('A09: Invalid data from API server');
                        }

                    }

                }

            } else {
                throw new Exception('Unable to connect API server');
            }

        } catch(Exception $e) {
            $ErrorMsg = $e->getMessage(); //Error from section
        }

        //Log API Response
        if($api_sent_logs) {
            $jsonData = json_decode($raw_resp, true);
            $logData = array();
            $logData['RESP_RAW_DATA'] = ($jsonData && is_array($jsonData)) ? $raw_resp : substr($raw_resp,0,500);
            $logData['RESP_DATA'] = ($response == $raw_resp) ? NULL : (is_array($response) ? json_encode($response) : substr($response,0,500));
			$logData['MO_ON'] = date("Y-m-d H:i:s");
            $result = $main_app->sql_update_data("LOG_EXTAPI_SENT", $logData, array('REQ_NUM' => $ApiLogId));
		}

        // Throw Final Error
        if(isset($ErrorMsg) && $ErrorMsg != "") {
            throw new Exception($ErrorMsg);
        }

        return $response;

    }

}