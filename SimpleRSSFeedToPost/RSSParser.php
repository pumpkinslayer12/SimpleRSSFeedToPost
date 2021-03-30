<?php

namespace SimpleRSSFeedToPost;

class RSSParser
{
  const Title = 'title';
  const PubDate = 'pubDate';
  const PubDateFormat = 'D, d M Y H:i:s';
  const Guid = 'guid';
  const Description = 'description';
  const Content = 'content';
  const Creator = 'creator';

  public static function getFeedItems($URI)
  {
    return self::parseRSSFeed(simplexml_load_file($URI));
  }

  private static function parseRSSFeed($RSSFeed)
  {
    $feedItems = [];
    foreach ($RSSFeed->channel->item as $item) {
      $feedItems[] = self::parseRSSFeedItem($item);
    }
    return $feedItems;
  }

  private static function parseRSSFeedItem($feedItem)
  {
    return [
      self::Title => empty($feedItem->title) ? '' : (string)$feedItem->title,
      self::PubDate => empty($feedItem->pubDate) ? date(self::PubDateFormat) : (string)$feedItem->pubDate,
      self::Guid => empty($feedItem->guid) ? '' : (string)$feedItem->guid,
      self::Description => empty($feedItem->description) ? '' : (string)$feedItem->description,
      self::Content => empty($feedItem->children(self::Content, true)->encoded) ? '' : (string)$feedItem->children(self::Content, true)->encoded
    ];
  }
}
