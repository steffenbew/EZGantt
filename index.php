<?php

require_once 'ezgantt.class.php';


$ezgantt = new EZGantt('EZGantt', '2011-01-01', '2011-05-20');

$ezgantt->add_milestone('Test2', '2011-01-02', '2011-02-06', 'Kategorie 1');
$ezgantt->add_milestone('Test1', '2011-01-02', '2011-02-12');
$ezgantt->add_milestone('Test3', '2011-01-12', '2011-02-20');
$ezgantt->add_milestone('Test99', '2011-02-03', '2011-02-17', 'Kategorie 1');
$ezgantt->add_milestone('Test99', '2011-04-15', '2011-05-19', 'Kategorie 2');
$ezgantt->add_milestone('Test2', '2011-04-02', '2011-04-06', 'Kategorie 1');
$ezgantt->add_milestone('Test1', '2011-03-02', '2011-03-12');
$ezgantt->add_milestone('Test3', '2011-04-12', '2011-04-20');
$ezgantt->add_milestone('Test99', '2011-02-03', '2011-03-17', 'Kategorie 1');
$ezgantt->add_milestone('Test99', '2011-01-15', '2011-02-19', 'Kategorie 2');
$ezgantt->add_milestone('Test2', '2011-04-02', '2011-04-06', 'Kategorie 2');
$ezgantt->add_milestone('Test1', '2011-03-02', '2011-04-12');
$ezgantt->add_milestone('Test3', '2011-02-12', '2011-03-20');
$ezgantt->add_milestone('Test99', '2011-02-03', '2011-02-17', 'Kategorie 1');
$ezgantt->add_milestone('Test99', '2011-01-15', '2011-05-19', 'Kategorie 2');
//echo $ezgantt->getDurationInDays();
//echo "<pre>".print_r($result,1)."</pre>";
?>
<!DOCTYPE html>
<html>
    <head>
        <link type="text/css" href="style.css" rel="stylesheet">
    </head>
    <body>
        <?php echo $ezgantt->render(); ?>
    </body>
</html>

