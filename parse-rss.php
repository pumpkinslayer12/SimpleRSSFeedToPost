<?php

// URL containing rss feed
function rss_feed_url(){
//return 'https://myips.org/feed/';
    return 'myips.xml';
}

function load_rss_from_url($url){
return simplexml_load_file($url);}

// Expects rss item node from simplexml
function parse_rss_feed_item($item){
    return [
    // Title
    'title' => (string)$item -> title,
    // Full URL link. Link is php function. Using alternative access method for 'link' node
    'link' => (string)$item -> {'link'},
    // Publish Date
    'pubDate' => (string)$item -> pubDate,
    // GUID or permanent url for post
    'guid' => (string)$item -> guid,
    // Post Excerpt
    'description' => (string)$item -> description.'</strong>',
    // Post content
    'content' => (string)$item -> children('content',true) -> encoded
    ];
}

function parse_rss_feed(){
    $xml = load_rss_from_url(rss_feed_url());
    foreach ($xml -> channel -> item as $item){
        parse_rss_feed_item($item);
    }
}

parse_rss_feed();
?>
