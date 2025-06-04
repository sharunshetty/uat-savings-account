

/***********server*****************/


<?php

// /**
//  * @copyright   : (c) 2020 Copyright by LCode Technologies
//  * @author      : Shivananda Shenoy (Madhukar)
//  **/

// /** No Direct Access */
// defined('PRODUCT_NAME') OR exit();
// $html_op = $add_row= $add_row1 = $add_row2 ="";

// /** On Change */
// if($_POST['cmd2'] == "onChange" && isset($_POST['field_name']) && isset($_POST['field_val']) && isset($_POST['dest_id'])) {

//     if($_POST['field_name'] == "modify" && $_POST['field_val'] != "") {

//         $dest_id = (isset($_POST['dest_id']) && $_POST['dest_id'] != NULL) ? $_POST['dest_id'] : '' ;

//         //get pincode 
//         if(isset($dest_id) && $dest_id == 'PINCODE') {  

//             $PIN_CODE = isset($_POST['field_val']) ? $_POST['field_val'] : ""; 
           
//             $page_table_name = "SBREQ_PINCODE_DATA";

//             //get branch details
//             $sql_exe = $main_app->sql_run("SELECT DISTINCT STATE_CODE, DISTRICT_CODE, BRANCH_CODE FROM $page_table_name WHERE PIN_CODE = :PIN_CODE AND STATUS = '1'", array("PIN_CODE" => $PIN_CODE));
//             $row = $sql_exe->fetch();

// 	    $statecode = (isset($row['STATE_CODE']) && $row['STATE_CODE'] != "") ? $row['STATE_CODE'] : NULL;
//             $districtcode = (isset($row['DISTRICT_CODE']) && $row['DISTRICT_CODE'] != "") ? $row['DISTRICT_CODE'] : NULL;
//             $branchcode = (isset($row['BRANCH_CODE']) && $row['BRANCH_CODE'] != "") ? $row['BRANCH_CODE'] : NULL;
	
//             $sql_exe4 = $main_app->sql_run("select * from cbuat.mbrn WHERE MBRN_CODE='$branchcode'");

// 	    $row4 = $sql_exe4->fetch();

//             $add_row.='<option value = "'.$row4['MBRN_CODE'].'">'.$row4['MBRN_CODE']. '-' .$row4['MBRN_NAME'].'</option>';
//             $html_op .= "$('#BRANCH_CODE').html('".$add_row."');";
//             $html_op .="enable('BRANCH_CODE'); ";

//             //using db link query get state and city details
//             $sql_exe1 = $main_app->sql_run("select distinct  d.district_code as dcode, d.district_name as dname, s.state_code as scode, s.state_name as sname
//             from cbuat.mbrn br
//             Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//             Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//             Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//             where br.mbrn_entity_num=1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL
//             and br.mbrn_code = '".$row4['MBRN_CODE']."'");
//             $row1 = $sql_exe1->fetch();

//             $district_code = (isset($row1['DCODE']) && $row1['DCODE'] != "") ? $row1['DCODE'] : NULL;
//             $district_name = (isset($row1['DNAME']) && $row1['DNAME'] != "") ? $row1['DNAME'] : NULL;
//             $state_code = (isset($row1['SCODE']) && $row1['SCODE'] != "") ? $row1['SCODE'] : NULL;
//             $state_name = (isset($row1['SNAME']) && $row1['SNAME'] != "") ? $row1['SNAME'] : NULL;


//             $add_row1.='<option value="'.$district_code.'">'.$district_name.'</option>';
//             $html_op .= "$('#DISTRICT_CODE').html('".$add_row1."');";
//             $html_op .="enable('DISTRICT_CODE'); ";

//             //list all the states

//             $totalResults1 = $main_app->sql_fetchcolumn("SELECT count(0)
//                 from cbuat.mbrn br 
//                 Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//                 Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//                 Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//                 where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL");

//                 if($totalResults1 > 0){
	
//                    $sql_exe2 = $main_app->sql_run("select distinct s.state_code, s.state_name 
//                     from cbuat.mbrn br 
//                     Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//                     Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//                     Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//                     where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL", "");
//                     while($row2 = $sql_exe2->fetch()){
//                     $selected ='';
//                     if($state_code == $row2['STATE_CODE']){
//                         $selected ='selected';
//                     }
//                     $add_row2.='<option value ="'.$row2['STATE_CODE'].'"  '.$selected.'>'.$row2['STATE_NAME'].'</option>';
//                   }
                    
            
//                 $html_op .= "$('#STATE').html('".$add_row2."');";
//                 $html_op .="enable('STATE'); ";

//             }else{

//                 $add_row .='<option value="">-- Select --</option>';
//                 $add_row .='<option value="">-- No records found --</option>';
//                 $html_op .= "$('#STATE').html('".$add_row2."');";
//                 $html_op .="enable('STATE'); ";
//             }	      
		
//         }
//         //on changes of state
//         elseif(isset($dest_id) && $dest_id == 'STATE') {  

//             $STATE_CODE = isset($_POST['field_val']) ? $_POST['field_val'] : ""; 
//             //get district data

//            $totalResults1 = $main_app->sql_fetchcolumn("select count(0) from cbuat.mbrn br 
//            Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//            Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//            Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//            where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL
//            and l.locn_state_code = '$STATE_CODE'");

//            if($totalResults1 > 0){ 

//                 $sql_exe1 = $main_app->sql_run("select Distinct d.district_code, d.district_name, s.state_code, s.state_name 
//                 from cbuat.mbrn br 
//                 Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//                 Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//                 Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//                 where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL
//                 and l.locn_state_code = '$STATE_CODE'");
            
//                 $add_row1.='<option value="">-- Select --</option>';
//                 while($row1 = $sql_exe1->fetch()){
//                     $add_row1.='<option value = "'.$row1['DISTRICT_CODE'].'">'.$row1['DISTRICT_NAME'].'</option>';
//                 }

//                 $html_op .= "$('#DISTRICT_CODE').html('".$add_row1."');";
//                 $html_op .="enable('DISTRICT_CODE'); ";
            
//             }else{

//                 $add_row .='<option value="">-- Select --</option>';
//                 $add_row .='<option value="">-- No records found --</option>';
//                 $html_op .= "$('#DISTRICT_CODE').html('".$add_row1."');";
//                 $html_op .="enable('DISTRICT_CODE'); ";
//             }
    

//         }
//         //on changes of district
//         elseif(isset($dest_id) && $dest_id == 'DISTRICT') {  

//             $data = explode('|', $_POST['field_val']);
//             $STATE_CODE = isset( $data[0]) ? $data[0] : "";
//             $DISTRICT_CODE = isset( $data[1]) ? $data[1] : "";

//             //get branch data

//             $totalResults1 = $main_app->sql_fetchcolumn("select count(0) 
//             from cbuat.mbrn br 
//             Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//             Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//             Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//             where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL
//             and l.locn_state_code = '$STATE_CODE' and l.locn_district_code = '$DISTRICT_CODE'");

//             if($totalResults1 > 0){   
            

//                 $sql_exe2 = $main_app->sql_run("select distinct br.mbrn_code, br.mbrn_name, d.district_code, d.district_name, s.state_code, s.state_name 
//                     from cbuat.mbrn br 
//                     Join cbuat.location l on l.locn_code = br.mbrn_locn_code
//                     Join cbuat.district d on  d.district_code = l.locn_district_code and d.district_state_code = l.locn_state_code
//                     Join cbuat.state s on s.state_code = l.locn_state_code and s.state_cntry_code = l.locn_cntry_code
//                     where br.mbrn_entity_num = 1 and br.mbrn_admin_unit_type in ('04') and br.mbrn_closure_date is NULL
//                     and l.locn_state_code = '$STATE_CODE' and l.locn_district_code = '$DISTRICT_CODE'");
            
//                 $add_row2.='<option value ="">-- Select --</option>';
                
//                 while($row2 = $sql_exe2->fetch()){
//                     $add_row2.='<option value = "'.$row2['MBRN_CODE'].'">'.$row2['MBRN_CODE']. '-' .$row2['MBRN_NAME'].'</option>';
//                 }

//                 $html_op .= "$('#BRANCH_CODE').html('".$add_row2."');";
//                 $html_op .="enable('BRANCH_CODE'); ";

//             }else{

//                 $add_row .='<option value="">-- Select --</option>';
//                 $add_row .='<option value="">-- No records found --</option>';
//                 $html_op .= "$('#BRANCH_CODE').html('".$add_row2."');";
//                 $html_op .="enable('BRANCH_CODE'); ";

//             }

//         }
            
//         //Print
//         echo "<script> {$html_op} </script>";
  
//     }

// }
?> 



/***********localhost*****************/
<?php

/**
 * @copyright   : (c) 2020 Copyright by LCode Technologies
 * @author      : Shivananda Shenoy (Madhukar)
 **/

/** No Direct Access */
defined('PRODUCT_NAME') OR exit();
$html_op = $add_row= $add_row1 = $add_row2 ="";

/** On Change */
if($_POST['cmd2'] == "onChange" && isset($_POST['field_name']) && isset($_POST['field_val']) && isset($_POST['dest_id'])) {

    if($_POST['field_name'] == "modify" && $_POST['field_val'] != "") {

        $dest_id = (isset($_POST['dest_id']) && $_POST['dest_id'] != NULL) ? $_POST['dest_id'] : '' ;

        //get pincode mapping
        if(isset($dest_id) && $dest_id == 'PINCODE') {

            $page_table_name = "SBREQ_PINCODE_DATA";
            $page_table_name2 = "LOCATION";
            $page_table_name3 = "STATE";

            $PIN_CODE = isset($_POST['field_val']) ? $_POST['field_val'] : ""; 
            $html_op =  $html_op1= '';
            
            $totalResults1 = $main_app->sql_fetchcolumn("SELECT count(0) FROM $page_table_name WHERE PIN_CODE = :PIN_CODE AND STATUS = '1'", array("PIN_CODE" => $PIN_CODE));
        
            if($totalResults1 > 0){
               
                $sql_exe = $main_app->sql_run("SELECT DISTINCT BRANCH_CODE, BRANCH_NAME, DISTRICT_CODE, STATE_CODE
                FROM $page_table_name WHERE PIN_CODE = :PIN_CODE AND STATUS = '1'", array("PIN_CODE" => $PIN_CODE));
                $row = $sql_exe->fetch();

                $district_code = $row['DISTRICT_CODE'];
                $state_code = $row['STATE_CODE'];
                $branch_code = $row['BRANCH_CODE'];
                $branch_name = $row['BRANCH_NAME'];

                $sql_exe1 = $main_app->sql_run("SELECT DISTINCT MBRN_CODE, MBRN_NAME FROM MBRN WHERE MBRN_CODE < '997' AND MBRN_LOCN_CODE = '$district_code'");
               
                $add_row.='<option value="">-- Select --</option>';
                while($row1 = $sql_exe1->fetch()){
                    $selected='';
                    if($branch_code == $row1['MBRN_CODE']){
                        $selected='selected';
                    }
                    $add_row.='<option value="'.$row1['MBRN_CODE'].'"  '.$selected.'>'.$row1['MBRN_NAME'].'</option>';
                }
            
                $html_op .= "$('#BRANCH_CODE').html('".$add_row."');";
                $html_op .="enable('BRANCH_CODE'); ";
             

                //display district

                $sql_exe2 = $main_app->sql_run("SELECT DISTINCT LOCN_CODE, LOCN_NAME FROM LOCATION WHERE LOCN_STATE_CODE='$state_code'");
               
                $add_row1.='<option value="">-- Select --</option>';
                while($row2 = $sql_exe2->fetch()){
                    $selected='';
                    if($district_code == $row2['LOCN_CODE']){
                        $selected='selected';
                    }
                    $add_row1.='<option value="'.$row2['LOCN_CODE'].'"  '.$selected.'>'.$row2['LOCN_NAME'].'</option>';
                }
            
                $html_op .= "$('#DISTRICT_CODE').html('".$add_row1."');";
                $html_op .="enable('DISTRICT_CODE'); ";


                $sql_exe3 = $main_app->sql_run("SELECT DISTINCT STATE_CODE, STATE_NAME FROM STATE");
               
                $add_row2.='<option value="">-- Select --</option>';
                while($row3 = $sql_exe3->fetch()){
                    $selected='';
                    if($state_code == $row3['STATE_CODE']){
                        $selected='selected';
                    }
                    $add_row2.='<option value="'.$row3['STATE_CODE'].'"  '.$selected.'>'.$row3['STATE_NAME'].'</option>';
                }
            
                $html_op .= "$('#STATE').html('".$add_row2."');";
                $html_op .="enable('STATE'); ";

           
            } else{

                $sql_exe3 = $main_app->sql_run("SELECT DISTINCT STATE_CODE, STATE_NAME FROM STATE");
                $add_row2.='<option value="">-- Select --</option>';
                while($row3 = $sql_exe3->fetch()){
                    $add_row2.='<option value="'.$row3['STATE_CODE'].'" >'.$row3['STATE_NAME'].'</option>';
                }
            
                $html_op .= "$('#STATE').html('".$add_row2."');";
                $html_op .="enable('STATE'); ";

            }
        }//get district
        elseif(isset($dest_id) && $dest_id == 'STATE') {

            $totalResults1 = $main_app->sql_fetchcolumn("SELECT count(0) FROM LOCATION WHERE LOCN_STATE_CODE = '{$_POST['field_val']}'");
     
            if($totalResults1 > 0){
                $sql_exe = $main_app->sql_run("SELECT DISTINCT LOCN_CODE, LOCN_NAME FROM LOCATION WHERE LOCN_STATE_CODE = '{$_POST['field_val']}' ORDER BY LOCN_NAME");

                $add_row.='<option value="">-- Select --</option>';
                while($row = $sql_exe->fetch()){

                    if(isset($row['LOCN_CODE']) && $row['LOCN_CODE'] != NULL) {

                            $add_row.='<option value="'.$row['LOCN_CODE'].'">'.$row['LOCN_NAME'].'</option>';

                    }
                    else {
                        $add_row .= '<option value="">No records found</option>';
                    }
                }
            
                $html_op .= "$('#DISTRICT_CODE').html('".$add_row."');";
                $html_op .="enable('DISTRICT_CODE'); ";

            }else{

                $add_row .='<option value="">-- Select --</option>';
                $add_row .='<option value="">-- No records found --</option>';
                $html_op .= "$('#DISTRICT_CODE').html('".$add_row."');";
                $html_op .="enable('DISTRICT_CODE'); ";
            }

        } 
        elseif(isset($dest_id) && $dest_id == 'DISTRICT') {            

            //get branch
            $totalResults2 = $main_app->sql_fetchcolumn("SELECT count(0) FROM MBRN WHERE MBRN_LOCN_CODE = :MBRN_LOCN_CODE AND MBRN_CODE < '997'", array("MBRN_LOCN_CODE" => $_POST['field_val']));
     
            if($totalResults2 > 0){

                $sql_exe2 = $main_app->sql_run("SELECT DISTINCT MBRN_CODE, MBRN_NAME FROM MBRN WHERE MBRN_LOCN_CODE = '{$_POST['field_val']}' AND MBRN_CODE < '997' ORDER BY MBRN_CODE");
                $add_row.='<option value="">-- Select --</option>';

                while($row2 = $sql_exe2->fetch()) {

                    if(isset($row2['MBRN_CODE']) && $row2['MBRN_CODE'] != NULL) {

                        //Update Value
                        $add_row .= '<option value="'. $row2['MBRN_CODE'] . '">'. $row2['MBRN_CODE'] . '-'.$row2['MBRN_NAME']. '</option>';  
                    } 
                    else {
                        $add_row .= '<option value="">No records found</option>';

                    }
                    $html_op .= "$('#BRANCH_CODE').html('".$add_row."');";
                    $html_op .="enable('BRANCH_CODE'); ";

                }
            }else{

                $add_row .='<option value="">-- Select --</option>';
                $add_row .='<option value="">-- No records found --</option>';
                $html_op .= "$('#BRANCH_CODE').html('".$add_row."');";
                $html_op .="enable('BRANCH_CODE'); ";
            }
        }

        //Print
        echo "<script> {$html_op} </script>";
  
    }

}

?>

?>