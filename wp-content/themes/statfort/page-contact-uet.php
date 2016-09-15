<!DOCTYPE html><html><head>    <meta charset="utf-8">    <meta http-equiv="X-UA-Compatible" content="IE=edge">    <meta name="viewport" content="width=device-width, initial-scale=1">    <title>Bootstrap Contact Form Template</title><!--     <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_contact.css" />    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" /> --></head><<!-- style type="text/css"></style> --><?php/** * Template Name: contact page */get_header(); ?><body >    <div class="contact-body">            <div class="contact-container">            <div class="row">            <div class="contact-map">                <iframe style="width:35%;height:500px; float:left; margin-left:5%;margin-top:20px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.859431322984!2d105.78029505088448!3d21.038309785924447!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab354920c233%3A0x5d0313a3bfdc4f37!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgxJBIUUcgSMOgIE7hu5lp!5e0!3m2!1svi!2s!4v1473050609010" frameborder="0" style="border:0" allowfullscreen></iframe>            </div>            <div class="form-box"  style="width:50%; float:right;margin-right:5%">                <div class="contact-form-top">                    <div class="contact-form-top-left">                        <h3 class="contact-us" style="font-family: 'Roboto', sans-serif;">Liên hệ với chúng tôi</h3>                        <p>Điền thông tin vào các trường dưới đây</p>                    </div>                    <div class="contact-form-top-right">                        <i class="fa fa-envelope"></i>                    </div>                </div>                                 <div class="contact-form-bottom contact-form">                    <?php echo '<form action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '" method="post">';?>                        <form  id="input-content"role="form"  method="post">                            <div class="form-group">                                <?php                                    echo '<input type="text" style= "font-size: 13px;border-radius: 2px;" name="cf-name" placeholder="Họ tên..." pattern="[a-zA-Z0-9 ]+" value="' . ( isset( $_POST["cf-name"] ) ? esc_attr( $_POST["cf-name"] ) : '' ) . '" size="62" />';                                ?>                            </div>                            <div class="form-group">                                <?php                                     echo '<input type="email" style= "font-size: 13px;border-radius: 2px;" placeholder="Địa chỉ email..." name="cf-email" value="' . ( isset( $_POST["cf-email"] ) ? esc_attr( $_POST["cf-email"] ) : '' ) . '" size="62" />';                                 ?>                            </div>                            <div class="form-group" id="form-control">                                <?php                                     echo '<textarea rows="6" style= "font-size: 13px;border-radius: 2px;text-transform: none;" cols="35" placeholder="Nội dung thư..." name="cf-message">' . ( isset( $_POST["cf-message"] ) ? esc_attr( $_POST["cf-message"] ) : '' ) . '</textarea>';                                 ?>                            </div>                            <button name="submit" type="submit" class="contact-btn btn-primary">Gửi thư</button>                        </form>                    <?php                         echo '</form>';                    ?>                    <?php                         if($_SERVER['REQUEST_METHOD'] == 'POST'){                            global $wpdb;                            $name = $_POST['cf-name'];                            $email = $_POST['cf-email'];                            $content = $_POST['cf-message'];                            $wpdb->insert(                                'wp_contact',                                array(                                    'name' => $name,                                    'email' => $email,                                    'content' => $content                                ),                                array(                                    '%s',                                    '%s',                                    '%s'                                )                            );                        }                    ?>                </div>            </div>            </div>        </div>        <br/>        <br/>    </div>    <script type="text/javascript">        $('.contact-body').submit(function() {            alert("BẠN ĐÃ GỬI THƯ THÀNH CÔNG !!!");            // body...        });    </script></body><?php     get_footer();     ?></html>