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

list($chart_start, $chart_end) = randomPeriod(strtotime('2011-03-01'), strtotime('2011-09-31'));
$categories = array('Category 1', 'Category 2', 'Category 3', '');


$ezgantt = new EZGantt('EZGantt');

for($i = 0; $i < rand(10, 15); $i++)
{
	$completed = rand(1, 5) === 1 ? TRUE : FALSE;
	list($start, $end) = randomPeriod(strtotime($chart_start), strtotime($chart_end));
	$ezgantt->add_milestone("Test-$i", "#", $start, $end, $categories[array_rand($categories)], $completed);
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
    </body>
</html>

