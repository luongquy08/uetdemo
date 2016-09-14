<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tải File</title>
    <!--    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" /> -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap-select.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/js/bootstrap.min.js" />

</head>
<style type="text/css"></style>
<?php
/**
 * Template Name: File page
 */
wp_register_script('prefix_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
wp_enqueue_script('prefix_jquery');

get_header(); 
?>
<body >
    <?php
        global $wpdb;
            $files = $wpdb->get_results( "SELECT * FROM wp_file");
    ?>
            <table class="table  table-hover">
                <tr class="info">
                    <th>stt</th>
                    <th>FileName</th>
                    <th>Link download</th>
                </tr>
            <?php
                $stt = 1;
                foreach($files as $file){
            ?>
                <tr>
                    <td ><?= $stt ?></td>
                    <td ><?= $file-> name ?></td>
                    <td ><a href="<?= $file-> linkfile ?>">Download</a></td>
                </tr>
            <?php
                $stt++;
            }?>
            </table>  
    <br/>
    <br/>
    <br/>
    <br/>
</body>

<?php 
    get_footer(); 
?>
</html>