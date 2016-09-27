<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Contact Form Template</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_form.css" />
</head>                                                                                                                                                                                                                          
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
    ?>
    <div class="contact-body">    
        <div class="contact-container">
            <div class="content" border="1">
                <form method="post">
                    <div class="form-group ">
                        <label class="lbl-select" for="sel1">Mời bạn chọn đơn(chỉ được chọn một) : </label></br/>
                            <?php 
                            foreach ($forms as $frm) {
                                $today = date("Y-m-d");
                                $startTime = $frm->startTime; //from db
                                $endTime = $frm->endTime;
                                
                                $today_time = strtotime($today);
                                $start_time = strtotime($startTime);
                                $end_time = strtotime($endTime);
                                if($frm->status == 1){      
                            ?>
                                <ul>
                                    <li>
                                        <a href="uetdemo/nhap-truong-don-tu?id=<?php echo $frm->id;?>"><?php echo" "; echo $frm->formName; ?></a>
                                    </li>
                                </ul>
                                    
                            <?php      
                                }  
                            }
                            ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<?php 
    get_footer(); 
?>
</html>
