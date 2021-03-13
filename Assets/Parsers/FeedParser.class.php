<?php

namespace SimpleRSSFeedToPost;

abstract class FeedParser
{
  private static function checkType($URI)
  {
    return 'RSS';
  }
  public static function getParser($URI)
  {
    if (self::checkType($URI) === 'RSS') {
      return new RSSParser($URI);
    }
  }
  public abstract function getFeedItems();
}
