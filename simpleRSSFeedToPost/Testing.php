<?php
require_once('Assets/Run.php');
function echoContent($block)
{
    echo '<pre>';
    print_r($block);
    echo '</pre>';
}
$testRSSParser = new Run();
echoContent($testRSSParser->build('myips.rss'));
