<?php
class RSSParser extends FeedParser
{
  private $URI;

  public function __construct($URI)
  {
    $this->URI = $URI;
  }
  public function getFeedItems()
  {
    try {
      return $this->parseRSSFeed($this->loadRSSFeed($this->URI));
    } catch (Exception $e) {
      throw new Exception('There was an error loading the RSS feed in the parser. The URI is: ' . $this->URI . '. The error is: ' . $e->getMessage());
    }
  }

  private function loadRSSFeed()
  {
    return simplexml_load_file($this->URI);
  }

  private function parseRSSFeed($RSSFeed)
  {
    $feedItems = [];
    foreach ($RSSFeed->channel->item as $item) {
      $feedItems[] = $this->parseRSSFeedItem($item);
    }
    return $feedItems;
  }

  private function parseRSSFeedItem($feedItem)
  {
    $RSSDataTemplate = new RSSDataTemplate();

    return [
      $RSSDataTemplate::RSSTITLE => empty($feedItem->title) ? '' : (string)$feedItem->title,
      $RSSDataTemplate::RSSPUBDATE => empty($feedItem->pubDate) ? '' : (string)$feedItem->pubDate,
      $RSSDataTemplate::RSSGUID => empty($feedItem->guid) ? '' : (string)$feedItem->guid,
      $RSSDataTemplate::RSSDESCRIPTION => empty($feedItem->description) ? '' : (string)$feedItem->description,
      $RSSDataTemplate::RSSCONTENT => empty($feedItem->children($RSSDataTemplate::RSSCONTENT, true)->encoded) ? '' : (string)$feedItem->children($RSSDataTemplate::RSSCONTENT, true)->encoded
    ];
  }
}
