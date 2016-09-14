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

wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('prefix_jquery');

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
                        'type' 	=>  $_POST['type'],
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
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
</head>
<div id="test" class="table-responsive">
<div style="font-weight: bold;font-size: 16pt;font-family: 'Roboto', sans-serif;">
    Quản Lý Câu Hỏi Khảo Sát
</div>
 <form method="post" name="frm">
 <br>
    <input type="hidden"  name="qtid" id="holdid" />
    <button class="btn btn-primary btn-md" type="submit" name="ChangeState" id="reload" >Thay đổi trạng thái</button>
    <button type="button" class="btn btn-primary btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#myModal" onclick="" >Thêm câu hỏi</button> 
   <button type="button" class="btn btn-primary btn-md" id= "btnDate" onclick="showEditDate()">Thay đổi ngày</button>
   <br>
 	<!--code cho phan phan trang -->
 	<?php
 		 // code sap xep lai question va luu vao 1 doi tuong khac;
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
		$limit = 8; // number of rows in page			
		$offset = ( $pagenum - 1 ) * $limit; 
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_surveyquestion`" );
		$num_of_pages = ceil( $total / $limit );
	?>   
    <br>
    <table id="tblDate" style="width: 500px;font-weight:bold">
        <tr>
            <th><div>Ngày bắt đầu</div></th>
            <th><div>Ngày kết thúc</div></th>
        </tr>
        <tr>
            <td><input type="date" name="ChangestartTime" id="ChangestartTime"></td>
            <td><input type="date" name="ChangeendTime" id="ChangeendTime"></td>
            <td><button class="btn btn-primary btn-md" type="submit" name="ChangeDate" id="ChangeDate" >Hoàn Thành</button></td>
        </tr>
    </table>
    <br/>
    <table class="table  table-hover maintable" style="width:99%;">
            <tr style="background:#23282d; color:white;font-size:14pt">
                <th style="text-align: center";><input id="allcheckbox" type="checkbox"></th>
                <th style="width:400px;">Nội dung câu hỏi</th>
                <th style="text-align: center;">Ngày bắt đầu</th>
                <th style="text-align: center;">Ngày kết thúc</th>
                <th style="text-align: center;" >Kiểu câu hỏi</th>
                <th style="text-align: center;">Trang thái</th>
                <th style="text-align: center;">Chỉnh sửa</th>
            </tr>
        <?php
			for($j= $offset; $j <$total ; $j++){
				$answers = getanswer($tmp[$j]-> id);
				if($j < $limit * $pagenum){
                    if($tmp[$j]-> status == 1){
        ?> 
            <tr style="cursor: pointer;">
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $tmp[$j]->id?>" value= "<?php echo $tmp[$j]->id?>" ></td>
                <td style="text-transform: lowercase; font-weight:bold;font-size:12pt" id="tdqt<?php echo $tmp[$j]->id?>" onclick="showAns('<?php echo $tmp[$j]->id?>')" ><?= $tmp[$j]-> contentquestion?></td>
                <td style="text-align: center;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><label id="lblstart<?php echo $tmp[$j]->id?>" ><?= $tmp[$j]-> startTime?></label></td>
                <td style="text-align: center;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><label id="lblend<?php echo $tmp[$j]->id?>" ><?= $tmp[$j]-> endTime?></label></td>
                <td style="text-align: center;font-weight:bold;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><?= displayTypeQuestion($tmp[$j]-> type) ?></td>
                <td style="text-align: center;"><input type="submit" class="btn btn-danger btn-md" onclick="getidandreturn('<?php echo $tmp[$j]->id?>')" name="form_click1" value="<?= displayquestionStatus($tmp[$j]-> status) ?>"/></td>
                <td style="text-align: center;"><button type="button" class="btn btn-primary btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $tmp[$j]->id?>')" >Sửa</button></td> 
            </tr>
        <?php
                }
                else{
        ?>
            <tr style="background: #ff8080; cursor: pointer;">
                <td style="text-align: center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $tmp[$j]->id?>" value= "<?php echo $tmp[$j]->id?>" ></td>
                <td style="text-transform: lowercase; font-weight:bold;font-size:12pt" id="tdqt<?php echo $tmp[$j]->id?>" onclick="showAns('<?php echo $tmp[$j]->id?>')" ><?= $tmp[$j]-> contentquestion?></td>
                <td style="text-align: center;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><label id="lblstart<?php echo $tmp[$j]->id?>" ><?= $tmp[$j]-> startTime?></label></td>
                <td style="text-align: center;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><label id="lblend<?php echo $tmp[$j]->id?>" ><?= $tmp[$j]-> endTime?></label></td>
                <td style="text-align: center;font-weight:bold;"onclick="showAns('<?php echo $tmp[$j]->id?>')"><?= displayTypeQuestion($tmp[$j]-> type) ?></td>
                <td style="text-align: center;"> <input type="submit" class="btn btn-primary btn-md" onclick="getidandreturn('<?php echo $tmp[$j]->id?>')" name="form_click1" value="<?= displayquestionStatus($tmp[$j]-> status) ?>"/></td>
                <td style="text-align: center;"><button type="button" class="btn btn-primary btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#EditModal" onclick="showQuesandAns('<?php echo $tmp[$j]->id?>')" >Sửa</button></td> 
            </tr>
        <?php
            }   
        ?>
            <tr id="answer<?php echo $tmp[$j]->id?>" class="answer">
                <td></td>
                <td>
                    <!-- <ol id="olans<?php echo $tmp[$j]->id?>"> -->
                <?php 
                    for ($i=0; $i <count($answers) ; $i++) { 
                        if($answers[$i]-> status == 1){
                ?>
                        <li> 
                        <label style="width:200px" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
                        <button type="submit" style="border-radius:10px; margin-left:10px"class="glyphicon glyphicon-ok btn-primary" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayquestionStatus($answers[$i]-> status) ?>"></button> 
                        </li>
                <?php 
                        }
                    else{
                ?>
                        <li> 
                        <label style="width:200px" id="<?php echo $answers[$i]-> id?>"> <?= $answers[$i]-> answer ?></label>
                        <button type="submit" style="border-radius:10px;margin-left:10px" class="glyphicon glyphicon-remove btn-danger" onclick="getidandreturn('<?php echo $answers[$i]->id?>')" name="form_click2" value="<?= displayquestionStatus($answers[$i]-> status) ?>"></button>
                        </li>
                <?php 
                    }
                }
                ?>
                    <!-- </ol> -->
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>   
            <?php
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

        $(window).load(function() {
            $(".answer").css("display", "none");
            $("#tblDate").css("display", "none");
        });
        $("#allcheckbox").change(function() {
            if(this.checked) {
                $(":checkbox").prop('checked', true);
            }
            else{
                $(":checkbox").prop('checked', false);   
            }
        });
        var numans = 0;
        var numansbefedit = 0;
        function insertAnswer(){
            var id = "ans"+numans;
            var idx = "x" + numans;
            var idbr = "br" + numans;
            $('</br>').attr('class' ,"answertab").attr('id',idbr).insertBefore("#answer");
            $('<input>').attr('id' ,id ).insertBefore("#answer");
            $("#" + id).val($("#answer").val());
            $("#" + id).attr('name' ,id );
            $("#" + id).attr('class' ,"answertab");
            $('<a class="glyphicon glyphicon-remove"></a>').attr('id' ,idx ).insertBefore("#answer");
            $("#" + idx).attr('onClick', 'DeleteTempAns(this.id);');
            numans++;
            $("#numans").val(numans);
            $(".answerip" ).val("");
            $(".answerip").focus();

        }
        function DeleteTempAns(temp){
            var newtemp = temp.substring(1);
            $("#br" + newtemp).remove();
            $("#ans" + newtemp).remove();
            $("#" + temp).remove();

            for ($i= parseInt(newtemp)+1; $i < parseInt(numans) ; $i++) {
                var newnumid = parseInt($i) - 1;
                var anstempval = $("#ans" + $i).val();
                $("#ans" + $i).remove();
                $("#br" + $i).remove();
                $("#x" + $i).remove();
                $('</br>').attr('id' , "br" + newnumid ).insertBefore("#answer");
                $('<input>').attr('id' , "ans" + newnumid ).attr('name' , "ans" + newnumid).attr('class',"answertab").insertBefore("#answer");
                $("#ans" + newnumid).val(anstempval);
                $('<a class="glyphicon glyphicon-remove"></a>').attr('id' , "x" + newnumid ).insertBefore("#answer");
                $("#x" + newnumid).attr('onClick', 'DeleteTempAns(this.id);');
            }
            numans--;
            //alert(numans);          
        }
         function insertAnswerEdit(){
            var id = "ansedit"+numans;
            var idx = "x" + numans;
            var idbr = "br" + numans;
            $('</br>').attr('class' ,"answertab").attr('id',idbr).insertBefore("#answeredit");
            $('<input>').attr('id' ,id ).insertBefore("#answeredit");
            $("#" + id).val($("#answeredit").val());
            $("#" + id).attr('name' ,id );
            $("#" + id).attr('class' ,"answertab");
            $('<a class="glyphicon glyphicon-remove"></a>').attr('id' ,idx ).insertBefore("#answeredit");
            $("#" + idx).attr('onClick', 'DeleteTempAnsEdit(this.id);');
            $("#numansedit").val(numans);

            $(".answerip" ).val("");
            $(".answerip").focus();
            numans++;

        }
       
         function DeleteTempAnsEdit(temp){
            var newtemp = temp.substring(1);
            $("#br" + newtemp).remove();
            $("#ansedit" + newtemp).remove();
            $("#" + temp).remove();

            for ($i= parseInt(newtemp)+1; $i < parseInt(numans) ; $i++) {
                var newnumid = parseInt($i) - 1;
                var anstempval = $("#ansedit" + $i).val();
                $("#ansedit" + $i).remove();
                $("#br" + $i).remove();
                $("#x" + $i).remove();
                $('</br>').attr('id' , "br" + newnumid ).insertBefore("#answeredit");
                $('<input>').attr('id' , "ansedit" + newnumid ).attr('name' , "ansedit" + newnumid).attr('class',"answertab").insertBefore("#answeredit");
                $("#ansedit" + newnumid).val(anstempval);
                $('<a class="glyphicon glyphicon-remove"></a>').attr('id' , "x" + newnumid ).insertBefore("#answeredit");
                $("#x" + newnumid).attr('onClick', 'DeleteTempAnsEdit(this.id);');
            }
            numans--;
            //alert(numans);          
        }

        function getidandreturn(id){
            $("#holdid").val(id);
        }
        function closeandDelete(){
            $( ".answertab" ).remove();
            $(".answerip" ).val("");
            numans = 0;    
            numansbefedit = 0;      
        }
        function showQuesandAns(id){
            var idansstring = "";
            $("#txtqsedit").val($("#tdqt" + id).text());
            $("#startTimeedit").val($("#lblstart" + id).text());
            $("#endTimeedit").val($("#lblend" + id).text());
            $("#quesid").val(id);
            $('#olans'+ id).children('li').children('label').each(function () {
                var id = "ansedit"+numansbefedit;
                $('</br>').attr('class' ,"answertab").insertBefore("#answeredit");
                $('<input>').attr('id' , id).val($(this).text()).insertBefore("#answeredit");
                $("#" + id).attr('name' ,id );
                $('#ansedit' + numansbefedit).attr('class',"answertab");
                numansbefedit++;
                var ansid = $(this).attr('id').toString();
                idansstring = idansstring  + ansid + ",";
            });
            $("#idansstring").val(idansstring);
            numans = numansbefedit;
            $("#numansbefedit").val(numansbefedit);
            $("#numansedit").val(numans);
        }
        function showAns(qid){
            $("#answer" + qid).slideToggle(0);
        }
        function showEditDate(){
            $("#tblDate").slideToggle(0);
        }
</script>
<!--code javascript for all -->

    <!-- Trigger the modal with a button -->
    
    <!-- Modal Add question-->
    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST">
                  <div class="modal-header" style="font-weight:bold;">
                    <div style="font-size:13pt;">Thêm câu hỏi</div><br>
                    <textarea id="txtqs" name="contentqs" placeholder="Nhập câu hỏi" rows = 2 style="width:100%"></textarea>
                    <table style="width :100%">
                        <tr>
                            <th><div>Ngày bắt đầu</div></th>
                            <th><div>Ngày kết thúc</div></th>
                        </tr>
                        <tr>
                            <td><input type="date" name="startTime" id="startTime"></td>
                            <td><input type="date" name="endTime" id="endTime"></td>
                        </tr>
                    </table>
        
                    </br>
                    <input type="radio" name="type" value="1" > Single Answer<br>
				    <input type="radio" name="type" value="2"> Mutiples Answer<br>
				   
                  </div>
                  <div class="modal-body">
                    <label id="anslb">Thêm câu trả lời</label>
                    <input type="text" class="form-control answerip" id="answer" />
                    <br/>  
                    <button type="button" class="btn btn-default" id="btnaddAnswer" onclick="insertAnswer()" >Thêm</button>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-default"  name="form_click" value="Hoàn thành"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                  </div>
                  <input type="hidden" class="form-control" name="numans" id="numans"/>
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
                  <div class="modal-header" style="font-weight:bold;">
                    <div style="font-size:13pt;">Sửa câu hỏi</div><br>
                    <input type="hidden" class="form-control" name="quesid" id="quesid"/>
                    <textarea id="txtqsedit" name="contentqsedit" placeholder="Nhập câu hỏi" rows = 2 style="width:100%"></textarea>
                    <table style="width:100%">
                        <tr>
                            <th><div>Ngày bắt đầu</div></th>
                            <th><div>Ngày kết thúc</div></th>
                        </tr>
                        <tr>
                            <td><input type="date" name="startTimeedit" id="startTimeedit"></td>
                            <td><input type="date" name="endTimeedit" id="endTimeedit"></td>
                        </tr>
                    </table>
                                        
                    </br>
                    <input type="radio" name="typeedit" value="1" id = "radio1"> Single Answer<br>
				    <input type="radio" name="typeedit" value="2" id = "radio2"> Mutiples Answer<br>

                  </div>
                  <div class="modal-body">
                    <label id="anslbedit">Thêm câu trả lời</label>
                    <input type="hidden" class="form-control" name="idansstring" id="idansstring"/>
                    <input type="text" class="form-control answerip" id="answeredit" />
                    <br/>  
                    <button type="button" class="btn btn-default" id="btnaddAnsweredit" onclick="insertAnswerEdit()">Thêm</button>
                  </div>
                  <div class="modal-footer">
                        
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                  </div>
                  <input type="hidden" class="form-control" name="numansedit" id="numansedit"/>
                  <input type="hidden" class="form-control" name="numansbefedit" id="numansbefedit"/>
                </form>
            </div>

      </div>
    </div>
    <div style="margin-left:500px">
     <?php 
            for($k= 0; $k < $num_of_pages; $k++ ){
        ?>
            <ul class="pagination" style="margin: 1em 0;" >
                    <li >
                        <a class = "number-page" href="?page=my-unique-identifierone&pagenum=<?=($k+1)?>">
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