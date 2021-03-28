<?php

namespace SimpleRSSFeedToPost;

class RSSParser
{
  const RSSTitle = 'title';
  const RSSPubDate = 'pubDate';
  const RSSPubDateFormat = 'D, d M Y H:i:s';
  const RSSGuid = 'guid';
  const RSSDescription = 'description';
  const RSSContent = 'content';
  const RSSCreator = 'creator';

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
      self::RSSTitle => empty($feedItem->title) ? '' : (string)$feedItem->title,
      self::RSSPubDate => empty($feedItem->pubDate) ? date(self::RSSPubDateFormat) : (string)$feedItem->pubDate,
      self::RSSGuid => empty($feedItem->guid) ? '' : (string)$feedItem->guid,
      self::RSSDescription => empty($feedItem->description) ? '' : (string)$feedItem->description,
      self::RSSContent => empty($feedItem->children(self::RSSContent, true)->encoded) ? '' : (string)$feedItem->children(self::RSSContent, true)->encoded
    ];
  }
}
