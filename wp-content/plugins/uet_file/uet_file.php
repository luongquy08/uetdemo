<?php

/**
 * Created by SublineText.
 * User: Vuongdz
 * Date: 8/12/2016
 * Time: 12:05 AM
 * Plugin Name: UET File Manager
wp_re
 * Author URI:
 * Description: Đây là Plugin Quản lý file dành riêng cho Đại học Công nghệ
 * Tags: UET
 * Version: 1.4
 */
header("Content-type: text/html; charset=utf-8"); 
global $uet_db_version;
$uet_db_version = '1.0';

add_action('plugins_loaded', 'file_uet');
add_action('plugins_loaded', 'create_file_table');

wp_register_script('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js');
wp_enqueue_script('prefix_bootstrap');

wp_register_style('prefix_bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css');
wp_enqueue_style('prefix_bootstrap');

wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('prefix_jquery');

function create_file_table()
{
    global $wpdb;
    global $uet_db_version;

    $table_name = $wpdb->prefix . 'file';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name(
                  id INT(8) NOT NULL AUTO_INCREMENT,
                  name VARCHAR(50) NOT NULL,
                  linkfile text NOT NULL,
                  status INT(8) NOT NULL DEFAULT 1,
                  UNIQUE KEY id(id)
                ) $charset_collate; ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('uet_db_version', $uet_db_version);
}

function file_uet(){
    add_options_page( 'UET File Manager', 'UET File Manager', 'manage_options', 'my-unique-identifierfour', 'uet_file' );
}

function vn_str_filter ($str){

       $unicode = array(

           'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',

           'd'=>'đ',

           'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',

           'i'=>'í|ì|ỉ|ĩ|ị',

           'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',

           'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',

           'y'=>'ý|ỳ|ỷ|ỹ|ỵ',

           'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

           'D'=>'Đ',

           'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

           'I'=>'Í|Ì|Ỉ|Ĩ|Ị',

           'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

           'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

           'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
       );

      foreach($unicode as $nonUnicode=>$uni){

           $str = preg_replace("/($uni)/i", $nonUnicode, $str);

      }

       return $str;

   }


function uet_file()
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    echo '<br /><div style="font-weight: bold;font-size: 16pt;font-family: Roboto, sans-serif;">Quản Lý Tệp Tin</div><br />';

    global $wpdb;

    if (isset($_GET['id'])) {
        $wpdb->query($wpdb->prepare("UPDATE wp_file SET status = 1 WHERE id = %d", $_GET['id']));
    }

    $files = $wpdb->get_results('SELECT * FROM wp_file', OBJECT);

    if (!empty($_POST['check_list'])) {
        foreach ($_POST['check_list'] as $id) {
            // echo "<br>$id was checked! ";
            $wpdb->query($wpdb->prepare("UPDATE wp_file SET status = 1 WHERE id = %d", $id));
        }
        echo '<script type="text/javascript">';
        echo 'window.location.reload(true)';
        echo '</script>';
    }
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["form_click"])) 
    {
        $file_dir =  "http://$_SERVER[HTTP_HOST]/uetdemo/wp-content/uploads/";
        $target_dir = get_home_path()."/wp-content/uploads/";
        // $filename = iconv("utf-8", "cp1258", basename($_FILES["fileContent"]["name"]));
        $filename =basename($_FILES["fileContent"]["name"]);
        $target_file = $target_dir . $filename;
        // echo $file_dir.$filename;

        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        $result = move_uploaded_file($_FILES['fileContent']['tmp_name'], $target_file);
        global $wpdb;
        if($result == 1){
        $wpdb->insert(
                    'wp_file',
                    array(
                        'name' => $_POST['namefile'],
                        'linkfile' => $file_dir.$filename,
                    ),
                    array(
                        '%s',
                        '%s',
                    )
                );
            }
         echo '<script type="text/javascript">'; 
         echo 'window.location.reload(true)';
         echo '</script>';
        // echo $upload["url"];
    }
?>


<head>  
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />
</head>

<!--<form method="post" enctype="multipart/form-data">
    <input type="file" class="form-control file" id="fileContent" name="fileContent" placeholder="Link File"/>
    <input type="submit" class="btn btn-default"  name="form_click1" value="Complete"/>
</form> -->

<form method="post" name="frm">
<button style="color:#337ab7;font-weight: bold;" type="button" class="btn btn-default btn-md" id= "btnAddFile" data-toggle="modal" data-target="#myModal" onclick="" >Thêm tệp</button>
</br>
</br>
</br>
    <table id="tblOne" class="wp-list-table widefat fixed striped pages">
        <tr style="color:#337ab7;font-size:12pt;border: solid 0.1px #f2f2f2;background-color: #fff">
            <th style="text-align: center;width: 3em;"><input style="margin-left:2px;" id="allcheckbox" type="checkbox"></th>
            <th style="width: 400px;font-weight: normal;color : #337ab7;">Tên tệp</th>
            <th style="text-align: center;font-weight: normal;color: #337ab7;">Tải tệp</th>
        </tr>
          <?php
          $stt = 0;
            foreach ($files as $file) {
          ?>
        <tr id="tr<?php echo $stt?>">
            <td style="text-align: center;"><input type="checkbox" name="check_list[]" id="checkbox<?php echo $file->id ?>"value="<?php echo $file->id ?>"></td>
            <td style="font-weight: bold;color : #337ab7;"><?= $file-> name ?></td>
            <td style="text-align: center;color : #337ab7"><a href="<?= $file-> linkfile ?>" >Download</a></td>
        </tr>
         <?php
          $stt++;
            }
         ?>
    </table>
   
</form>

</div>
    <script>
        $(window).load(function() {
            for (i = 0; i < 1000; i++) {
                if( i%2 == 0){
                  $("#tr" + i).css('background-color', '#f2f2f2');
                }
                else{
                  $("#tr" + i).css('background-color', '#fff');
                }
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
        $('#tblOne > tbody  > tr').each(function() {
            if (this.id % 2 != 0 ) {
              this.css("background-color", "#f2f2f2");
            }
        });
    </script>

 <!-- Trigger the modal with a button -->
    
    <!-- Modal Add File-->
    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" accept-charset="utf-8" >
                  <div class="modal-header">
                    <h2>Thêm tệp</h2>
                    <input type="text" class="form-control answerip" name="namefile" id="fileName" placeholder="Tên tệp"/>
                    </br>
                  </div>
                  <div class="modal-body">
                    <label id="anslb">Tệp tin tải lên</label>
                    <input type="file" class="form-control file" id="fileContent" name="fileContent" placeholder="Link File"/>
                    <br/>  
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-default"  name="form_click" value="Complete"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeandDelete()">Đóng</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Trigger the modal with a button -->
<?php

    
}