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
    echo '<br /><div style="font-weight: bold;font-size: 16pt;font-family: Roboto, sans-serif;">Quản lý file</div><br />';

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
        $file_dir =  "http://$_SERVER[HTTP_HOST]/uet-demo/wp-content/uploads/";
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
    <table class="table  table-hover">
        <tr style="background:#23282d; color:white;font-size:14pt">
            <th><input id="allcheckbox" type="checkbox"></th>
            <th>Tên File</th>
            <th>Link File</th>
        </tr>
          <?php
            foreach ($files as $file) {
          ?>
        <tr>
            <td><input type="checkbox" name="check_list[]" id="checkbox<?php echo $file->id ?>"value="<?php echo $file->id ?>"></td>
            <td><?= $file-> name ?></td>
            <td><a href="<?= $file-> linkfile ?>" >Download</a></td>
        </tr>
         <?php
            }
         ?>
    </table>
   <button type="button" class="btn btn-info btn-md" id= "btnAddFile" data-toggle="modal" data-target="#myModal" onclick="" >Add File</button>
</form>

</div>
    <script>
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
    
    <!-- Modal Add File-->
    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" enctype="multipart/form-data" accept-charset="utf-8" >
                  <div class="modal-header">
                    <h2>Thêm File</h2>
                    <input type="text" class="form-control answerip" name="namefile" id="fileName" placeholder="FileName"/>
                    </br>
                  </div>
                  <div class="modal-body">
                    <label id="anslb">Link File</label>
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