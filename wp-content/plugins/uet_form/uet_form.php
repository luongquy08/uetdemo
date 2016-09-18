<?php
/**
 * Created by SublineText.
 * User: Vuongdz
 * Date: 8/12/2016
 * Time: 12:05 AM
 * Plugin Name: UET Form
wp_re
 * Author URI:
 * Description: Đây là Plugin form dành riêng cho Đại học Công nghệ
 * Tags: UET
 * Version: 1.4
 */
global $uet_db_version;
$uet_db_version = '1.0';
add_action('plugins_loaded', 'create_formtable');
add_action('plugins_loaded', 'create_fieldtable');
add_action('plugins_loaded', 'form_uet');
 wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
 // wp_register_script('prefix_bootstrap', 'wp-content/plugins/uet_survey/bootstrap/js/bootstrap.min.js');
 wp_enqueue_script('prefix_bootstrap');
 wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
 // wp_register_style('prefix_bootstrap', 'wp-content/plugins/uet_survey/bootstrap/css/bootstrap.min.css');
 wp_enqueue_style('prefix_bootstrap');
 // wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
 // wp_enqueue_script('prefix_jquery');
function create_fieldtable()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'field';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  formid INT(8) NOT NULL,
                  content text NOT NULL,
                  status INT(8) DEFAULT 1,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function create_formtable()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'form';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                 id INT(8) NOT NULL AUTO_INCREMENT,
                  formName text NOT NULL,
                  startTime DATE,
                  endTime DATE,
                  status INT(8) NOT NULL DEFAULT 1,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function create_form_submit_table()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'form_submit';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  form_id INT(8) NOT NULL,
                  status INT(8) NOT NULL DEFAULT 0,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function create_form_submit_field_table()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'form_submit_field';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  field_id INT(8) NOT NULL,
                  form_submit_id INT(8) NOT NULL DEFAULT 0,
                  content TEXT NOT NULL, 
                  date_create DATE, 
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function form_uet(){
    add_options_page( 'UET Form', 'UET Form', 'manage_options', 'my-unique-identifiertwo', 'uet_form' );
}
function getfield($id){
    global $wpdb;
    $answers =  $wpdb->get_results("SELECT * FROM wp_field WHERE formid = '$id' ", OBJECT);
    return $answers;
}
function displayformStatus($status){
    if($status == 0) echo "Kích hoạt";
    else echo "Không kích hoạt";
}
function uet_form()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    global $wpdb;
      //code php for set active or deactive each element and get all result 
    if (isset($_POST['form_click1'])) {
        $id = $_POST['qtid'];
        $question =  $wpdb->get_results("SELECT * FROM wp_form WHERE id = '$id' ", OBJECT);
        if($question[0]-> status == 0)
            $wpdb->query($wpdb->prepare("UPDATE wp_form SET status = 1 WHERE id = %d", $_POST['qtid']));
        else 
            $wpdb->query($wpdb->prepare("UPDATE wp_form SET status = 0 WHERE id = %d", $_POST['qtid']));
    }
    $questions = $wpdb->get_results('SELECT * FROM wp_form', OBJECT);
    if (isset($_POST['form_click2'])) {
        $id = $_POST['qtid'];
        $answer =  $wpdb->get_results("SELECT * FROM wp_field WHERE id = '$id' ", OBJECT);
        if($answer[0]-> status == 0)
            $wpdb->query($wpdb->prepare("UPDATE wp_field SET status = 1 WHERE id = %d", $_POST['qtid']));
        else 
            $wpdb->query($wpdb->prepare("UPDATE wp_field SET status = 0 WHERE id = %d", $_POST['qtid']));
    }    
     //code php for set active or deactive each element
 
?> 
    <!--code php for change many state of question -->
    <?php
    if (isset($_POST['ChangeDate'])){
      if(!empty($_POST['check_list']))
        {   
            foreach($_POST['check_list'] as $id){
                $wpdb->query($wpdb->prepare("UPDATE wp_form SET startTime = %s , endTime = %s WHERE id = %d", $_POST['ChangestartTime'],$_POST['ChangeendTime'],$id));
             }
             echo '<script type="text/javascript">'; 
             echo 'window.location.reload(true)';
             echo '</script>';
        }
    }
     if (isset($_POST['ChangeState'])){
        if(!empty($_POST['check_list']))
        {
             foreach($_POST['check_list'] as $id){
                // echo "<br>$id was checked! ";
                $question =  $wpdb->get_results("SELECT * FROM wp_form WHERE id = '$id' ", OBJECT);
                if($question[0]-> status == 0)
                    $wpdb->query($wpdb->prepare("UPDATE wp_form SET status = 1 WHERE id = %d", $id));
                else 
                    $wpdb->query($wpdb->prepare("UPDATE wp_form SET status = 0 WHERE id = %d", $id));
             }
             echo '<script type="text/javascript">'; 
             echo 'window.location.reload(true)';
             echo '</script>';
        }
    }
        // code php for change many state of question
        // code for add new question and answer
         if (isset($_POST['form_click'])){
                $wpdb->insert(
                    'wp_form',
                    array(
                        'formName' => $_POST['contentqs'],
                        'startTime' => $_POST['startTime'],
                        'endTime' => $_POST['endTime'],
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s'
                    )
                );
                $numans = $_POST['numans'];
                $qid = $wpdb->insert_id;
                for ($i=0; $i < $numans; $i++) 
                { 
                      $wpdb->insert(
                        'wp_field',
                        array(
                            'formid' => $qid,
                            'content' =>  $_POST['ans'.$i]
                        ),
                        array(
                            '%s',
                            '%s'
                        )
                    );  
                } 
                echo '<script type="text/javascript">'; 
                echo 'window.location.reload(true)';
                echo '</script>';  
        }
    // code for add new question and answer 
    // code edit question and answer
       if (isset($_POST['form_clickedit'])){ 
            $quesid = $_POST['quesid'];
            $wpdb->query($wpdb->prepare("UPDATE wp_form SET formName = %s , startTime = %s , endTime = %s WHERE id = %d", $_POST['contentqsedit'], $_POST['startTimeedit'],$_POST['endTimeedit'],$quesid)); 
            $numansbefedit = $_POST['numansbefedit'];
            $numansedit = $_POST['numansedit'] + 1;
            $idansstring = $_POST['idansstring'];
            $arransid = explode(',', $idansstring);
            // $tt = 0;
            // echo $_POST['ansedit'.$tt];
            for ($i=0; $i <$numansbefedit ; $i++) {
                $wpdb->query($wpdb->prepare("UPDATE wp_field SET content = %s WHERE id = %d", $_POST["ansedit".$i], $arransid[$i] ));
            }
            for ($i = $numansbefedit ; $i < $numansedit ; $i++) {
                    $wpdb->insert(
                    'wp_field',
                    array(
                        'formid' => $quesid,
                        'content' =>  $_POST["ansedit".$i]
                    ),
                    array(
                        '%s',
                        '%s'
                    )
                );  
            }
           echo '<script type="text/javascript">'; 
           echo 'window.location.reload(true)';
           echo '</script>';  
       }
    // code edit question and answer
 
    ?>

<!--code html and php for show data question and answer-->
<head>  
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/themes/statfort/jquery_uet/jquery-3.1.0.min.js" /> -->
    <style type="text/css">
    </style>
</head>
<div id="test" class="table-responsive">
    <div style="font-weight: bold;font-size: 16pt;font-family: Roboto, sans-serif;">
        Quản Lý Mẫu Đơn
    </div>
 <form method="post" name="frm">
    <br>
    <input type="hidden"  name="qtid" id="holdid" />
    <input style="color:#337ab7;font-weight: bold; " class="btn btn-default btn-md" type="submit" name="ChangeState" id="reload" value="Thay đổi trạng thái"/>
    <button style="color:#337ab7;font-weight: bold;" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#myModal">Thêm câu hỏi</button>
    <br>
    <!--code cho phan phan trang -->
    <?php
         // code sap xep lai question va luu vao 1 doi tuong khac;
        $count = 0;
        $length =  count($questions);
        $tmp = $questions;
        $i = 0;
        for($m = 0;  $m <$length; $m++){
            if($questions[$m]->status == 1){
                $tmp[$i] = $questions[$m];
                $i++;
            }
        }
        for($m = 0;  $m <$length; $m++){
            if($questions[$m]->status == 0){
                $tmp[$i] = $questions[$m];
                $i++;
            }
        }
        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 3; // number of rows in page           
        $offset = ( $pagenum - 1 ) * $limit; 
        $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_form`" );
        $num_of_pages = ceil( $total / $limit );
    ?>   
    <br>
    <br/>

    <!-- <?php $name ="hello"; echo ucfirst("$name"); ?> -->
    <table class="wp-list-table widefat fixed striped pages"  style="width: 99%; ">
            <tr style="color:#337ab7;font-size:12pt;border: solid 0.1px #f2f2f2;background-color: #fff">
                <th style="text-align: center;width: 3em;"><input style="margin-left:2px;" id="allcheckbox" type="checkbox"></th>
                <th style="width:400px;font-weight: normal;color : #337ab7">Tên đơn</th>
                <th style="text-align: center;font-weight: normal;color : #337ab7">Trạng thái đơn</th>
                <th style="text-align: center;font-weight: normal;color : #337ab7">Chỉnh sửa</th>
            </tr>
        <?php
        function my_mb_ucfirst($str) {
            $fc = mb_strtoupper(mb_substr($str, 0, 1));
            echo $fc.mb_substr($str, 1);
        }
            
            for($j= $offset; $j <$total ; $j++){
                $answers = getfield($tmp[$j]-> id);
                if($j < $limit * $pagenum){
                    if($tmp[$j]-> status == 1){
                        if($count % 2 != 0){
                            echo '<tr style="cursor: pointer; color: #337ab7; ">';
                        }
                        else{
                            echo '<tr style="cursor: pointer; color: #337ab7; background-color: #f2f2f2">';
                        }           
        ?>
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $tmp[$j]->id?>" value= "<?php echo $tmp[$j]->id?>" ></td>
                <td style="font-weight:bold;color : #337ab7"id="tdqt<?php echo $tmp[$j]->id?>" onclick="showAns('<?php echo $tmp[$j]->id?>')" ><?php $name = $tmp[$j]-> formName; my_mb_ucfirst($name) ;?></td>

                <td style="text-align: center;" ><input style="font-weight: bold;"type="submit" class="btn btn-danger btn-md" onclick="getidandreturn('<?php echo $tmp[$j]->id?>')" name="form_click1" value="<?= displayformStatus($tmp[$j]-> status) ?>"/></td>

                <td style="text-align: center;" ><input style="color:#337ab7;font-weight: bold" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $tmp[$j]->id?>')" value="Sửa"/></td> 
            </tr>
        <?php
                }
                else{
                    if($count % 2 != 0){
                            echo '<tr style="cursor: pointer; color: #337ab7; ">';
                        }
                    else{
                            echo '<tr style="cursor: pointer; color: #337ab7; background-color:  #f2f2f2">';
                    }  
        ?>          
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $tmp[$j]->id?>" value= "<?php echo $tmp[$j]->id?>" ></td>
                <td style="font-weight:bold;color : #337ab7" id="tdqt<?php echo $tmp[$j]->id?>" onclick="showAns('<?php echo $tmp[$j]->id?>')" ><?php $name = $tmp[$j]-> formName ; my_mb_ucfirst($name);?></td>

                <td style="text-align: center;"><input style="color:#337ab7;font-weight: bold" type="submit" class="btn btn-default btn-md" onclick="getidandreturn('<?php echo $tmp[$j]->id?>')" name="form_click1" value="<?= displayformStatus($tmp[$j]-> status) ?>"/></td>
                <td style="text-align: center; "><input style="color:#337ab7;font-weight: bold" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $tmp[$j]->id?>')" value ="Sửa"/></td> 
            </tr>
        <?php
            }   
            $count ++;
        ?>
            <!-- phần câu trả lời -->
            <tr id="answer<?php echo $tmp[$j]->id?>" class="answer">
                <td colspan="4" style="background-color:#f9f9f9" >
                    <div  style="float:left; width: 30%; margin-left:10%;">
                <?php
                    $length =  count($answers);
                    $k = 0;
                    for ($i=0; $i < $length/3 ; $i++) { 
                        if($answers[$i]-> status == 1){
                    ?>  
                            <li> 
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;" class="glyphicon glyphicon-remove btn-danger" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php
                        }
                    $k ++;
                    }
                    echo'</div>';
                    echo'<div style="float:left;width: 30%">';
                    for ($i= $k; $i < 2*$length/3 ; $i++) { 
                        if($answers[$i]-> status == 1){
                ?>  
                        
                            <li> 
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;" class="glyphicon glyphicon-remove btn-danger" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php
                        }
                        $k ++;
                    }
                    echo '</div>';
                    echo '<div style="float:left">';
                    for ($i= $k; $i < $length ; $i++) { 
                        if($answers[$i]-> status == 1){
                ?>  
                            <li> 
                            <label style="width:180px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:180px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> content ?></label>
                            <button type="submit" style="border-radius:10px;" class="glyphicon glyphicon-remove btn-danger"onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php
                        }
                        $k ++;
                    }
                    echo'</div>';
                echo'</td>';
            echo'</tr>';
            }
        }
        ?> 
        </table>
        <br/> 
        <!-- vi tri can phan trang --> 
</form>
         


<!--code html and php for show data question and answer-->
<!--code javascript for all -->
<script>
        jQuery(window).load(function() {
            jQuery(".answer").css("display", "none");
            jQuery("#tblDate").css("display", "none");
        });
        jQuery("#allcheckbox").change(function() {
            if(this.checked) {
                jQuery(":checkbox").prop('checked', true);
            }
            else{
                jQuery(":checkbox").prop('checked', false);   
            }
        });
        var numans = 0;
        var numansbefedit = 0;
        function insertAnswer(){
            var id = "ans"+numans;
            var idx = "x" + numans;
            var idbr = "br" + numans;
            jQuery('</br>').attr('class' ,"answertab").attr('id',idbr).insertBefore("#answer");
            jQuery('<input>').attr('id' ,id ).insertBefore("#answer");
            jQuery("#" + id).val(jQuery("#answer").val());
            jQuery("#" + id).attr('name' ,id );
            jQuery("#" + id).attr('class' ,"answertab");
            jQuery('<a class="glyphicon glyphicon-remove"></a>').attr('id' ,idx ).insertBefore("#answer");
            jQuery("#" + idx).attr('onClick', 'DeleteTempAns(this.id);');
            numans++;
            jQuery("#numans").val(numans);
            jQuery(".answerip" ).val("");
            jQuery(".answerip").focus();
        }
        function DeleteTempAns(temp){
            var newtemp = temp.substring(1);
            jQuery("#br" + newtemp).remove();
            jQuery("#ans" + newtemp).remove();
            jQuery("#" + temp).remove();
            for (jQueryi= parseInt(newtemp)+1; jQueryi < parseInt(numans) ; jQueryi++) {
                var newnumid = parseInt(jQueryi) - 1;
                var anstempval = jQuery("#ans" + jQueryi).val();
                jQuery("#ans" + jQueryi).remove();
                jQuery("#br" + jQueryi).remove();
                jQuery("#x" + jQueryi).remove();
                jQuery('</br>').attr('id' , "br" + newnumid ).insertBefore("#answer");
                jQuery('<input>').attr('id' , "ans" + newnumid ).attr('name' , "ans" + newnumid).attr('class',"answertab").insertBefore("#answer");
                jQuery("#ans" + newnumid).val(anstempval);
                jQuery('<a class="glyphicon glyphicon-remove"></a>').attr('id' , "x" + newnumid ).insertBefore("#answer");
                jQuery("#x" + newnumid).attr('onClick', 'DeleteTempAns(this.id);');
            }
            numans--;
            //alert(numans);          
        }
         function insertAnswerEdit(){
            var id = "ansedit"+numans;
            var idx = "x" + numans;
            var idbr = "br" + numans;
            jQuery('</br>').attr('class' ,"answertab").attr('id',idbr).insertBefore("#answeredit");
            jQuery('<input>').attr('id' ,id ).insertBefore("#answeredit");
            jQuery("#" + id).val(jQuery("#answeredit").val());
            jQuery("#" + id).attr('name' ,id );
            jQuery("#" + id).attr('class' ,"answertab");
            jQuery('<a class="glyphicon glyphicon-remove"></a>').attr('id' ,idx ).insertBefore("#answeredit");
            jQuery("#" + idx).attr('onClick', 'DeleteTempAnsEdit(this.id);');
            jQuery("#numansedit").val(numans);
            jQuery(".answerip" ).val("");
            jQuery(".answerip").focus();
            numans++;
        }
       
         function DeleteTempAnsEdit(temp){
            var newtemp = temp.substring(1);
            jQuery("#br" + newtemp).remove();
            jQuery("#ansedit" + newtemp).remove();
            jQuery("#" + temp).remove();
            for (jQueryi= parseInt(newtemp)+1; jQueryi < parseInt(numans) ; jQueryi++) {
                var newnumid = parseInt(jQueryi) - 1;
                var anstempval = jQuery("#ansedit" + jQueryi).val();
                jQuery("#ansedit" + jQueryi).remove();
                jQuery("#br" + jQueryi).remove();
                jQuery("#x" + jQueryi).remove();
                jQuery('</br>').attr('id' , "br" + newnumid ).insertBefore("#answeredit");
                jQuery('<input>').attr('id' , "ansedit" + newnumid ).attr('name' , "ansedit" + newnumid).attr('class',"answertab").insertBefore("#answeredit");
                jQuery("#ansedit" + newnumid).val(anstempval);
                jQuery('<a class="glyphicon glyphicon-remove"></a>').attr('id' , "x" + newnumid ).insertBefore("#answeredit");
                jQuery("#x" + newnumid).attr('onClick', 'DeleteTempAnsEdit(this.id);');
            }
            numans--;
            //alert(numans);          
        }
        function getidandreturn(id){
            jQuery("#holdid").val(id);
        }
        function closeandDelete(){
            jQuery( ".answertab" ).remove();
            jQuery(".answerip" ).val("");
            numans = 0;    
            numansbefedit = 0;      
        }
        function showQuesandAns(id){
            var idansstring = "";
            jQuery("#txtqsedit").val(jQuery("#tdqt" + id).text());
            jQuery("#startTimeedit").val(jQuery("#lblstart" + id).text());
            jQuery("#endTimeedit").val(jQuery("#lblend" + id).text());
            jQuery("#quesid").val(id);
            jQuery('#olans'+ id).children('li').children('label').each(function () {
                var id = "ansedit"+numansbefedit;
                jQuery('</br>').attr('class' ,"answertab").insertBefore("#answeredit");
                jQuery('<input>').attr('id' , id).val(jQuery(this).text()).insertBefore("#answeredit");
                jQuery("#" + id).attr('name' ,id );
                jQuery('#ansedit' + numansbefedit).attr('class',"answertab");
                numansbefedit++;
                var ansid = jQuery(this).attr('id').toString();
                idansstring = idansstring  + ansid + ",";
            });
            jQuery("#idansstring").val(idansstring);
            numans = numansbefedit;
            jQuery("#numansbefedit").val(numansbefedit);
            jQuery("#numansedit").val(numans);
        }
        function showAns(qid){
            jQuery("#answer" + qid).fadeToggle('slow');
        }
        function showEditDate(){
            jQuery("#tblDate").fadeToggle('slow');
        }
</script>
<!--code javascript for all -->

    <!-- Trigger the modal with a button -->
    
    <!-- Modal Add question-->
    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST" style="font-family:'Roboto', sans-serif;margin-left: 10px;margin-right: 10px;">
                    <div class="modal-header"> 
                        <div style="font-size:13pt;font-weight:bold;color:#337ab7;text-align:center;">Thêm Đơn Từ</div><br>
                        <div>
                            <label style="color:#337ab7;font-weight:normal">Tên đơn</label>
                            <textarea id="txtqs" name="contentqs" placeholder="Chỉ nhập tên bằng chữ thường" rows = 2 style="font-weight:bold;width:100%;border-radius:4px;" ></textarea>
                        </div><br>
                        <table style="width :100%">
                            <tr>
                                <td><input style="width: 190px;text-align: center;border-radius:4px;font-weight:bold" type="date" name="startTime" id="startTime"></td>
                                <td><input  style="margin-left:10%;width: 190px;text-align: center;border-radius:4px;font-weight:bold" type="date" name="endTime" id="endTime"></td>
                            </tr>
                        </table>
                        <br>
                        <label id="anslb" style="color:#337ab7;font-weight:normal">Thêm trường</label>
                        <input type="text" style="font-weight:bold" class="form-control answerip" id="answer"/>
                        <br>  
                        <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" id="btnaddAnswer" onclick="insertAnswer()" >Thêm</button>
                      <!-- </div> -->
                        <div style="float:right">
                            <input type="submit" style="color:#337ab7;font-weight:bold" class="btn btn-default"  name="form_click" value="Hoàn thành"/>
                            <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                        </div>
                        <input type="hidden" class="form-control" name="numans" id="numans"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Trigger the modal with a button -->

        <!-- Trigger the modal with a button -->
    
    <!-- Modal edit-->
    <div id="EditModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header" style="font-family:'Roboto', sans-serif;margin-left: 10px;margin-right: 10px;">
                        <div style="font-size:13pt;font-weight:bold;color:#337ab7;text-align:center;">Sửa Đơn Từ</div><br>
                        <div>    
                            <label style="color:#337ab7;font-weight:normal">Tên đơn</label>
                            <input type="hidden" class="form-control" name="quesid" id="quesid"/>
                            <textarea style="font-weight:bold;width:100%;border-radius:4px;" id="txtqsedit" name="contentqsedit" placeholder="Chỉ nhập tên bằng chữ thường" rows = 2></textarea>
                        </div><br>

    <!--                     </br> -->           
                      <!-- <div class="modal-body"> -->
                        <br>
                        <label id="anslbedit"style="color:#337ab7;font-weight:normal">Thêm trường</label>
                        <input style="font-weight:bold" type="hidden" class="form-control" name="idansstring" id="idansstring"/>
                        <input style="font-weight:bold" type="text" class="form-control answerip" id="answeredit"/>
                        <br>  
                        <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" id="btnaddAnsweredit" onclick="insertAnswerEdit()" >Thêm</button>
                      <!-- </div>-->
                        <div style="float:right;">
                            <input type="submit" style="color:#337ab7;font-weight:bold"class="btn btn-default"  name="form_clickedit" value="Hoàn Thành"/>
                            <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                        </div>
                        <input type="hidden" class="form-control" name="numansedit" id="numansedit"/>
                        <input type="hidden" class="form-control" name="numansbefedit" id="numansbefedit"/>
                    </div>
                </form>
            </div>
      </div>
    </div>
    <div style="margin-left:80%">
     <?php 
            for($k= 0; $k < $num_of_pages; $k++ ){
        ?>
            <ul class="pagination" style="margin: 1em 0;" >
                <li>
                    <a class = "number-page" href="?page=my-unique-identifiertwo&pagenum=<?=($k+1)?>">
                        <?php echo ($k+1)?>
                    </a>
                </li>
            </ul>

        <?php       
            }
         ?>
    </div>
    <!-- Trigger the modal with a button -->
<?php   
}
