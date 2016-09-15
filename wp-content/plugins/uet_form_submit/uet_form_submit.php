<?php

/**
 * Created by SublineText.
 * User: Vuongdz
 * Date: 8/12/2016
 * Time: 12:05 AM
 * Plugin Name: UET Form Submit
wp_re
 * Author URI:
 * Description: Đây là Plugin form dành riêng cho Đại học Công nghệ
 * Tags: UET
 * Version: 1.4
 */

global $uet_db_version;
$uet_db_version = '1.0';

add_action('plugins_loaded', 'form_submit_uet');

// wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
// wp_enqueue_script('prefix_bootstrap');

// wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
// wp_enqueue_style('prefix_bootstrap');

// wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
// wp_enqueue_script('prefix_jquery');


function form_submit_uet(){
    add_options_page( 'UET Form Submit', 'UET Form Submit', 'manage_options', 'my-unique-identifierthree', 'uet_form_submit' );
}
function displaystatus($status){
    if($status == 1) echo "đã duyệt";
    else if($status == 0) echo "chưa duyệt";
    else echo "đang chờ duyệt";
}
function getform($id){
    global $wpdb;
    $form =  $wpdb->get_results("SELECT * FROM wp_form WHERE id = '$id' ", OBJECT);
    return $form[0];
}
function get_field($formid){
    global $wpdb;
    $fields =  $wpdb->get_results("SELECT * FROM wp_field WHERE formid = '$formid' ", OBJECT);
    return $fields;   
}
function get_field_submit($fieldId,$formSubmitId){
    global $wpdb;
    $fieldSubmit =  $wpdb->get_results("SELECT * FROM wp_form_submit_field WHERE form_submit_id = '$formSubmitId' AND field_id = '$fieldId' ", OBJECT);
    return $fieldSubmit[0]; 
}
function uet_form_submit()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
   

    global $wpdb;

    if (isset($_GET['id'])) {
        $wpdb->query($wpdb->prepare("UPDATE wp_form_submit SET status = 1 WHERE id = %d", $_GET['id']));
    }

    //$form_submits = $wpdb->get_results('SELECT * FROM wp_form_submit', OBJECT);

    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $id) {
            // echo "<br>$id was checked! ";
            $wpdb->query($wpdb->prepare("UPDATE wp_form_submit SET status = 1 WHERE id = %d", $id));
        }
        echo '<script type="text/javascript">';
        echo 'window.location.reload(true)';
        echo '</script>';
    }
?>


<head>  
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
</head>
<div style="font-weight: bold;font-size:16pt;font-family: 'Roboto', sans-serif;">
            Quản Lý Đơn Kiến Nghị Từ Sinh Viên
        </div>
        <br/>
        
<form method="post" name="frm">
<button class="btn btn-default btn-md" style="color:#337ab7;font-weight: bold;" type="submit" name="Submit" id="reload">Duyệt đơn</button><br/>
</br>
</br>
<?php
         // code phan trang 
        $pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
        $limit = 3; // number of rows in page           
        $offset = ( $pagenum - 1 ) * $limit; 
        $total = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_form_submit`" );
        $num_of_pages = ceil( $total / $limit );
        $form_submits = $wpdb->get_results( "SELECT * FROM wp_form_submit LIMIT $offset, $limit" );

           
    ?>
    <table class="wp-list-table widefat fixed striped pages"  style="width:99%; font-weight:bold">
            <tr style="color:#337ab7;font-size:12pt;border: solid 0.1px #f2f2f2;background-color: #fff">
                <th style="text-align: center;width: 3em;"><input id="allcheckbox" type="checkbox" style="margin-left: 2px;"></th>
                <th style="width:400px;font-weight: normal;color : #337ab7">Tên đơn</th>
                <th style="text-align: center;font-weight: normal;color : #337ab7">Mã số sinh viên</th>
                <th style="text-align: center;font-weight: normal;color : #337ab7">Trạng thái</th>
                <th style="text-align: center;font-weight: normal;color : #337ab7">Chức năng</th>
            </tr>
        <?php
        $stt = 1;
        foreach($form_submits as $form_submit){
            $form = getform($form_submit-> form_id);
            $fields = get_field($form_submit-> form_id); 
            $field_submit_mssv = get_field_submit($fields[1]-> id,$form_submit-> id);

            ?>

            <tr id="stt<?php echo $stt?>" style="cursor: pointer; color: #337ab7;">
                <td style="text-align:center;"><input type="checkbox" name="check_list[]" id= "checkbox<?php echo $form_submit->id?>" value= "<?php echo $form_submit->id?>" ></td>
                <td style="font-weight:bold;color : #337ab7" onclick="showField('<?php echo $form_submit->id?>')"><?= $form-> formName?></td>
                <td style="text-align: center;color : #337ab7" onclick="showField('<?php echo $form_submit->id?>')"><?= $field_submit_mssv -> content?></td>
                <td style="text-align: center;color : #337ab7" onclick="showField('<?php echo $form_submit->id?>')"><?= displaystatus($form_submit-> status) ?></td>
                <td style="text-align: center;"><a style="color: #337ab7;font-weight: bold;background-color: #fff;" class="btn btn-info btn-md" href="<?= "?page=my-unique-identifierthree&id=$form_submit->id" ?>" >Duyệt đơn</a></td>
            </tr>

            <tr id="field<?php echo $form_submit->id?>" class="field">
                <td colspan="5" style="background-color:#f9f9f9">
                     <div  style="float:left; width: 57.5%; margin-left:10%;">
                     <?php
                        $length =  count($fields);
                        $k = 0;
                        for ($i=0; $i < $length/2 ; $i++) {  
                            $field_submit = get_field_submit($fields[$i]-> id,$form_submit-> id);
                    ?>  
                             <li> 
                            <label style="width:300px;color:#337ab7;font-weight: bold;" id="<?php echo $fields[$i]-> id?>"> <?= $fields[$i]-> content?> : <?= $field_submit-> content?></label>
                            </li>
                    <?php
                    $k ++;
                    }
                    echo'</div>';
                    echo'<div style="float:left;">';
                    for ($i= $k; $i < $length ; $i++) { 
                        $field_submit = get_field_submit($fields[$i]-> id,$form_submit-> id);
                    ?>
                        <li> 
                        <label style="width:300px;color:#337ab7;font-weight: bold;" id="<?php echo $fields[$i]-> id?>"> <?= $fields[$i]-> content?> : <?= $field_submit-> content?></label>
                        </li>
                    <?php
                     }
                    ?>
                </td>
            </tr>
            
        <?php
            $stt++;
        }?>
    </table>
    <!-- <div style="float:left;margin-left:2px;"> -->
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
            echo '<div class="pagination" style="float:right; margin-right:75px;"><li>'. $page_links .'</li></div>';
        }
    ?>
</form>

</div>
    <script>
        function showField(fid){
            $("#field" + fid).fadeToggle('slow');
        }
        $(window).load(function() {
            $(".field").css("display", "none");
            for (i = 1; i < 1000; i+=2) {
                $("#stt" + i).css('background-color', '#f2f2f2');
            }
        });
        $("#allcheckbox").change(function() {
            if(this.checked) {
                $(":checkbox").prop('checked', true);
            }
            else{
                $(":checkbox").prop('checked', false);   
            }
        });
    </script>
    <!-- Trigger the modal with a button -->
  
<?php

    

}