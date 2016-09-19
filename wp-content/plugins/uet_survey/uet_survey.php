<?php
/**
 * Created by SublineText.
 * User: Vuongdz
 * Date: 8/12/2016
 * Time: 12:05 AM
 * Plugin Name: UET Survey
wp_re
 * Author URI:
 * Description: Đây là Plugin servey form dành riêng cho Đại học Công nghệ
 * Tags: UET
 * Version: 1.4
 */
global $uet_db_version;
$uet_db_version = '1.0';
add_action('plugins_loaded', 'create_surveytable');
add_action('plugins_loaded', 'create_answertable');
add_action('plugins_loaded', 'survey_uet');

wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
// wp_register_script('prefix_bootstrap', 'wp-content/plugins/uet_survey/bootstrap/js/bootstrap.min.js');
wp_enqueue_script('prefix_bootstrap');
wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
// wp_register_style('prefix_bootstrap', 'wp-content/plugins/uet_survey/bootstrap/css/bootstrap.min.css');
wp_enqueue_style('prefix_bootstrap');
// wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
// wp_enqueue_script('prefix_jquery');

// function themeprefix_bootstrap_modals1() {

//   wp_deregister_script('jquery');
//   wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', false, '1.3.2', true);

//   wp_register_script ( 'modaljs' , get_stylesheet_directory_uri() . '/wp-includes/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '1', true );
//   wp_register_style ( 'modalcss' , get_stylesheet_directory_uri() . '/wp-includes/bootstrap/css/bootstrap.css', '' , '', 'all' );
  
//   wp_enqueue_script( 'modaljs' );
//   wp_enqueue_style( 'modalcss' );
// }

// add_action( 'wp_enqueue_scripts', 'themeprefix_bootstrap_modals1');

function create_answertable()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'answer';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  surveyquestionid INT(8) NOT NULL,
                  answer text NOT NULL,
                  status INT(8) DEFAULT 1,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function create_surveytable()
{
    global $wpdb;
    global $uet_db_version;
    $table_name = $wpdb->prefix . 'surveyquestion';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name(
                 id INT(8) NOT NULL AUTO_INCREMENT,
                  contentquestion text NOT NULL,
                  startTime DATE,
                  endTime DATE,
                  type INT(8) NOT NULL,
                  status INT(8) NOT NULL DEFAULT 1,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    add_option('uet_db_version', $uet_db_version);
}
function survey_uet(){
    add_options_page( 'UET Survey', 'UET Survey', 'manage_options', 'my-unique-identifierone', 'uet_survey' );
}
function getanswer($id){
    global $wpdb;
    $answers =  $wpdb->get_results("SELECT * FROM wp_answer WHERE surveyquestionid = '$id' ", OBJECT);
    return $answers;
}
function displayquestionStatus($status){
    if($status == 0) echo "Kích hoạt";
    else echo "Không kích hoạt";
}
function displayTypeQuestion($type){
    if($type == 1) echo "Single answer";
    else echo "Mutiple answers";    
}
function uet_survey()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
     
    global $wpdb;
      //code php for set active or deactive each element and get all result 
    if (isset($_POST['form_click1'])) {
        $id = $_POST['qtid'];
        $question =  $wpdb->get_results("SELECT * FROM wp_surveyquestion WHERE id = '$id' ", OBJECT);
        if($question[0]-> status == 0)
            $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET status = 1 WHERE id = %d", $_POST['qtid']));
        else 
            $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET status = 0 WHERE id = %d", $_POST['qtid']));
    }
    $questions = $wpdb->get_results('SELECT * FROM wp_surveyquestion', OBJECT);
    if (isset($_POST['form_click2'])) {
        $id = $_POST['qtid'];
        $answer =  $wpdb->get_results("SELECT * FROM wp_answer WHERE id = '$id' ", OBJECT);
        if($answer[0]-> status == 0)
            $wpdb->query($wpdb->prepare("UPDATE wp_answer SET status = 1 WHERE id = %d", $_POST['qtid']));
        else 
            $wpdb->query($wpdb->prepare("UPDATE wp_answer SET status = 0 WHERE id = %d", $_POST['qtid']));
    }    
     //code php for set active or deactive each element
 
?> 
    <!--code php for change many state of question -->
    <?php
    if (isset($_POST['ChangeDate'])){
      if(!empty($_POST['check_list']))
        {   
            foreach($_POST['check_list'] as $id){
                $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET startTime = %s , endTime = %s WHERE id = %d", $_POST['ChangestartTime'],$_POST['ChangeendTime'],$id));
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
                $question =  $wpdb->get_results("SELECT * FROM wp_surveyquestion WHERE id = '$id' ", OBJECT);
                if($question[0]-> status == 0)
                    $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET status = 1 WHERE id = %d", $id));
                else 
                    $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET status = 0 WHERE id = %d", $id));
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
                    'wp_surveyquestion',
                    array(
                        'contentquestion' => $_POST['contentqs'],
                        'startTime' => $_POST['startTime'],
                        'endTime' => $_POST['endTime'],
                        'type'  =>  $_POST['type'],
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
                        'wp_answer',
                        array(
                            'surveyquestionid' => $qid,
                            'answer' =>  $_POST['ans'.$i]
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
            if($_POST['typeedit'] != ""){
                $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET contentquestion = %s , startTime = %s , endTime = %s , type = %s WHERE id = %d", $_POST['contentqsedit'], $_POST['startTimeedit'],$_POST['endTimeedit'],$_POST['typeedit'],$quesid));
            }
            else{
                $wpdb->query($wpdb->prepare("UPDATE wp_surveyquestion SET contentquestion = %s , startTime = %s , endTime = %s WHERE id = %d", $_POST['contentqsedit'], $_POST['startTimeedit'],$_POST['endTimeedit'],$quesid));    
            }
            $numansbefedit = $_POST['numansbefedit'];
            $numansedit = $_POST['numansedit'] + 1;
            $idansstring = $_POST['idansstring'];
            $arransid = explode(',', $idansstring);
            // $tt = 0;
            // echo $_POST['ansedit'.$tt];
            for ($i=0; $i <$numansbefedit ; $i++) {
                $wpdb->query($wpdb->prepare("UPDATE wp_answer SET answer = %s WHERE id = %d", $_POST["ansedit".$i], $arransid[$i] ));
            }
            for ($i = $numansbefedit ; $i < $numansedit ; $i++) {
                    $wpdb->insert(
                    'wp_answer',
                    array(
                        'surveyquestionid' => $quesid,
                        'answer' =>  $_POST["ansedit".$i]
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
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/js" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
    <link rel="stylesheet" type="text/js" href="<?php echo get_template_directory_uri(); ?>/jquery_uet/jquery-3.1.0.min.js" />
</head>
<div id="test" class="table-responsive">
<div style="font-weight: bold;font-size: 16pt;font-family: 'Roboto', sans-serif;">
    Quản Lý Câu Hỏi Khảo Sát
</div>
 <form method="post" name="frm">
    <br>
    <input type="hidden"  name="qtid" id="holdid" />
    <input style="color:#337ab7;" class="btn btn-default btn-md" type="submit" name="ChangeState" id="reload" value="Thay đổi trạng thái"/>
    <button style="color:#337ab7;" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#myModal">Thêm câu hỏi</button>
    <button style="color:#337ab7;" type="button" class="btn btn-default btn-md" id= "btnDate" onclick="showEditDate()" >Thay đổi ngày</button>
    <br>
    <!--code cho phan phan trang -->
    <?php
         // code sap xep lai question va luu vao 1 doi tuong khac;
        // $length =  count($questions);
        // $tmp = $questions;
        // $i = 0;
        // for($m = 0;  $m <$length; $m++){
        //     if($questions[$m]->status == 1){
        //         $tmp[$i] = $questions[$m];
        //         $i++;
        //     }
        // }
        // for($m = 0;  $m <$length; $m++){
        //     if($questions[$m]->status == 0){
        //         $tmp[$i] = $questions[$m];
        //         $i++;
        //     }
        // }
        // $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        // $limit = 8; // number of rows in page           
        // $offset = ( $pagenum - 1 ) * $limit; 
        // $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_surveyquestion`" );
        // $num_of_pages = ceil( $total / $limit );

        $count = 0;
        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 3; // number of rows in page           
        $offset = ( $pagenum - 1 ) * $limit; 
        $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_surveyquestion`" );
        $num_of_pages = ceil( $total / $limit );
        $survey_questions = $wpdb->get_results( "SELECT * FROM wp_surveyquestion LIMIT $offset, $limit" );
    ?>   
    <br>
    <table id="tblDate" style="width: 40%;font-weight:bold">
        <tr>
            <th><div style="color:#337ab7;font-weight:normal">Ngày bắt đầu</div></th>
            <th><div style="color:#337ab7;font-weight:normal">Ngày kết thúc</div></th>
        </tr>
        <tr>
            <td><input style="width: 190px;text-align: center;border-radius:4px;" type="date" name="ChangestartTime" id="ChangestartTime"></td>
            <td><input style="width: 190px;text-align: center;border-radius:4px;" type="date" name="ChangeendTime" id="ChangeendTime"></td>
            <td><input style="color:#337ab7;" class="btn btn-default btn-md" type="submit" name="ChangeDate" id="ChangeDate" value="Hoàn thành"/></td>
        </tr>
    </table>
    <br/>
    <table class="wp-list-table widefat fixed striped pages"  style="width: 99%; ">
            <tr style="border: solid 0.1px #f2f2f2;background-color: #fff">
                <th style="text-align: center;width: 3em;"><input style="margin-left:2px;" id="allcheckbox" type="checkbox"></th>
                <th style="width:400px;color:#337ab7;">Nội dung câu hỏi</th>
                <th style="text-align: center;color:#337ab7;">Ngày bắt đầu</th>
                <th style="text-align: center;color:#337ab7;">Ngày kết thúc</th>
                <th style="text-align: center;color:#337ab7;" >Kiểu câu hỏi</th>
                <th style="text-align: center;color:#337ab7;">Trang thái</th>
                <th style="text-align: center;color:#337ab7;">Chỉnh sửa</th>
            </tr>
        <?php
             function my_mb_ucfirst($str) {
                $fc = mb_strtoupper(mb_substr($str, 0, 1));
                echo $fc.mb_substr($str, 1);
            }
            foreach($survey_questions as $survey_question){
                $answers = getanswer($survey_question-> id);
                    if($survey_question-> status == 1){
                        if($count % 2 != 0){
                            echo '<tr style="cursor: pointer;font-weight: bold;">';
                        }
                        else{
                            echo '<tr style="cursor: pointer; background-color: #f2f2f2;font-weight: bold;">';
                        } 
        ?>      
            <!-- <tr style="cursor: pointer;"> -->
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $survey_question->id?>" value= "<?php echo $survey_question->id?>" ></td>
                <td style="color : #337ab7" id="tdqt<?php echo $survey_question->id?>" onclick="showAns('<?php echo $survey_question->id?>')" ><?php $name = $survey_question-> contentquestion; my_mb_ucfirst($name);?></td>
                <td style="text-align: center;color : #337ab7"onclick="showAns('<?php echo $survey_question->id?>')"><label id="lblstart<?php echo $survey_question->id?>" ><?= $survey_question-> startTime?></label></td>
                <td style="text-align: center;color : #337ab7"onclick="showAns('<?php echo $survey_question->id?>')"><label id="lblend<?php echo $survey_question->id?>" ><?= $survey_question-> endTime?></label></td>
                <td style="text-align: center;color : #337ab7;font-weight:bold;"onclick="showAns('<?php echo $survey_question->id?>')"><?= displayTypeQuestion($survey_question-> type) ?></td>
                <td style="text-align: center;"><input style="font-weight:bold" type="submit" class="btn btn-danger btn-md" onclick="getidandreturn('<?php echo $survey_question->id?>')" name="form_click1" value="<?= displayquestionStatus($survey_question-> status) ?>"/></td>
                <td style="text-align: center;"><button style="color : #337ab7;font-weight:bold" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $survey_question->id?>')" >Sửa</button></td> 
            </tr>
        <?php
                    $count ++;
                }
                else{
                    if($count % 2 != 0){
                            echo '<tr style="cursor: pointer; color: #337ab7;font-weight: bold; ">';
                        }
                        else{
                            echo '<tr style="cursor: pointer; color: #337ab7; background-color: #f2f2f2;font-weight: bold;">';
                        } 
        ?>
            <!-- <tr style="background: #ff8080; cursor: pointer;"> -->
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $survey_question->id?>" value= "<?php echo $survey_question->id?>" ></td>
                <td style="color : #337ab7;" id="tdqt<?php echo $survey_question->id?>" onclick="showAns('<?php echo $survey_question->id?>')" ><?php $name = $survey_question-> contentquestion; my_mb_ucfirst($name);?></td>
                <td style="text-align: center;color : #337ab7"onclick="showAns('<?php echo $survey_question->id?>')"><label id="lblstart<?php echo $survey_question->id?>" ><?= $survey_question-> startTime?></label></td>
                <td style="text-align: center;color : #337ab7"onclick="showAns('<?php echo $survey_question->id?>')"><label id="lblend<?php echo $survey_question->id?>" ><?= $survey_question-> endTime?></label></td>
                <td style="text-align: center;color : #337ab7"onclick="showAns('<?php echo $survey_question->id?>')"><?= displayTypeQuestion($survey_question-> type) ?></td>
                <td style="text-align: center;"> <input style="color : #337ab7;font-weight:bold" type="submit" class="btn btn-default btn-md" onclick="getidandreturn('<?php echo $survey_question->id?>')" name="form_click1" value="<?= displayquestionStatus($survey_question-> status) ?>"/></td>
                <td style="text-align: center;"><button  style="color : #337ab7;font-weight:bold" type="button" class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $survey_question->id?>')" >Sửa</button></td> 
            </tr>
        <?php
                $count ++; 
            }
             
        ?>
            <tr id="answer<?php echo $survey_question->id?>" class="answer">
                <td colspan="7" style="background-color:#f9f9f9">
                    <div  style="float:left; width: 30%; margin-left:10%;">
                <?php
                    $length =  count($answers);
                    $k = 0;
                    for ($i=0; $i < $length/3 ; $i++) { 
                        if($answers[$i]-> status == 1){
                    ?>  
                            <li> 
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
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
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:150px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
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
                            <label style="width:180px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
                            <button type="submit" style="border-radius:10px;"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayformStatus($answers[$i]-> status) ?>"></button>
                            </li>
                <?php 
                        }
                        else{
                ?>
                            <li>
                            <label style="width:180px;color:#337ab7;font-weight: bold;" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
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
        ?> 
        </table>
        <br/>
        
        <!-- vi tri can phan trang -->
            
        <?php  
        $page_links = paginate_links( array(

            'base' => add_query_arg( 'pagenum', '%#%' ),
            'format' => '',
            'prev_text' => __( '&laquo;', 'aag' ),
            'next_text' => __( '&raquo;', 'aag' ),
            'total' => $num_of_pages,
            'current' => $pagenum
        ) );
        if ( $page_links ) {        
            echo '<div class="pagination" style="float:right; margin-right:75px;">
            <li>'. $page_links .'</li>
            </div>';
        }
        ?>  
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
            // jQuery('#olans'+ id).children('li').children('label').each(function () {
            jQuery('#answer'+ id).children('td').children('div').children('li').children('label').each(function () {
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
                <form method="POST" style="font-family:'Roboto', sans-serif;margin-left: 25px;margin-right: 25px;color:#337ab7">
                    <div style="font-size:13pt;font-weight:bold;text-align:center; margin-top: 10px;">Thêm Câu Hỏi</div><br>
                    <div>
                        <label style="color:#337ab7;font-weight:normal">Nội dung câu hỏi</label>     
                        <textarea style="font-weight:bold;width:100%;border-radius:4px;color:#32373C" id="txtqs" name="contentqs" placeholder="Chỉ nhập tên bằng chữ thường" rows = 2 style="width:100%"></textarea>
                    </div><br>
                    <table style="width :100%">
                        <tr>
                            <th><div style="font-weight:normal;color:#337ab7;font-size:11pt">Ngày bắt đầu</div></th>
                            <th><div style="font-weight:normal;margin-left:10%;color:#337ab7;font-size:11pt">Ngày kết thúc</div></th>
                        </tr>
                        <tr>
                            <td><input style="width: 190px;text-align: center;border-radius:4px;font-weight:bold;" type="date" name="startTime" id="startTime"></td>
                            <td><input style="margin-left:10%;width: 190px;text-align: center;border-radius:4px;font-weight:bold;" type="date" name="endTime" id="endTime"></td>
                        </tr>
                    </table>
                    <br>
                    <div style="font-weight:bold">
                        <label style="font-weight:normal">Dạng câu hỏi</label><br>
                        <div style="width: 55%;float: left;color:#32373C"><input style="margin-top: -3.5px" type="radio" name="type" value="1"/>  Single Answer</div>
                        <div style="color:#32373C"><input style="margin-top: -3.5px;" type="radio" name="type" value="2"/>  Mutiples Answer</div>
                    </div>
                    <br>
                    <label id="anslb" style="color:#337ab7;font-weight:normal" >Thêm câu trả lời</label>
                    <input type="text" style="font-weight:bold" class="form-control answerip" id="answer" />
                    <br>  
                    <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" id="btnaddAnswer" onclick="insertAnswer()" >Thêm</button>
                    <div style="float:right;">
                        <input type="submit" style="color:#337ab7;font-weight:bold" class="btn btn-default"  name="form_click" value="Hoàn thành"/>
                        <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                    </div>
                    <input type="hidden" class="form-control" name="numans" id="numans"/>
                    <br/>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Trigger the modal with a button -->

        <!-- Trigger the modal with a button -->
    
    <!-- Modal edit-->
    
    <div id="EditModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" style="font-family:'Roboto', sans-serif;margin-left: 25px;margin-right: 25px;color:#337ab7">
                    <div style="font-size:13pt;font-weight:bold;color:#337ab7;text-align:center;margin-top: 10px;">Sửa câu hỏi</div><br>
                     <div>
                        <label style="color:#337ab7;font-weight:normal">Nội dung câu hỏi</label>  
                        <input type="hidden" class="form-control" name="quesid" id="quesid"/>
                        <textarea style="font-weight:bold;width:100%;border-radius:4px;color:#32373C" id="txtqsedit" name="contentqsedit" placeholder="Nhập câu hỏi" rows = 2 style="width:100%"></textarea>
                    </div><br>
                    <table style="width:100%">
                        <tr>
                            <th><div style="font-weight:normal;color:#337ab7;font-size:11pt">Ngày bắt đầu</div></th>
                            <th><div style="font-weight:normal;margin-left:10%;color:#337ab7;font-size:11pt">Ngày kết thúc</div></th>
                        </tr>
                        <tr>
                            <td><input style="width: 190px;text-align: center;border-radius:4px;font-weight:bold;" type="date" name="startTimeedit" id="startTimeedit"></td>
                            <td><input style="margin-left:10%;width: 190px;text-align: center;border-radius:4px;font-weight:bold;" type="date" name="endTimeedit" id="endTimeedit"></td>
                        </tr>
                    </table><br>               
                    <div style="font-weight:bold">
                        <label style="font-weight:normal">Dạng câu hỏi</label><br>
                        <div style="width: 55%;float: left;color:#32373C"><input style="margin-top: -3.5px" type="radio" name="typeedit" value="1" id = "radio1"> Single Answer</div>
                        <div style="color:#32373C" ><input style="margin-top: -3.5px" type="radio" name="typeedit" value="2" id = "radio2"> Mutiples Answer</div>
                    </div><br>
                    <label id="anslbedit" style="font-weight:normal">Thêm câu trả lời</label>
                        <input type="hidden" style="font-weight:bold" class="form-control" name="idansstring" id="idansstring"/>
                        <input type="text"  style="font-weight:bold" class="form-control answerip" id="answeredit" />
                    <br>
                    <input type="hidden" class="form-control" name="numansedit" id="numansedit"/>
                    <input type="hidden" class="form-control" name="numansbefedit" id="numansbefedit"/>

                    <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" id="btnaddAnsweredit" onclick="insertAnswerEdit()">Thêm</button>
                    <div style="float:right;">
                        <input type="submit" style="color:#337ab7;font-weight:bold"class="btn btn-default"  name="form_clickedit" value="Hoàn Thành"/>                        
                        <button type="button" style="color:#337ab7;font-weight:bold" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                    </div>
                                        <br/>  
                </form>
            </div>
        </div>
    </div>
    <!-- Trigger the modal with a button -->
<?php   
}
