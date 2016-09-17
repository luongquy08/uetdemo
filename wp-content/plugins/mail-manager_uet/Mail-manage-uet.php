<?php
/*
* Plugin Name:  UET Mail Manage
* Author: Luong Van Quy
* Author URI:
* Decription: day la plugin tao nhom mail cho website dai hoc cong nghe
* Tags: UET
* Version: 1.5
*/
add_action('plugins_loaded', 'create_table_mail');
add_action('plugins_loaded', 'add_option_mail_uet');
wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
wp_enqueue_script('prefix_bootstrap');
wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
wp_enqueue_style('prefix_bootstrap');
wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('prefix_jquery');
// Doan code nay dung de tao bang mail va group
function create_table_mail(){
    global $wpdb;
    $table_name_mail_uet = $wpdb->prefix.'mail_uet';
    $table_name_group_mail_uet = $wpdb->prefix.'mail_group_uet';
    $table_relation = $wpdb->prefix.'mail_relation_uet';
    $sql = "CREATE TABLE $table_name_mail_uet(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  name VARCHAR(50) NOT NULL,
                  email VARCHAR(50) NOT NULL,
                  UNIQUE KEY id(id)
            )";
    $sql2 = "CREATE TABLE $table_name_group_mail_uet(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  name VARCHAR(50) NOT NULL,
                  UNIQUE KEY id(id)
              )";
    $sql3 = "CREATE TABLE $table_relation(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  mail_id INT(8) NOT NULL,
                  group_id INT(8) NOT NULL,
                  UNIQUE KEY id(id)
              )";
    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    dbDelta($sql2);
    dbDelta($sql3);
}
//Ket thuc doan code tao bang
//Doan code nay dung de add option
function add_option_mail_uet(){
    add_options_page('UET Mail', 'UET Mail', 'manage_options', 'my-unique-identifier-two', 'uet_mail');
}
function uet_mail()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page'));
    }
    echo '<div class="mail_duong" style="font-weight: bold;font-size: 16pt;font-family: Roboto, sans-serif;">Quản lý mail</div><br>';
    ?>

    <style>
        .mail_vuong{
            font-size: 11pt;
            line-height: 30px;
            vertical-align: middle;
            font-weight: bold;
        }
        .mail_duong{
            color: black;
            font-weight: bold;
            font-size: 16pt;
            margin-bottom: 10px;
            margin-top: 15px;
            text-transform: capitalize;
        }
        .mail_tai{
            list-style: disc;
        }
    </style>
    <!--Doan code nay dung de hien thi thong tin group mail-->
    <form method="post" name="frm">
        <table class="wp-list-table widefat fixed striped pages" style="width: 99%; ">
            <?php global $wpdb; $stt = 1;?>
            <?php $result_group = $wpdb->get_results('SELECT * FROM wp_mail_group_uet', OBJECT)?>

            <button type="button" style="color:#337ab7;font-weight: bold; " class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#AddGroupModal" onclick="">Thêm nhóm</button>&nbsp;
            <button type="button" style="color:#337ab7;font-weight: bold; " class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#AddMailModal" onclick="" >Thêm mail</button>&nbsp;
            <button type="button" style="color:#337ab7;font-weight: bold; " class="btn btn-default btn-md" id= "btnAddQuestion" data-toggle="modal" data-target="#SendMailModal" onclick="" >Gửi mail</button>
            <br/><br/>
            <tr style="font-size:12pt;border: solid 0.1px #f2f2f2;background-color: #fff">
                <th style="text-align: center;width: 3em;"><input style="margin-left:2px;" id="allcheckbox" type="checkbox"></th>
                <th style="text-align: left;color:#337ab7;">Nhóm</th>
                <th style="text-align: left;color:#337ab7;">Tác vụ</th>
            </tr>
            <?php $count = 0;
            foreach($result_group as $value_group){
                $result_mail_id = $wpdb->get_results("SELECT * FROM wp_mail_relation_uet WHERE group_id=$value_group->id", OBJECT);
                if($count % 2 != 0){
                    echo '<tr class="mail_vuong" style="cursor: pointer; color: #337ab7; ">';
                }
                else{
                    echo '<tr class="mail_vuong" style="cursor: pointer; color: #337ab7; background-color: #f2f2f2">';
                }
                ?>
                    <td style="text-align: left;"><input type="checkbox" name="check_list[]" id="checkbox<?php echo $value_group->id ?>" value="<?php echo $value_group->id ?>"></td>
                    <td style="cursor: pointer;text-align: left;color:#337ab7;font-weight:bold;" onclick="showMail(<?= $value_group->id; ?>)"><?= $value_group->name ?></td>
                    <td style="text-align: left;color:#337ab7;"><button style="font-weight:bold;" class="btn btn-danger" value="<?= $value_group->id; ?>" name="btn_delete_group">Xóa</button></td>
                </tr>

    <!--Doan code nay dung de hien thi thong tin mail thuoc cac group khi click vao-->
                 <tr id="id_mail<?= $value_group->id ?>" class="cl_mail" style="background-color:#f9f9f9">
                    <td></td>
                    <td>
                        <div  style="float:left; width: 50%; margin-left:40%;">
                    <?php foreach($result_mail_id as $value_mail_id){ ?>
                        <?php $result_mail = $wpdb->get_results("SELECT * FROM wp_mail_uet WHERE id=$value_mail_id->mail_id") ?>

                         <?php foreach($result_mail as $value_email)
                             {
                                 ?>
                                 <li style="color:#337ab7;font-weight:bold;"class="mail_tai"><?= $value_email->name ?> : <?= $value_email->email ?></li>
                                 <?php
                             }
                         ?>

                    <?php } ?>
                        </div>
                    </td>
                    <td></td>
                 </tr>

            <?php $stt++; $count ++;} ?>
        </table>

    </form>
    <script>
        function showMail(mid){
            $("#id_mail" + mid).fadeToggle('slow');
        }
        $(window).load(function() {
            $(".cl_mail").css("display", "none");
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


    <!--Day la doan code hien thi modal cua add group mail-->
    <div id="AddGroupModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="POST" style="font-family:'Roboto', sans-serif;margin-left: 25px;margin-right: 25px;height:20%">
                    <div style="font-size:13pt;font-weight: bold; text-align: center;color:#337ab7;margin-top:10px">Thêm nhóm mail</div>
                    <div class="modal-body">
                        <label style="color:#337ab7;font-weight:normal">Tên nhóm</label><br>
                        <input style="font-weight:bold;width:100% ;border-radius:4px;" type="text" name="name_group_add">
                    </div>
                    <input type="submit" style="color:#337ab7;font-weight:bold;margin-left: 68%" class="btn btn-default"  name="btn_add_group" value="Thêm"/>
                    <button type="button" style="color:#337ab7;font-weight:bold;float:right;margin-right:21px" class="btn btn-default" data-dismiss="modal" onclick="">Đóng</button>
                </form>
            </div>
        </div>
    </div>

    <!--Doan code nay dung de hien thi modal cua Add Mail-->
    <?php
    global $wpdb;
    $result = $wpdb->get_results('SELECT * FROM wp_mail_group_uet', OBJECT);
    ?>
    <div id="AddMailModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="add_mail_form_id" style="font-family:'Roboto', sans-serif;margin-left: 25px;margin-right: 25px;">
                    <div style="font-size:13pt;font-weight: bold; text-align: center;color:#337ab7;margin-top:10px">Thêm Email</div>
                    <div class="modal-body">
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Tên sinh viên</label></td>
                            <td><input style="font-weight:bold;width:100% ;border-radius:4px;" type="text" name="name_mail_add">
                        </div>
                        <br>
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Địa chỉ email</label></td>
                            <td><input style="font-weight:bold;width:100% ;border-radius:4px;" type="text" name="mail_add"></td>
                        </div>
                        <br>
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Chọn nhóm</label></td><br>
                            <td>
                                <?php $result_group_2 = $wpdb->get_results('SELECT * FROM wp_mail_group_uet', OBJECT); ?>
                                <?php foreach($result_group_2 as $value_group_2){ ?>
                                    <input type="checkbox" name="option_group_id[]" value="<?= $value_group_2->id; ?>"> <?= $value_group_2->name; ?>
                                    <br>
                                <?php } ?>
                            </td>
                        </div>
                    </div>
                    <hr/>
                    <input type="submit" style="color:#337ab7;font-weight:bold;margin-left: 68%" class="btn btn-default"  name="btn_add_mail" value="Thêm"/>
                    <button type="button" style="color:#337ab7;font-weight:bold;float:right;margin-right:21px" class="btn btn-default" data-dismiss="modal" onclick="">Đóng</button>
                </form>
            </div>
        </div>
    </div>


    <!--Doan code nay dung de hien thi modal cua Send Mail-->
    <div id="SendMailModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="add_mail_form_id" style="font-family:'Roboto', sans-serif;margin-left: 25px;margin-right: 25px;">
                    <div style="font-size:13pt;font-weight: bold; text-align: center;color:#337ab7;margin-top:10px">Gửi Email</div>
                    <div class="modal-body">
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Tiêu đề</label></td>
                            <td><input style="font-weight:bold;width:100% ;border-radius:4px;" type="text" name="send_mail_title"></td>
                        </div><br>
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Nội dung</label></td>
                            <td><textarea style="font-weight:bold;width:100% ;border-radius:4px;" type="text" name="send_mail_content"></textarea></td>
                        </div><br>
                        <div>
                            <td><label style="color:#337ab7;font-weight:normal">Chọn nhóm</label></td><br>
                            <td>
                                <select name="send_option_group" style="font-weight:bold; border-radius:4px;width:250px;">
                                    <?php foreach($result as $value){ ?>
                                        <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" style="color:#337ab7;font-weight:bold;" class="btn btn-default"  name="btn_send_mail" value="Hoàn thành"/>
                        <button type="button" style="color:#337ab7;font-weight:bold;"  class="btn btn-default" data-dismiss="modal" onclick="">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Doan code nay dung de xu ly Add Group Mail-->
    <?php
    //echo '<script>alert('.(isset($_POST['btn_add_group'])==true).');</script>';
    if(isset($_POST['btn_add_group'])){
        $name_group = $_POST['name_group_add'];
        $wpdb->insert(
            'wp_mail_group_uet',
            array(
                'name'=>$name_group
            ),
            array(
                '%s'
            )
        );
        echo '<script type="text/javascript">';
        echo 'window.location.reload(true)';
        echo '</script>';
    }
    ?>

    <!--Doan code nay dung de xu ly delete group    -->
    <?php
    if(isset($_POST['btn_delete_group'])){
        $delete_group_id = $_POST['btn_delete_group'];
        $wpdb->delete('wp_mail_group_uet', array('id'=>$delete_group_id));
        echo '<script type="text/javascript">';
        echo 'window.location.reload(true)';
        echo '</script>';
    }
    ?>

    <!--Doan code nay dung de xu ly Add Mail-->
    <?php
    if(isset($_POST['btn_add_mail'])){
        $name = $_POST['name_mail_add'];
        $mail = $_POST['mail_add'];
        $option_group_id = $_POST['option_group_id'];
        global $wpdb;
        $wpdb->insert(
            'wp_mail_uet',
            array(
                'name'=>$name,
                'email'=>$mail
            ),
            array(
                '%s',
                '%s',
            )
        );
        $result_mail_2 = $wpdb->get_results("SELECT * FROM wp_mail_uet", OBJECT);
        $mail_id = 0;
        foreach($result_mail_2 as $value_mail_2){
            if($value_mail_2->email == $mail){
                $GLOBALS['mail_id'] = $value_mail_2->id;
            }
        }
        for($i = 0; $i < count($option_group_id); $i++){
            $wpdb->insert(
                'wp_mail_relation_uet',
                array(
                    'mail_id'=>$GLOBALS['mail_id'],
                    'group_id'=>$option_group_id[$i]
                ),
                array(
                    '%d',
                    '%d'
                )
            );
        }
        echo '<script type="text/javascript">';
        echo 'window.location.reload(true)';
        echo '</script>';
    }
    ?>
    <!--Doan code nay dung de gui mail-->
    <?php
    if(isset($_POST['btn_send_mail'])){
        $group_id = $_POST['send_option_group'];
        $mail_send = $wpdb->get_results("SELECT * FROM wp_mail_relation_uet WHERE group_id=$group_id", OBJECT);
        /* echo '<pre>';
         print_r($mail);
         echo '</pre>';*/
        $subject = $_POST['send_mail_title'];
        $body = $_POST['send_mail_content'];
        ?>
        <?php
        require_once "Mail.php";
        ?>

        <?php
        $stringMail = "";
        foreach($mail_send as $value_send) {
            $mailSend = $wpdb->get_results("SELECT * FROM wp_mail_uet WHERE id=$value_send->mail_id", OBJECT);
            foreach ($mailSend as $valueMailSend) {
                $stringMail .= $valueMailSend->email.', ';
            }
        }
        $from = '<haha08101997@gmail.com>';
        $to = "$stringMail";
        $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
        );
        $smtp = Mail::factory('smtp', array(
            'host' => 'ssl://smtp.gmail.com',
            'port' => '465',
            'auth' => true,
            'username' => 'haha08101997@gmail.com',
            'password' => 'Dell08101997'
        ));
        $mail = $smtp->send($to, $headers, $body);
        ?>

        <?php
    }
    ?>
<?php } ?>