<?php

/**
 * @copyright   : (c) 2021 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 * @package     : KBL API Gateway Encryption & Decryption
 * @version     : 1.0.0
 **/

/** Inc: PHPXMLSECLIBS Class */
require_once(dirname(__FILE__) . '/xmlseclibs/XMLSecurityKey.php');
require_once(dirname(__FILE__) . '/xmlseclibs/XMLSecurityDSig.php');
require_once(dirname(__FILE__) . '/xmlseclibs/XMLSecEnc.php');
require_once(dirname(__FILE__) . '/xmlseclibs/Utils/XPath.php');

use RobRichards\XMLSecLibs\XMLSecurityKey;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecEnc;

/*
Username   : shivananda    
Password : Lcode@321#$
Client-Id : 172023bea3fce046260329a0bd6cf2b1
Client-Secret : a5306d4be44bd14bc3f9d5a06def62e2
Org-name : lcodeorg
Application Name : lcodetech
*/

/** Encryption */
function XmlEncrypt($XmlString, $CertPath = false) {
    try {

        if(!$CertPath) { $CertPath =  API_GATEWAY_PUBLIC; }
        $doc = new DOMDocument();
        $doc->loadXML($XmlString);
        $objKey = new XMLSecurityKey(XMLSecurityKey::AES256_GCM);
        $objKey->generateSessionKey();
        $objDSig = new XMLSecurityDSig();
        $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        $objDSig->addReference(
            $doc, 
            XMLSecurityDSig::SHA1, 
            array('http://www.w3.org/2000/09/xmldsig#enveloped-signature')
        );
        $siteKey = new XMLSecurityKey(XMLSecurityKey::RSA_OAEP_MGF1P, array('type'=>'public'));
        $siteKey->loadKey($CertPath, TRUE, TRUE);
        $siteKey->name = "kblwildcardcert";
        $enc = new XMLSecEnc();
        $enc->setNode($doc->documentElement);
        $enc->encryptKey($siteKey, $objKey);        
        $enc->type = XMLSecEnc::Element;
        $encNode = $enc->encryptNode($objKey);
        return $doc->saveXML();

    } catch (Exception $e) {
        return false;
    }

}


/** Decryption */
function XmlDecrypt($XmlString, $PriKeyPath = false) {
    try {

        $output = NULL;
        if(!$PriKeyPath) { $PriKeyPath = API_GATEWAY_PRI_KEY; }

        $doc = new DOMDocument();
        $doc->loadXML($XmlString);

        $objenc = new XMLSecEnc();
        $encData = $objenc->locateEncryptedData($doc);
        if(!$encData) { throw new Exception("Cannot locate Encrypted Data"); }

        $objenc->setNode($encData);
        $objenc->type = $encData->getAttribute("Type");
        if(!$objKey = $objenc->locateKey()) { throw new Exception("We know the secret key, but not the algorithm"); }

        $key = NULL;
        if($objKeyInfo = $objenc->locateKeyInfo($objKey)) {
            if ($objKeyInfo->isEncrypted) {
                $objencKey = $objKeyInfo->encryptedCtx;
                //locateLocalKey($objKeyInfo);
                $filename = $objKeyInfo->name;
                $objKeyInfo->loadKey($PriKeyPath, TRUE);
                $key = $objencKey->decryptKey($objKeyInfo);
            }
        }
        
        if(!$objKey->key && empty($key)) {
            //locateLocalKey($objKey);
            $filename = $objKey->name;
            $objKey->loadKey($PriKeyPath, TRUE);
        }

        if(empty($objKey->key)) {
            $objKey->loadKey($key);
        }
        
        $token = NULL;
    
        if($decrypt = $objenc->decryptNode($objKey, TRUE)) {
            $output = NULL;
            if ($decrypt instanceof DOMNode) {
                if ($decrypt instanceof DOMDocument) {	
                    $output = $decrypt->saveXML();
                } else {
                    $output = $decrypt->ownerDocument->saveXML();
                }
            } else {
                $output = $decrypt;
            }
        }

        return $output;

    } catch (Exception $e) {
        return false;
    }

}