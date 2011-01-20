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

list($chart_start, $chart_end) = randomPeriod(strtotime('2011-01-01'), strtotime('2011-12-31'));
$categories = array('Category 1', 'Category 2', 'Category 3', '');


$ezgantt = new EZGantt('EZGantt');

for($i = 0; $i < rand(3, 15); $i++)
{
	list($start, $end) = randomPeriod(strtotime($chart_start), strtotime($chart_end));
	$ezgantt->add_milestone("Test-$i", $start, $end, $categories[array_rand($categories)]);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" href="style.css" rel="stylesheet">
    </head>
    <body>
    	Chart is showing <?php echo $ezgantt->getDurationInDays(); ?> days.<br />
    	Start date: <?php echo date('Y-m-d H:i:s', $ezgantt->getStartDate()); ?><br />
    	End date: <?php echo date('Y-m-d H:i:s', $ezgantt->getEndDate()); ?>
        <?php echo $ezgantt->render(); ?>
    </body>
</html>

