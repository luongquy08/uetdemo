<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Contact Form Template</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
</head>
<style type="text/css"></style>
<?php
/**
 * Template Name: form page
 */

get_header(); 
?>

<body >
    <?php 
        global $wpdb;
            $forms = $wpdb->get_results( "SELECT * FROM wp_form");
            $fields = $wpdb->get_results ( "SELECT * FROM wp_field" );
    ?>
    <div class="contact-body">    
        <div class="contact-container">
            <div class="row">
                <!-- <h1 class="header">Đơn Từ Trực Tuyến</h1> -->
                <div class="content" border="1">
                <form method="post">
                    <div class="form-group ">
                        <label class="lbl-select" for="sel1">Mời bạn chọn đơn(chỉ được chọn một) : </label></br/>
                        <select class="selectpicker" name="taskOption">
                            <option value="default">Chọn Bất Kỳ</option>
                            <?php 
                            foreach ($forms as $frm) {
                                $today = date("Y-m-d");
                                $startTime = $frm->startTime; //from db
                                $endTime = $frm->endTime;
                                
                                $today_time = strtotime($today);
                                $start_time = strtotime($startTime);
                                $end_time = strtotime($endTime);
                                if(($frm->status == 1) && ($start_time < $today_time) && ($end_time > $today_time)){      
                            ?>
                                    <option value="<?= $frm->id ?>"><?php echo $frm->formName; ?></option>
                            <?php      
                                }  
                            }
                            ?>
                        </select>
                        <button class="btn-submit1 btn-success" type="submit" style="width: 150px; height: 40px">CHỌN ĐƠN </button>
                    </div>
                    <hr/>
                    <?php  
                        $selectOption = $_POST['taskOption'];
                        foreach ($forms as $frm) {
                            if(($frm->id == $selectOption)){ 
                    ?>
                                <div class="panel ">
                                    <div class="panel-heading" ><strong><?php echo $frm->formName; ?></strong></div><br/>
                                        <div class="input-left" style="width:440px;">
                                    <?php
                                        global $wpdb;
                                        $fields1 =  $wpdb->get_results("SELECT * FROM wp_field WHERE formid = '$frm->id' AND status ='1'");
                                        $j = 0;
                                        for($i = 0; $i < round(count($fields1)/2); $i++){
                                    ?>                           
                                                <div class="panel-body">
                                                    <div class="form-group has-primary">
                                                        <label for="content"><?php echo $fields1[$i]->content ?>: </label>
                                                        <input name="<?php echo $fields1[$i]->id?>" type="text" class="form-control" id="inputSuccess" style =" border: solid 0.1px #e0e0d1;">
                                                    </div>
                                                </div>
                    <?php                       
                                            $j ++;   
                                        }
                    ?>
                                        </div>
                                        <div class="input-right" style="width:440px;">   
                    <?php
                                        for($k = $j; $k < count($fields1); $k++){
                                    ?>             
                                                <div class="panel-body">
                                                    <div class="form-group has-primary">
                                                        <label for="content"><?php echo $fields1[$k]->content ?>: </label>
                                                        <input name="<?php echo $fields1[$k]->id?>" type="text" class="form-control" id="inputSuccess" style =" border: solid 0.1px #e0e0d1;">          
                                                    </div>
                                                </div>
                    <?php                         
                                        }
                    ?>                  </div>
                                        <div style="clear:both"></div>

                                    <div><button name="submit" class="btn-submit btn-danger btn-lg" type="submit">GỬI ĐƠN</button></div>
                                </div>
                                
                    <?php
                            }
                        }x
                    ?>
                    </form> 
                    <?php 
                        $totalIdField = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_form_submit_field`" ); 
                        $totalIDform = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_form_submit`" ); 
                        $today = date("Y-m-d");
                        $stt = 1;
                        foreach ($fields as $fld){
                            $inputContent = $_POST["$fld->id"];
                            if(($fld->status == 1) && ($inputContent != "") && ($stt == 1)){
                                $totalIDform ++;
                                $wpdb->query("INSERT INTO wp_form_submit (id, form_id) VALUES ('$totalIDform','$fld->formid')");
                                $stt ++;                        
                            }

                            if(($fld->status == 1) && ($inputContent != "")){
                                $totalIdField++;  
                                $wpdb->query("INSERT INTO wp_form_submit_field (id, field_id, form_submit_id,content,date_create) VALUES ('$totalIdField','$fld->id','$totalIDform','$inputContent', '$today')");
                            }
                        }


                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    get_footer(); 
?>
</html>

