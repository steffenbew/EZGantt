<?php

require_once 'ezgantt.class.php';


$ezgantt = new EZGantt('EZGantt');

$ezgantt->add_milestone('Test1', '#', '2011-01-02', '2011-02-06', 'Category 1', array('class' => 'done'));
$ezgantt->add_milestone('Test2 ist ganz schön lang für so einen Meilenstein', '#', '2011-01-04', '2011-02-12', NULL, array('class' => 'done'));
$ezgantt->add_milestone('Test3', '#', '2011-01-12', '2011-02-20', NULL, array('class' => 'done'));
$ezgantt->add_milestone('Test4', '#', '2011-02-03', '2011-02-17', 'Category 1');
$ezgantt->add_milestone('Test5', '#', '2011-04-15', '2011-05-14', 'Category 2', array('class' => 'not_begun'));
$ezgantt->add_milestone('Test6', '#', '2011-04-02', '2011-04-06', 'Category 1', array('class' => 'not_begun'));
$ezgantt->add_milestone('Test7', '#', '2011-03-02', '2011-03-12');
$ezgantt->add_milestone('Test8', '#', '2011-04-12', '2011-04-20', NULL, array('class' => 'not_begun'));
$ezgantt->add_milestone('Test9', '#', '2011-02-03', '2011-03-17', 'Category 1');
$ezgantt->add_milestone('Test10', '#', '2011-01-15', '2011-02-19', 'Category 2', array('class' => 'done'));
$ezgantt->add_milestone('Test11', '#', '2011-04-02', '2011-04-06', 'Category 2', array('class' => 'not_begun'));
$ezgantt->add_milestone('Test12', '#', '2011-03-02', '2011-04-12');
$ezgantt->add_milestone('Test13', '#', '2011-02-12', '2011-03-20', NULL, array('class' => 'not_begun'));
$ezgantt->add_milestone('Test14', '#', '2011-02-03', '2011-02-17', 'Category 1');
$ezgantt->add_milestone('Test15', '#', '2011-01-15', '2011-05-14', 'Category 2');
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
				<span class="done">Task finished</span>
				<span class="in_progress">Task in progress</span>
				<span class="not_begun">Task not yet begun</span>
			</fieldset>
    </body>
</html>

