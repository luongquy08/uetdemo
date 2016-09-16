<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey question</title>
  <!--   <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_question.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" /> -->
</head>
<!-- <style type="text/css">

</style> -->
<?php
/**
 * Template Name: surveyquestion page
 */

get_header(); 
?>

<body>
	<div class="container">
		<div class="row">
		<h1 class="h1">Câu Hỏi Khảo Sát</h1>
			<div class="content" border="1">
				<?php 
					global $wpdb;
						$answer = $wpdb->get_results( "SELECT * FROM wp_answer");
						$questions = $wpdb->get_results ( "SELECT * FROM wp_surveyquestion" );
				 ?>
				<form id="formTotal" method="post" name="frm">
				<?php $stt =1;	    
					foreach($questions as $ques)
					{	

						$today = date("Y-m-d");
						$startTime = $ques->startTime; //from db
						$endTime = $ques->endTime;

						$today_time = strtotime($today);
						$start_time = strtotime($startTime);
						$end_time = strtotime($endTime);

						if(($ques->status == 1) && ($start_time < $today_time) && ($end_time > $today_time)){ 
							
								if($ques->type == 1){
									
				   	?>	
				   				<div class="panel panel-primary">
						   			<div class="panel-heading" ><strong>Câu<?php echo $stt?> : </strong><?php echo $ques->contentquestion; ?></div>
						   			<?php 	
						   				foreach ($answer as $ans ){
											if(($ans->surveyquestionid == $ques->id) && ($ans->status == 1)){
									?>					
						    					<div class="panel-body">
							    					<input type="radio" name="singleAnswer<?= $ques->id?>[]" value="<?php echo $ans->id?>"><?php echo" "; echo $ans->answer; ?>
												</div>
					<?php 			
									    	}	
									    }
								echo'</div>';
								}

								else{
				   	?>	
				   				<div class="panel panel-primary">
						   			<div class="panel-heading"><strong>Câu<?php echo $stt?> : </strong><?php echo $ques->contentquestion; ?></div>
						   			<?php 	
						   				foreach ( $answer as $ans ){
											if(($ans->surveyquestionid == $ques->id) && ($ans->status == 1)){
									?>
												<div class="panel-body" >
								    				<label class="checkbox-inline">
								    					<input type="checkbox" name="multipleAnswer[]" id="<?php echo $ques->id?>" value="<?php echo $ans->id?>"><?php echo $ans->answer; ?>						    					
								    				</label>
									    		</div>
					<?php 			
							    			}	
							    		}
								echo'</div>';
								}
							}

			   			else{
		   					continue;
		   				}
		   				echo '<br/>';echo'<hr/>';echo'<br/>';
		   				$stt ++;				   					
			   		}
			   	?>					
						<button name="submit" class="btn-submit btn-danger btn-lg" type="submit">Submit</button>
					</form>
				<?php 

					
					$allAnswer = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_survey_submit_answer`" );  // tổng số câu hỏi đã lưu
					$allQuestion = $wpdb->get_var( "SELECT COUNT(`id`) FROM `wp_survey_submit`" );			// tông số câu trả lời đã lưu

					// lưu multiple answer
					if (!empty($_POST['multipleAnswer'])) {
						foreach ($_POST['multipleAnswer'] as $id) {
							foreach($answer as $key){
								if($key->id == $id){
									$allAnswer++;
									$wpdb->query("INSERT INTO wp_survey_submit_answer (id, answer_id, survey_submit_id) VALUES ('$allAnswer','$id','$key->surveyquestionid')");
									foreach($questions as $question){
										if(($question->id == $key->surveyquestionid)) {
											$allQuestion++;
											$wpdb->query("INSERT INTO wp_survey_submit (id, survey_question_id) VALUES ('$allQuestion','$question->id')");
										}
									}
								}	
							}
						}
					}

					// lưu single answer
					foreach ($questions as $ques) {
						if (isset($_POST["singleAnswer{$ques->id}"])) {
							foreach ($_POST["singleAnswer{$ques->id}"] as $id) {
								foreach($answer as $key){
									if($key->id == $id){
										$allAnswer++;
										$wpdb->query("INSERT INTO wp_survey_submit_answer (id, answer_id, survey_submit_id) VALUES ('$allAnswer','$id','$key->surveyquestionid')");
										foreach($questions as $question){
											if($question->id == $key->surveyquestionid){
												$allQuestion++;
												$wpdb->query("INSERT INTO wp_survey_submit (id, survey_question_id) VALUES ('$allQuestiont','$question->id')");
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
	</div>
	<script type="text/javascript">
		$('#formTotal').submit(function() {
			alert("Chúc mừng bạn đã hoàn thành bài thi thử !!!");
			// body...
		});
	</script>
</body>
	<?php 
	get_footer(); 
	?>
</html>