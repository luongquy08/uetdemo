<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Contact Form Template</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_contact.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
</head>
<style type="text/css"></style>
<?php
/**
 * Template Name: page test redirect
 */

get_header(); 
?>

<body>
    <?php
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM wp_posts", OBJECT);
    foreach($result as $value):
        /*echo '<pre>';
        print_r($value);
        echo '</pre>';*/
        $field = get_field('enter', $value->ID);
        if(!empty($field)){
        ?>
            <a href="<?php echo $field ?>"><?= $value->post_title; ?></a>
        <?php } ?>
    <?php endforeach; ?>

</body>
<?php 
    get_footer(); 
    ?>
</html>
