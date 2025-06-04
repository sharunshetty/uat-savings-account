<?php

/**
 * @copyright   : (c) 2020 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();
$html_op='';
$add_row='';

/** On Change */
if($_POST['cmd2'] == "onChange" && isset($_POST['field_name']) && isset($_POST['field_val']) && isset($_POST['dest_id'])) {
  
    if($_POST['field_name'] == "modify" && $_POST['field_val'] != "") {
  
        $sql_exe = $main_app->sql_run("SELECT TIMESLOT_CODE, TIMESLOT_DESC FROM VKYC_MAST_TIMESLOTS WHERE TIMESLOT_STATUS='1' ORDER BY TIMESLOT_CODE ASC");  
        
        $curdate = date('d-m-Y');  
        if($curdate==$_POST['field_val']){
        
            $curtime = date('H:i A');    
            $add_row.='<option value="">-- Select --</option>';
            while ($row = $sql_exe->fetch()) {
             
              $slottime = (isset($row['TIMESLOT_DESC']) && $row['TIMESLOT_DESC'] != "") ? $row['TIMESLOT_DESC'] : "";
              //$slotdate = date('h:i A',strtotime($row['TIMESLOT_DESC']));
              if($slottime >= $curtime){
                $add_row.="<option value=".$row['TIMESLOT_CODE'].">".$row['TIMESLOT_DESC']."</option>";
              } 
            }
            $html_op .= "$('#TIMESLOT_CODE').html('".$add_row."');";
            $html_op .="enable('TIMESLOT_CODE'); ";

        }else{
            $add_row.='<option value="">-- Select --</option>';
            while ($row = $sql_exe->fetch()) {
                $add_row.="<option value=".$row['TIMESLOT_CODE'].">".$row['TIMESLOT_DESC']."</option>";
            }
            $html_op .= "$('#TIMESLOT_CODE').html('".$add_row."');";
            $html_op .="enable('TIMESLOT_CODE'); ";


        }

        if($html_op == "") {

            $html_op .= '<option value="">No records found</option>';
         
        }

          //Print
        echo "<script> {$html_op} </script>";
  
    }
}


?>