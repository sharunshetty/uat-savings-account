<?php

/**
 * @copyright   : (c) 2022 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();

if(isset($_POST['ekycNum']) && $_POST['ekycNum'] != "") {
    $ekycInfo = $safe->str_decrypt($_POST['ekycNum'], $_SESSION['SAFE_KEY']);
}

if(isset($_POST['reqid']) && $_POST['reqid'] != "") {
    $requestID = $safe->str_decrypt($_POST['reqid'], $_SESSION['SAFE_KEY']);
}

if(isset($_POST['arnVal']) && $_POST['arnVal'] != "") {
    $plain_arn_val = $safe->str_decrypt($_POST['arnVal'], $_SESSION['SAFE_KEY']);
}

if(isset($_POST['ekycOtp']) && $_POST['ekycOtp'] != "") {
    $safe = new Encryption();
    $plain_ekyc_otp = $safe->rsa_decrypt($_POST['ekycOtp']);
}

if(isset($_POST['reqid']) && $_POST['reqid'] != "") {
    $requestID = $safe->str_decrypt($_POST['reqid'], $_SESSION['SAFE_KEY']);
}

if(!isset($_POST['ekycOtp']) || isset($_POST['ekycOtp']) == NULL || isset($_POST['ekycOtp']) == "") {
    echo "<script> swal.fire('','Enter valid OTP Code'); loader_stop(); enable('sbt2'); </script>";
}
elseif(!isset($ekycInfo) || $ekycInfo == false) {
    echo "<script> swal.fire('','Unable to process your request (E01)'); loader_stop(); enable('sbt2'); </script>";
}
elseif(!isset($plain_arn_val) || $plain_arn_val == false) {
    echo "<script> swal.fire('','Unable to process your request (E02)'); loader_stop(); enable('sbt2'); </script>";
}
elseif(!isset($requestID) || $requestID == false) {
    echo "<script> swal.fire('','Unable to process your request (E03)'); loader_stop(); enable('sbt2'); </script>";
}
elseif(!isset($_SESSION['USER_REF_NUM']) || $_SESSION['USER_REF_NUM'] == NULL || $_SESSION['USER_REF_NUM'] == "") {
    echo "<script> swal.fire('','Unable to validate your request (E04)'); loader_stop(); enable('sbt2'); </script>";
}
elseif($plain_arn_val != $_SESSION['USER_REF_NUM']) {
    echo "<script> swal.fire('','Unable to process your request (E05)'); loader_stop(); enable('sbt2'); </script>";
}
else {

    $updated_flag = true;

    $sql1_exe = $main_app->sql_run("SELECT SBREQ_APP_NUM, SBREQ_MOBILE_NUM FROM SBREQ_MASTER WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM", array( 'SBREQ_APP_NUM' => $_SESSION['USER_REF_NUM'] ));
    $item_data = $sql1_exe->fetch();

    if(!isset($item_data['SBREQ_APP_NUM']) || $item_data['SBREQ_APP_NUM'] == NULL || $item_data['SBREQ_APP_NUM'] == "") {
        echo "<script> swal.fire('','Unable to validate your request (R01)'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

        //Aadhaar Verify OTP Code
        $send_data = array();
        $send_data['METHOD_NAME'] = "getAadhaarInfo";
        $send_data['OTP'] = $plain_ekyc_otp;
        $send_data['AADHAAR_NUMBER'] = $ekycInfo;
        $send_data['REQ_ID'] = $requestID;
        $send_data['CHANNEL_CODE'] = API_REACH_MB_CHANNEL;
        $send_data['USER_AGENT'] = $browser->getBrowser();
    
        try {
            $apiConn = new ReachMobApi;
            //$output = $apiConn->ReachMobConnect($send_data, "120");
            $output = json_decode('{"fatherName":"Hari Kishan","country":"India","pincode":"313329","image":"\/9j\/4AAQSkZJRgABAgAAAQABAAD\/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL\/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL\/wAARCADIAKADASIAAhEBAxEB\/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL\/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6\/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL\/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6\/9oADAMBAAIRAxEAPwCovijUQOkX\/fNTR+Lr9ePLhJ+h\/wAawSp7U4D65rldSSNvZR7HRDxlejGbeD8M1MPGtyPvWkTf8CNcxsOadj1FHtZIPZQ7HUr44nUc2Mf\/AH2f8KePHUn\/AED0zj\/nr\/8AWrkyPyoVcnil7WVg9jDsdb\/wnLf9A5c\/9df\/AK1H\/CdP1\/s8f9\/v\/rVygU80uwcZxR7eQ\/YxOtXxyeh0\/wDKb\/61bmg6rLrglMUHlCMgEs+f6V5wqqTxkV6H8PYFFlcyDqzgflV06jk7MipTjFXR0Itbgj+H\/vo0q2d103DH1rTApQK2uc9jO+yXPZ8\/jR5N0P8AIrTA4oxQBl+Xcn1pdt2BwlaW32pQPagLGWWuQOYyfoKQyz55ib8q1sDFG324oFqZPnyd4z+VBuGHJTH4VrbBRsHpTA+fPxpyigJ2qdYSAM4rlsd1yP2FGOM96srDleAc96XyiBzgfWlYLlcKdvWlVRjHIpxRh9KdHGW5\/WpY7iEccYxSA45IqRhtUnkn0qMOR1+X1qbFICBjIPBr0f4fgf2XMcYO+vMHvohJsb069q6\/w3400rRtNkimdjLuzgDg\/iK2pRd7mNVpqx6gKgur6KyCvN8sZOC3pXmt18WvLLeTZJtHQliaoX\/xIh1TSp7e4g2iWIgFT91+1dBz2PYgR270bhwAa808G+Njc6aLS\/OJbdMq+c71FdFH4hhN2xVlK43LzgHNFhHVYoFUYNVguQDGSePmH92r6MHGVPHrSAXFFLRTEN70d6djmk60AeEpCCAAOavQ2WU6D6GljTaBxz7Ctqyty6BvLyM+lRGF0dLkZ0Onk8Yx71I1gACMDH0rblE0ZJWyRkXnJwKrLqIJCizjJY4CB8mjQV5PYyPsHcKSMelIbLYvTbxWxcanBaRmSa0CL0yH\/SuN8Q6zLfy+XYloYVHO1iCaHBMSmx13e2tqcNIrvngIwJrEu9Vkb7qxiM9t+DWNdBEcBpiR\/EB3\/Gqlxd\/JhI1VenGOaqNOK1E5t6E15d3GBhCsfYg5\/Ws6S5ZchmOfr1pyznG3J2txxVa6RCnow9OhrQkd9vOODz\/Orcd8WgBcc9qxFAyNx4HariSZIHA9BQwOgsdRubIpMrn5BkAnt\/k1ftNbldHEhPTjnsa5mWQtDtB4xii2mZUO04ziiwHoWl+K7mwi8l5X8pskhTgk\/Wuw0j4lWtrZBLiFyynkqc\/zrxxpj9hy2SQcCrccw8qMAkluWBqXYLHti\/FbRCOko\/Af41KnxS0In70v5D\/GvBpuJiAMD0oXd3BFbqimr3IPf1+JehOf9a4J9h\/jUq\/EPQW\/5eCPqK8f8Bwxz+MLCOdFeIs25XGQflJr3RtK0Q\/8w2yP\/bFf8KTo26kOSR51EoI+UjPvXQaRkWxRzyTzxXE21\/eQjJgDDt83Stiz8QTWoP8AoTOCeoasYzidMos3dY1CeymjSCESq0bMwxnpiuWvNXSNzMBGHCDLICMN1x9K1ZfE7SgrJYSD0OQa4XWtWR7xvPiIRjhtpwKiwouUShqGtyyZKjg9O9Zxv7gRGSNfMJ696jvpY5C3k42jpgdayPMZWLA8j3q7iLMt+0uVmjXd64waq7gjHP3X70rS+YNxG5T19qhDeW5TqjdPamIeG8ttrNwelDyDBRj19agZznYx47Edqby2UbOR0NMCFshzxzUseQOep\/SlWBpT8q5NaFvo9xMVIGDjvSbGkUzLlsZ4FLHudsKSPc1tDw1cAZ4Oe4qrPpFxDlircdaLoHFjJJciONTkL1zV+AEEN1wOKzET96GOSOhrZZvLjAAGDVxhdibsbXg63S68V6ekyq6tNyjDII969fudL0cX72r2EHA3bxbxnGBn+7XlPw9HmeNtOH+0x\/8AHTXsktuJ\/EbKwPlspBx6ba2qaWsY31GaToukMY9QsrWAMhIVxbqjA9DyPxra+zwPGwaBDkf3RSW9nBp1vHbW+QrMcAnJ6E1aCNsx3xSRLd2eJ28qog3dulXoZshSFriW8Sk8QwcerNUTa9eSkASbMDtXDGnI7XOJ6F5kflKCq7veuR8T2AeJ5YgBg5IFQxXEkm3dIxyO5rKudRnWd4jKdhPQ81qqcu5m6i2MKSMxllJwetVgvmsEBy30q9eyGRfl\/PFM0uHNz70bAtRv2Ro1AAOaT7EWU5GSe\/rXQywgcgAVAsWTgcio5jXlRhjTnYcg5NXLfRy7ANmtuC246VejhCUucOUq2ekwwL9wE+prQhjjVwpAA+lOUcVKsOeQKnmuVaxeiREAwQVpl1bxTQMAvPrimwkp1ORU7tlRzmmB59cWxt5zERyWrt9C+HWo+I9Kjv7W7tEjJK4kZsgjjsDXMa9CTfA4616p8Ib2YaZe2bgmNW81MdjgAj9B+tdVJ9TlqaGPD8I9et5A8OoWaupyGR3BB\/75rc0zwBr0Vwf7U8QTrDt+U21w+4H8e3Wu7iY+eDmXr0I4q7cD5PwNbczMW7nMaX4VOnagl2ut3ty6AgJctvUZ9q6NTMxwLiMn\/rmf8arwj5uOtS24+cketDd9xHyQ0jqAQcUwXUiHO\/mmysdoAqDkc9q50bmimr3aAFZcfUCoHupJ5cucsTyaqE47fjT42IbNO4WJ5D8hPOauaEvmXbDA45q60kbWjWAtos7QRIFG7dj19Ki8NRsmoyhhzs\/rWMndM1UHG1zce3LYwBiohAiPyeKg1S7uf9XCAqDqc1gy3M4Hz3WPYVmlc05rHYoY9vy44qwuD9a4eDVLiJsCbI9xW9Z6kZcbuvfFJwaKUkzayARU8d1DEPnx+dZc8j+TvXOMcmuavZ3mkPyyNtGepwKIxuEpWO8GtWCNtd0A+tTxXdpdBhFIM9s15vagzybIrdnYDO0E1v6T5TSrujdD9eK05bIzUm9hfEgeK4iP97Ndd8N9Tu7Zbr7OEIZhkHqR7Vz3ia2LWltLjIVtp\/EVe8IyTWPjDSYoWPlO6qRjgg8GrpzSSJnBybPWX1vUVyfIyCPlx2+ta+nXUl3phllUhtxGDWgRAAxITjrkViap4q0LSrYNNexFWbbiAhzn6CulanGX4h8x5qW3PJ5\/CuYtfHnhyeZY4Lqd5G4CLAxJ\/IVpReJNNBxi9BPrZyf\/ABNVysR8qSn5gO1RMQOlST8EEfnUROVrnOkQcqd2adGwyM\/pUanuelKmM4BpDN2KVRIZvVAc+\/StTQcyy3ExUA7QAQOtZel2r31uUjALocMCf4T3rd0iM20j2rHOFxu9a55KzZ0p3iipfWj3DMBkCs46egt2idAXzkP3FdYQoOOKZJFG3O0GoU2gcLnHmx8q3KDlicliOlXtOtiJkBHHfFa88KbOnHpSWSAvuCgVUp3CMUjZWyEthnHfkVh3uky287SRocPwcHiussIybQ5PHarLeRPaGKRRuHfvSi2OSTON0rT\/ALKXMcYUuME55x6V0dtpykAmMH3AquYTbyfuzla2rOYhVytU5MnlMrXbf\/iVuCPu4Ip\/gGA3nibTpXQExK78+gHFTav+9h2dmPP0rovh9pqRX890Mn92EAI6Anp+lVT1kkKbtFs7m9fbp18TwPKc\/oa+aHkPnE44Bzg19KamwXR9QOOkMn\/oJr5pf75xnrXowOBHV\/Dk+Z44sTjAzIcdvuNXuiSNvPTgV4v8LIBN4s34\/wBTbu49ui\/+zV7Mg++T6Up7iZ8g3Bx9fSoFb1NSyj5selQHg1y3OgXNOQ80xufpTo+p70DNnRtQSwuj5mfLddpI7Vux6laC7h2SoWkbHBz1\/lXGnBUDPJFIrmN1dScoc1MoKWpSm1oeitkMc0uRioBOs8EUyjIdQRSGXHWuVqx0Jkd2xYhB0q1C8UIA46etUXZcMzn6VQKSGcyRhsHpk1VrhfU7ex1C3iiIckfyouJ4LhEltX3NnkZ7Vy1qN0myVWfI9eK2rJo7YbfL2J7UWsHMXFk80cgDFW4HKrgYqrlCdyHINSoQOM9elD7Bc3dL8PNrgklFyYDCQAdm4NnqP0rtNE0mLSYREjl2Y\/M5GM1S8IwGPQDIRzJISD7DA\/xrdh6jPrXZSgkkziqzbbXQrarxoepkH\/l3l\/8AQTXzU5G8819Ka023w7qrD\/n2l\/8AQTXzSxG4mumBnE9E+Ea58Q3cgGQLNl+nzr\/ga9fVTtY+1fMNrfXFnJ5lrcSQP03RuVOPwrUj8U66gGzVr0f9tm\/xpuF2Jps4W4OJWGe+KgOQc9qsXf8Ax8yDuGNQsSQPbvXEtjoe43PGKcnBpoOfelXHPrTAe\/zflTF78U5iAfwpFxTQjsdDd5NGTd0Viqn2q22ACai0hVi0CPcQCxLAetRyybuK5L8zbOhaJFK6vJhJiGMsPWooxfS4YRlvxqfzCARiogZ1fMQOfSqT0sPqXYPt\/mCNoguO5arz2mpRDKTxAsPu5yKoQLqk0gIix7kitOCO6jP74Z\/GquD1JdOkuof3dwQx9a2rVGnuY4o+XkYKo96ykBBLNxWz4evYLLV7e6ui3kxkk7Rk9PSlFXYpPlR7Jp9ilrptva\/881AOO57mrAt0Q5Ga5dvH+kIwCpdsuM7hDT1+IGikcrdj6wGu26OFpvU0fEaCPwzqpHe2k6\/7pr5mJ9K928QeM9Jv\/D99aW5uTNNAyIphYZJHrXiLWF2Mk28g\/wCA1pGSS3GkyuAO3WpBxxUv2S4x\/qXH\/Aad9mnH\/LF8\/Sq50PlMW60u4kuZGjQlSSRzVf8Asi8zgRfmRXWFlCoM8t2qLfkMEG4k4Arx1XktLHa6UTlv7Huxn9309xUyaNc+U7lMMMYXua6eCOVlYSWzEn+6atiBgARFIMf3q09pNdCOSPc5Oy8N6heSlRGEQDLOx4Aq7Lo8FiyRQKbm4bgZ5P4Cuul\/0XTxsblzggd6w7hI9Ntpnj3Lcyqd0h5Kr6CkqkpENJMyIdlpqccVxMXuD8uxTwnHc9\/wq1OWQk9qw9LRrnVhKORGSxJ71vSjJPcZqmkiokEd0g+WTr61YS5CNkYIHpVOWFW7fnVV42ThXYUWTKu0dBHqShs5xirg1OPblmGa5OKKRmH7w1uWVnECCRuPq1FkK7NFJ5LlxgYj+nWn6jKsGmys6b0VckZxxmpYlCjgUy9hFxZTQk\/fQihMbWmpDonie70NxdxbNT0w4823uACyD2bqK9m8M6r4U8WW2\/T4oBMBmS3kQCRPw7j3GRXzno5kjn8pSODtdT0Iqci40DWUms5pIWB8yF0YgqfSrsr2MGfUR8O6Ux5sYf8AvmmHwvo7dbGH\/vmuL8FfFKHUxFY64yQ3ZAC3HRJD6Efwn9Pp0r0oMCMjvRYnUxj4U0XobCKmN4Q0UnP2JB9Ca3TikyMUBdnytGDNKiD8T6VqQWyRAbQOPerGleHbsbnnRV3DAG7mtUWFtacuxcj0rlUlFHW5GfHHJjcFAUdSelWUmi2EFuf0qnchLyXy8FecdTWhaWcMcTBEARR8x9fxqnNozbKd3KhkRVA2JyPrXO69OW01yr9ypzW5PKDO6+WADnYwrl9dZxGtsq5GRk+pogiRPDdsBbSyYGTgdKtSja5\/rV\/Q7FotLXKnLc9KgvYHUlgOtaS3NYrQoOhJ4qMxFjyKsx+45zxUvlEdM0loMrQ2xDDg1rwAooxVSMsHwcc1oRAsRzSuOxOjHHWnudsRJPahE56c0kw+XBp3FY5K0Jj8RMgPDsR+Nbmq2i3VspUfPGevescRf8TmSVQcK3FdNE4AxtAJ64ptu9zFo5Zg8BU9M16v8P8A4gG1iTTtTkLWoGIpiCTH7H1H8vp0891SFWQlV75GO1JpEZ37i20eh6GqUiGj6ZtdStL2PfbXMUy+qMDU++vn1Lm5tn3W8xGOQUJBroNH8eanYtsuHNwnX97zj8etJSFymU96y7tjt69aqF5mDEtw3Uk800ED7+B71Uu7lhKqIcIB+dYJ9DSxBc3FxaPJcwxeYqDc6k9R7VLZeIzqkLssRgRcAB36mofPaWOVeOmMmm2AgjtkgEagfxHHU1a2Ey47ibIcbXPKkf41TMQbUIDOFdCGx7kVeZVYFCRs6cf0qndhkEEmcmKTBPseKExnWRPZiNRGABiq1zBazZ4GTWRaysXdcng8fSrgL49aTbOhWaKFzpao+6LkGmpZgjAzWkSenJFN245Hep5hqJmtbGM9asW6HaC1SMpZuakjUA0XuFh2w4yBUFwuELMcbRV7KhCc1k3shnuEgUgjO5\/pVJ9yW7GdLbCOVCB80nJ+tX0ARME89TUd4cpuU\/MCNtVYneVGBbGF6D1qkrmDZYnYOdo4yOc\/pUljF5arkcjrVYRs0DAH94o6nnFZFxNdCVA8rYJ6A4H5U0rks6ieZUcgYAC8VFCzKAznIb1rOmn\/ANWmeQvJx1q1NKPLh2kEEc4NK1hlK\/1F\/tBUcIOn1p3nFwjMeo60UU+VWQ2SR5EiK44JycDj2FFySmBESuOuBRRQ0hFvT51vFEaNukT7wPf3q5cWR2EPzkYYe1FFY1G07IZWsgQ+1uSPlP1FaG\/C0UU3sbU9hPN4phJPeiipRsNLYNKrGiirasJkjyKkRYngDJ+lZdu29ZJjwzn8hRRS6GVTYZcrmIx\/kfSs+wmC3DJIQCuetFFaR1RgaQ2zktGxxjBHTNZc0G6\/hUgEZ6UUUk7AaV0gEsY2jgVDfeWscZU44xgUUUR1Gf\/Z","gender":"M","houseNumber":"null","responseCode":"S","dob":"1999-07-18","street":"null","subdistrict":"Railmagra","district":"Rajsamand","name":"Naveen Kumar Yadav","vtcName":"Railmagra","state":"Rajasthan","maskedAadhaarNumber":"XXXX XXXX 1174","combinedAddress":"Railmagra, Rajsamand, Railmagra, Railmagra, Rajasthan, India, 313329","postOffice":"Railmagra uuuuu fyuftfttfrtf hugyyuyu"}', true);
               
        } catch(Exception $e) {
            error_log($e->getMessage());
            $ErrorMsg = "Please click again!!"; //Error from Class    
        }
    
        if(!isset($ErrorMsg) || $ErrorMsg == "") {
            if(!isset($output['responseCode']) || $output['responseCode'] != "S") {
                $ErrorMsg = isset($output['errorMessage']) ? "Error: ".$output['errorMessage'] : "Unexpected API Error";
            }
        }
    
        if(isset($ErrorMsg) && $ErrorMsg != "") {
            echo "<script> swal.fire('','{$ErrorMsg}'); loader_stop(); enable('sbt2'); </script>";
            exit();
        }

       // if((isset($output['fatherName']) && $output['fatherName'] == "") || (isset($output['husbandName']) && $output['husbandName'] == "")) {
       //    echo "<script> swal.fire('','Father or Spouse is missing in online validation of UID, Cannot proceed. Please update your UID and try again'); loader_stop(); enable('sbt2'); </script>";
       //    exit();
       // }

    if(isset($output['dob']) && $output['dob'] != "") {
        $dob = $output['dob'];
        $diff = (date('Y') - date('Y',strtotime($dob)));
        if($diff < "18") {
            echo "<script> swal.fire('','Minors are not allowed to open Online account, Please visit branch'); loader_stop(); disable('sbt2'); </script>";
        }
    }

  /*if(isset($output['pincode']) && $output['pincode'] != ""){
        $totalResults = $main_app->sql_fetchcolumn("SELECT count(0) FROM SBREQ_PINCODE_DATA WHERE PIN_CODE = :PIN_CODE AND STATUS = '1'", array("PIN_CODE" => $output['pincode']));
        if($totalResults == 0){
          echo "<script> swal.fire('','Branch doesnt exist for your location'); loader_stop(); enable('sbt2'); </script>";
          exit();
        }    
   }*/

    
    //Max. Sl.
    $doc_sl = $main_app->sql_fetchcolumn("SELECT NVL(MAX(DOC_SL), 0) + 1 FROM SBREQ_EKYC_DOCS WHERE SBREQ_APP_NUM = :SBREQ_APP_NUM AND DOC_CODE = 'AADHAAR'", array("SBREQ_APP_NUM" => $item_data['SBREQ_APP_NUM'])); // Seq. No.
    
    if($doc_sl == false || $doc_sl == NULL || $doc_sl == "" || $doc_sl == "0") {
        echo "<script> swal.fire('','Unable to generate detail serial'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }
    
    // Save eKYC Record
    $data = array();
    $data['SBREQ_APP_NUM'] = $item_data['SBREQ_APP_NUM'];
    $data['DOC_CODE'] = 'AADHAAR';
    $data['DOC_SL'] = $doc_sl;
    $data['DOC_DATA'] = json_encode($output, true);
    $data['CR_BY'] = isset($_SESSION['OTP_REQ_ID']) ? $_SESSION['OTP_REQ_ID'] : NULL;
    $data['CR_ON'] = date("Y-m-d H:i:s");

    $db_output = $main_app->sql_insert_data("SBREQ_EKYC_DOCS", $data); // Insert
    if($db_output == false) { $updated_flag = false; }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update e-KYC record (E01)'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    // Update main table-store ekyc data
    if($updated_flag == true) {
        $data2 = array();
        $data2['SBREQ_EKYC_FLAG'] = "Y";
        $data2['SBREQ_EKYC_UID'] = $safe->str_encrypt($ekycInfo, $item_data['SBREQ_APP_NUM']);;
        $data2['SBREQ_EKYC_NAME'] = isset($output['name']) ? $output['name'] : NULL;
        $db_output2 = $main_app->sql_update_data("SBREQ_MASTER", $data2, array( 'SBREQ_APP_NUM' => $item_data['SBREQ_APP_NUM'] )); // Update
        if($db_output2 == false) { $updated_flag = false; }
    }

    if($updated_flag == false) {
        echo "<script> swal.fire('','Unable to update e-KYC record (E02)'); loader_stop(); enable('sbt2'); </script>";
        exit();
    }

    // Success
    $main_app->session_remove(['APP_TOKEN']); // Remove CSRF Token
    echo "<script> goto_url('form-aadhaar-view'); </script>"; // Done

}
