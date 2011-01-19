<?php

require_once 'ezgantt.class.php';


$ezgantt = new EZGantt('Test', '2011-01-01', '2011-01-10');

$ezgantt->add_milestone('Test2', '2011-01-02', '2011-01-04', 'Kategorie');
$ezgantt->add_milestone('Test1', '2011-01-02', '2011-01-04');
$ezgantt->add_milestone('Test3', '2011-01-02', '2011-01-04');
$ezgantt->add_milestone('Test99', '2011-01-02', '2011-01-04', 'Kategorie');
$ezgantt->add_milestone('Test99', '2011-01-02', '2011-01-04', 'Kategorie2');

$result = $ezgantt->render();

echo "<pre>".print_r($result,1)."</pre>";