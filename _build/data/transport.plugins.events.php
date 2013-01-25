<?php
/**
 * @package bannery
 * @subpackage build
 */
global  $modx, $sources;
$events = array();

$events['OnWebPagePrerender']= $modx->newObject('modPluginEvent');
$events['OnWebPagePrerender']->fromArray(array(
    'event' => 'OnWebPagePrerender',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);
/*
$events['OnPageNotFound']= $modx->newObject('modPluginEvent');
$events['OnPageNotFound']->fromArray(array(
    'event' => 'OnPageNotFound',
    'priority' => 0,
    'propertyset' => 0,
),'',true,true);*/

 

return $events;