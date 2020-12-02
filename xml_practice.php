<?php
$html = "";
// URL containing rss feed
$url = "myips.xml";
$xml = simplexml_load_file($url);
for($i = 0; $i < 2; $i++){
    echo '<p>Fart</p>';
    $title=$xml->channel->item[$i]->title;
    $link = $xml->channel->item[$i]->link;
    $description = $xml->channel->item[$i]->description;
    $pubDate = $xml->channel->item[$i]->pubDate;


    $html .= "<a target='_blank' href='$link'><b>$title</b></a>"; // Title of post
    $html .= "$description"; // Description
    $html .= "<br />$pubDate<br /><br />"; // Date Published
    }
    echo "$html<br />";
?>
