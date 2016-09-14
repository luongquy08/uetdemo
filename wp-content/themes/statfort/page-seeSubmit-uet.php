<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Contact Form Template</title>
    <!--    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />

</head>
<style type="text/css"></style>
<?php
/**
 * Template Name: Show Submit Page
 */
wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('prefix_jquery');

get_header(); 
?>
<body >
    <?php
        global $wpdb;
            $forms = $wpdb->get_results( "SELECT * FROM wp_form");
            $fields = $wpdb->get_results ( "SELECT * FROM wp_field" );
    ?>
  <form method="post">
        <div align="center" class="form-group" style="float:left; margin-left: 40px;vertical-align: middle;line-height: 41px;"  >
            <label class="lbl-form-submit" for="sel1" style="font-weight: bold;font-size: 150%;font-family: 'Roboto Slab', serif;float:left;margin-right: 10px;">
                Nhập mã số sinh viên bạn cần tra 
            </label>
            <input type="text" style="border : solid 0.1px #e0e0d1;border-radius: 7px;width: 200px;" class="selectpicker" name="mssv" placeholder="  Mã số sinh viên">
            <input type="submit" class="btn-submit btn-success" value="Tìm kiếm" style="width: 100px; height: 40px; border-radius: 7px;font-size: 130%" />
        </div>
    <br><br><br>
        <?php  
            global $wpdb;
            $mssv = $_POST['mssv'];
            $form_submit_fields = $wpdb->get_results ( "SELECT * FROM wp_form_submit_field where content = '$mssv'",OBJECT);
        ?>

        
            <?php
                $stt = 1;
                foreach($form_submit_fields as $form_submit_field){
                    $form_submit = getformsubmit($form_submit_field-> form_submit_id);
                    $form = get_form($form_submit-> form_id);
                    $fields = getFieldFromForm($form_submit-> form_id); 
                    if($stt ==  1){
            ?>

            <table class="table" style="margin-left: 30px; margin-right: 30px;width: 94%; font-weight: bold">
                <tr style="background:#333;color: white;" >
                    <th style="text-align: center;">Số thứ tự</th>
                    <th style="text-align: center;">Tên đơn</th>
                    <th style="text-align: center;">Trạng thái</th>
                    <th style="text-align: center;">Ngày được tạo</th>
                </tr>
            <?php 
                    }
            ?>

            
                <tr style="cursor: pointer;">
                    <td style="text-align: center;" onclick="showFieldStudent('<?php echo $form_submit->id?>')"><?= $stt ?></td>
                    <td style="text-align: center;" onclick="showFieldStudent('<?php echo $form_submit->id?>')"><?= $form-> formName ?></td>
                    <td style="text-align: center;" onclick="showFieldStudent('<?php echo $form_submit->id?>')"><?= displaySubmitstatus($form_submit-> status) ?></td>
                    <td style="text-align: center;" onclick="showFieldStudent('<?php echo $form_submit->id?>')"><?= $form_submit_field-> date_create ?></td>
                </tr>

                <tr id="field<?php echo $form_submit->id?>" class="field">
                <td></td>
                <td>
                    <ol id="field<?php echo $form_submit->id?>">
                <?php 
                    for ($i=0; $i <count($fields) ; $i++) {
                    $field_submit = getfieldsubmit($fields[$i]-> id,$form_submit->id); 
                ?>
                        <li style="margin-left:50px"> 
                        <label style="width:150px;margin-left:105px;"> <?= $fields[$i]-> content ?>:</label>
                        <label style="margin-left:110px"> <?= $field_submit-> content ?> </label>
                        </li>
                <?php 
                    }
                ?>
                    </ol>
                </td>
                <td></td>
                <td></td>
            </tr>   

            <?php
                $stt++;
            }?>
            </table>  
    </form> 
    <br/>
    <br/>
    <br/>
    <br/>
</body>
<?php
    function displaySubmitstatus($status){
        if($status == 1) echo "đã duyệt";
	elseif($status == 2) echo "hủy";
        else echo "đang chờ";
    }
    function get_form($id){
        global $wpdb;
        $form =  $wpdb->get_results("SELECT * FROM wp_form WHERE id = '$id' ", OBJECT);
        return $form[0];  
    }
    function getFieldFromForm($id){
         global $wpdb;
        $field =  $wpdb->get_results("SELECT * FROM wp_field WHERE formid = '$id' ", OBJECT);
        return $field;
    }
    function getfieldStudent($id){
        global $wpdb;
        $field =  $wpdb->get_results("SELECT * FROM wp_field WHERE formid = '$id' ", OBJECT);
        return $field;
    } 
    function getfieldsubmit($id,$formsubmitid){
        global $wpdb;
        $field_submit =  $wpdb->get_results("SELECT * FROM wp_form_submit_field WHERE field_id = '$id' AND form_submit_id = '$formsubmitid'  ", OBJECT);
        return $field_submit[0];  
    }
    function getformsubmit($id){
        global $wpdb;
        $form_submit =  $wpdb->get_results("SELECT * FROM wp_form_submit WHERE id = '$id' ", OBJECT);
        return $form_submit[0];  
    }
?>
<script type="text/javascript">
    function showFieldStudent(qid){
        $("#field" + qid).fadeToggle("slow");
    }
    $(window).load(function() {
            $(".field").css("display", "none");
    });
</script>
<?php 
    get_footer(); 
?>
</html>