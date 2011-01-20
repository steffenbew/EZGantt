<?php

require_once 'ezgantt.class.php';


$ezgantt = new EZGantt('EZGantt', '2011-01-01', '2011-05-20');

$ezgantt->add_milestone('Test1', '2011-01-02', '2011-02-06', 'Category 1');
$ezgantt->add_milestone('Test2', '2011-01-02', '2011-02-12');
$ezgantt->add_milestone('Test3', '2011-01-12', '2011-02-20');
$ezgantt->add_milestone('Test4', '2011-02-03', '2011-02-17', 'Category 1');
$ezgantt->add_milestone('Test5', '2011-04-15', '2011-05-19', 'Category 2');
$ezgantt->add_milestone('Test6', '2011-04-02', '2011-04-06', 'Category 1');
$ezgantt->add_milestone('Test7', '2011-03-02', '2011-03-12');
$ezgantt->add_milestone('Test8', '2011-04-12', '2011-04-20');
$ezgantt->add_milestone('Test9', '2011-02-03', '2011-03-17', 'Category 1');
$ezgantt->add_milestone('Test10', '2011-01-15', '2011-02-19', 'Category 2');
$ezgantt->add_milestone('Test11', '2011-04-02', '2011-04-06', 'Category 2');
$ezgantt->add_milestone('Test12', '2011-03-02', '2011-04-12');
$ezgantt->add_milestone('Test13', '2011-02-12', '2011-03-20');
$ezgantt->add_milestone('Test14', '2011-02-03', '2011-02-17', 'Category 1');
$ezgantt->add_milestone('Test15', '2011-01-15', '2011-05-19', 'Category 2');
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

