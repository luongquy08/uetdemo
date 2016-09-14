<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Survey question</title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css_uet/style_question.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/bootstrap_uet/css/bootstrap.min.css" />
</head>
<style type="text/css">

</style>
<?php
/**
 * Template Name: surveyquestion page
 */

get_header(); 
?>

<body>
	<div class="container">
		<div class="row">
		<h1>Câu Hỏi Khảo Sát</h1>
			<div class="content" border="1">
				<form method="post">
				<?php $stt =1 ?>
			  	<?php
					global $wpdb;
						$answer = $wpdb->get_results( "SELECT * FROM wp_answer");
					    $result = $wpdb->get_results ( "SELECT * FROM wp_surveyquestion" );
					foreach ( $result as $print ){
				?>
						
						<?php	
							if(($print->status == 1)){ 
							
			   			?>		<div class="panel panel-info" name="question[]" id="<?php echo $print->id ?>">
					   				<div class="panel-heading" ><strong>Câu<?php echo $stt?> : </strong><?php echo $print->contentquestion; ?></div>
					   			<?php
									foreach ( $answer as $ans ){
										if($ans->surveyquestionid == $print->id){
										?>
										<div class="panel-body" >
						    				<label class="checkbox-inline">
						    					<input type="checkbox" name="answer[]" id="<?php echo $ans->id?>"><?= $ans->answer; ?>						    					
						    				</label>
							    		</div>
							    <?php 
							    		}
							    	}
							    ?>
							    </div>
							<?php
					   		}
				   			else
			   					continue;
				   			?>
				   			<br/>
							<hr/>
						   	<br/>
		   			<?php
		   				$stt ++;				   					
			   		}
			   		?>					
						<button name="btn_submit" class="btn-submit btn-primary btn-lg" type="submit">Submit</button>
					</form>
			</div>
		</div>
	</div>
</body>
	<?php 
	get_footer(); 
	?>
</html>