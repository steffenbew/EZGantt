<?php

require_once 'ezgantt.class.php';

function randomPeriod($start_date, $end_date)
{
	$random1 = rand($start_date, $end_date);
	$random2 = rand($start_date, $end_date);
	
	$start	= $random1 > $random2 ? $random2 : $random1;
	$end	= $random1 < $random2 ? $random2 : $random1;
	
	return array(date('Y-m-d', $start), date('Y-m-d', $end));
}

list($chart_start, $chart_end) = randomPeriod(strtotime('2011-01-01'), strtotime('2011-09-31'));

$ezgantt = new EZGantt('EZGantt');

for($i = 1; $i < rand(3, 6); $i++)
{
	# add random milestones
	$completed = rand(1, 3) === 1 ? TRUE : FALSE;
	list($milestone_start, $milestone_end) = randomPeriod(strtotime($chart_start), strtotime($chart_end));
	$milestone = $ezgantt->addMilestone("Milestone-$i", $milestone_start, $milestone_end, "#", $completed);
	
	# add random tasks to milestone
	for($k = 0; $k < rand(3, 6); $k++)
	{
		$completed = rand(1, 5) === 1 ? TRUE : FALSE;
		list($task_start, $task_end) = randomPeriod(strtotime($milestone_start), strtotime($milestone_end));
		$milestone->addTask("Test-$k", $task_start, $task_end, "#", $completed);
	}
}
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

