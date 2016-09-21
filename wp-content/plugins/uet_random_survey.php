<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 21/09/2016
 * Time: 9:17 SA
 * Plugin Name: UET Random Survey
 * Author: Luong Quy
 * Author URI:
 * Description: Day la plugin random survey question danh rieng cho Dai hoc Cong nghe
 * Tags: UET
 * Version: 1.0
 */

/*
 * Khoi tao Widget item
 */

add_action( 'widgets_init', 'create_uet_random_survey_widget' );
function create_uet_random_survey_widget() {
    register_widget('Uet_Random_Survey_Question_Widget');
}

/**
 * T?o class Uet_Random_Survey_Question_Widget
 */
class Uet_Random_Survey_Question_Widget extends WP_Widget {
    /**
     * Thi?t l?p widget: đ?t tên, base ID
     */
    function __construct() {
        parent::__construct (
            'uet_random_widget', // id c?a widget
            'Cau hoi khao sat', // tên c?a widget

            array(
                'description' => 'Tá»± Ä‘á»™ng random cĂ¢u há»�i kháº£o sĂ¡t' // mô t?
            )
        );
    }

    /**
     * T?o form option cho widget
     */
    function form( $instance )
    {
        //Bi?n t?o các giá tr? m?c đ?nh trong form
        $default = array(
            'title' => 'Cau hoi khao sat'
        );
        //G?p các giá tr? trong m?ng $default vào bi?n $instance đ? nó tr? thành các giá tr? m?c đ?nh
        $instance = wp_parse_args((array)$instance, $default);
        //T?o bi?n riêng cho giá tr? m?c đ?nh trong m?ng $default
        $title = esc_attr($instance['title']);
        //Hi?n th? form trong option c?a widget
        ?>
        Nháº­p tiĂªu Ä‘á»� <input class="widefat" type="text" name="<?= $this->get_field_name('title'); ?>"
                            value="<?= $title; ?>"/>

        <?php
    }

    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Show widget
     */

    function widget( $args, $instance )
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $outputHTML = '';
        $outputHTML .= $args['before_widget'];

        //In tiêu đ? widget
        echo $outputHTML .= $args['before_title'] . $title . $args['after_title'];

        // Noi dung trong widget

        ?>

        <div class="content" border="1">
				<?php
					global $wpdb;
						$answer = $wpdb->get_results( "SELECT * FROM wp_answer");
						$questions = $wpdb->get_results( "SELECT * FROM wp_surveyquestion WHERE status=1 ORDER BY RAND()  LIMIT 1", OBJECT );

				 ?>
				<form id="formTotal" method="post" name="frm">
				<?php
						$today = date("Y-m-d");
						$startTime = $questions[0]->startTime; //from db
						$endTime = $questions[0]->endTime;

						$today_time = strtotime($today);
						$start_time = strtotime($startTime);
						$end_time = strtotime($endTime);

						if(($questions[0]->status == 1) && ($start_time < $today_time) && ($end_time > $today_time)){
                            if($questions[0]->type == 1){
				   	?>
				   				<div>
						   			<div><strong>Câu : </strong><?php echo $questions[0]->contentquestion; ?></div>
						   			<?php
						   				foreach ($answer as $ans ){
											if(($ans->surveyquestionid == $questions[0]->id) && ($ans->status == 1)){
									?>
						    					<div class="">
							    					<input type="radio" name="singleAnswer<?= $questions[0]->id?>[]" value="<?php echo $ans->id?>"><?php echo" "; echo $ans->answer; ?>
												</div>
					<?php
									    	}
									    }
								echo '</div>';
                                }else{


				   	?>
				   				<div>
						   			<div><strong>CĂ¢u: </strong><?php echo $questions[0]->contentquestion; ?></div>
						   			<?php
						   				foreach ( $answer as $ans ){
											if(($ans->surveyquestionid == $questions[0]->id) && ($ans->status == 1)){
									?>
												<div>
								    				<label class="checkbox-inline">
								    					<input type="checkbox" name="multipleAnswer[]" id="<?php echo $questions[0]->id?>" value="<?php echo $ans->id?>"><?php echo $ans->answer; ?>
								    				</label>
									    		</div>
					<?php
							    			}
							    		}
								echo'</div>';
                                }
							}
		   				echo '<br/>';echo'<hr/>';echo'<br/>';

			   	?>
						<button name="submit" type="submit">Hoàn thành</button>
					</form>
				<?php


					$allAnswer = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_survey_submit_answer`" );  // t?ng s? câu h?i đ? lưu
					$allQuestion = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_survey_submit`" );			// tông s? câu tr? l?i đ? lưu

					// lưu multiple answer
					if (!empty($_POST['multipleAnswer'])) {
						foreach ($_POST['multipleAnswer'] as $id) {
							foreach($answer as $key){
								if($key->id == $id){
									$allAnswer++;
									$wpdb->query("INSERT INTO wp_survey_submit_answer (id, answer_id, survey_submit_id) VALUES ('$allAnswer','$id','$key->surveyquestionid')");
									foreach($questions[0] as $questions[0]){
										if(($questions[0]->id == $key->surveyquestionid)) {
											$allQuestion++;
											$wpdb->query("INSERT INTO wp_survey_submit (id, survey_question_id) VALUES ('$allQuestion','$questions[0]->id')");
										}
									}
								}
							}
						}
					}

					// lưu single answer
					foreach ($questions[0] as $questions[0]) {
						if (isset($_POST["singleAnswer{$questions[0]->id}"])) {
							foreach ($_POST["singleAnswer{$questions[0]->id}"] as $id) {
								foreach($answer as $key){
									if($key->id == $id){
										$allAnswer++;
										$wpdb->query("INSERT INTO wp_survey_submit_answer (id, answer_id, survey_submit_id) VALUES ('$allAnswer','$id','$key->surveyquestionid')");
										foreach($questions[0] as $questions[0]){
											if($questions[0]->id == $key->surveyquestionid){
												$allQuestion++;
												$test = $wpdb->query("INSERT INTO wp_survey_submit (id, survey_question_id) VALUES ('$allQuestion','$questions[0]->id')");
												/*echo $test;
												die('dung');*/
											}
										}
									}
								}
							}
						}
					}

				?>
			</div>
		</div>

        <?php

        $outputHTML .= $args['after_widget'];

    }
}
?>