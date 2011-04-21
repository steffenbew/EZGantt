<?php

require_once 'ezgantt.class.php';

$ezgantt = new EZGantt('EZGantt');

$milestone1 = $ezgantt->addMilestone('Category 1', '2011-02-02', '2011-05-06');
$milestone1->addTask('Test1', '2011-02-02', '2011-03-06', 'http://steffenbew.com', TRUE);
$milestone1->addTask('Test4', '2011-03-03', '2011-03-17', 'http://steffenbew.com');
$milestone1->addTask('Test6', '2011-05-02', '2011-05-06', 'http://steffenbew.com');
$milestone1->addTask('Test9', '2011-03-03', '2011-04-17', 'http://steffenbew.com');
$milestone1->addTask('Test14', '2011-03-03', '2011-03-17', 'http://steffenbew.com');

$milestone2 = $ezgantt->addMilestone('Category 2 - what should be achieved next', '2011-01-14', '2011-06-10');
$milestone2->addTask('Test5', '2011-05-15', '2011-06-14', 'http://steffenbew.com');
$milestone2->addTask('Test10', '2011-01-15', '2011-03-19', 'http://steffenbew.com', TRUE);
$milestone2->addTask('Test11', '2011-05-02', '2011-05-06', 'http://steffenbew.com');
$milestone2->addTask('Test15', '2011-01-15', '2011-06-14', 'http://steffenbew.com');

$milestone3 = $ezgantt->addMilestone('', '2011-02-04', '2011-05-20');
$milestone3->addTask('A long text for a task object', '2011-02-04', '2011-03-12', 'http://steffenbew.com', TRUE);
$milestone3->addTask('Test3', '2011-02-12', '2011-03-20', 'http://steffenbew.com');
$milestone3->addTask('Test7', '2011-04-02', '2011-04-12', 'http://steffenbew.com');
$milestone3->addTask('Some even longer description of what should be done', '2011-05-12', '2011-05-20', 'http://steffenbew.com');
$milestone3->addTask('Test12', '2011-04-02', '2011-05-12', 'http://steffenbew.com');
$milestone3->addTask('Test13', '2011-03-12', '2011-04-20', 'http://steffenbew.com');

?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" href="style.css" rel="stylesheet">
    </head>
    <body>
<!--
    	Chart is showing <?php echo $ezgantt->getDurationInDays(); ?> days / <?php echo $ezgantt->getDurationInWeeks(); ?> weeks.<br />
    	Start date: <?php echo date('Y-m-d H:i:s (K\W W)', $ezgantt->getStartDate()); ?><br />
    	End date: <?php echo date('Y-m-d H:i:s (K\W W)', $ezgantt->getEndDate()); ?>
-->
			<?php echo $ezgantt->render(); ?>
        
			<fieldset class="legend">
				<legend>Legend</legend>
				<span class="completed">Task completed</span>
				<span class="active">Task in progress</span>
				<span class="open">Task not yet begun</span>
			</fieldset>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
      <script>
      <!--
		  	$(document).ready(function () {
		  	
		  		// position a marker on the project plan for today
		  		
		  		var marker_margin = <?php echo $ezgantt->getMarginForToday(); ?>, title_width, object_width, total_margin;
		  		
					if(marker_margin !== -1) {
						marker_margin	= marker_margin / 100,
						title_width		= $('.ezgantt h3').outerWidth(),
						object_width	= $('.ezgantt_weeks').outerWidth(),
						total_margin	= object_width * marker_margin + title_width;
						
						$('.ezgantt_milestone').append('<div class="ezgantt_marker" style="left: ' + total_margin + 'px; height: 0;"></div>');
						
						setTimeout(function () {
							$('.ezgantt_marker').animate({height:'100%'}, 1000);
						}, 200);
					}
					
		  	});
		  -->
      </script>
			
    </body>
</html>

