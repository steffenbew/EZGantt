<?php

require_once 'ezgantt.class.php';


$ezgantt = new EZGantt('EZGantt');

$ezgantt->add_milestone('Test1', '#', '2011-02-02', '2011-03-06', 'Category 1', TRUE);
$ezgantt->add_milestone('Some long text for a milestone', '#', '2011-02-04', '2011-03-12', NULL, TRUE);
$ezgantt->add_milestone('Test3', '#', '2011-02-12', '2011-03-20', NULL, array('class' => 'done'));
$ezgantt->add_milestone('Test4', '#', '2011-03-03', '2011-03-17', 'Category 1');
$ezgantt->add_milestone('Test5', '#', '2011-05-15', '2011-06-14', 'Category 2');
$ezgantt->add_milestone('Test6', '#', '2011-05-02', '2011-05-06', 'Category 1');
$ezgantt->add_milestone('Test7', '#', '2011-04-02', '2011-04-12');
$ezgantt->add_milestone('An even longer description of what should be done', '#', '2011-05-12', '2011-05-20', NULL, array('class' => 'not_begun'));
$ezgantt->add_milestone('Test9', '#', '2011-03-03', '2011-04-17', 'Category 1');
$ezgantt->add_milestone('Test10', '#', '2011-01-15', '2011-03-19', 'Category 2', TRUE);
$ezgantt->add_milestone('Test11', '#', '2011-05-02', '2011-05-06', 'Category 2');
$ezgantt->add_milestone('Test12', '#', '2011-04-02', '2011-05-12');
$ezgantt->add_milestone('Test13', '#', '2011-03-12', '2011-04-20', NULL);
$ezgantt->add_milestone('Test14', '#', '2011-03-03', '2011-03-17', 'Category 1');
$ezgantt->add_milestone('Test15', '#', '2011-01-15', '2011-06-14', 'Category 2');
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

