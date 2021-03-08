<?php

abstract class FeedParser
{
  private static function checkType($URI)
  {
    return 'RSS';
  }
  public static function getParser($URI)
  {
    switch (self::checkType($URI)) {
      case 'RSS':
        return new RSSParser($URI);
        break;
      default:
        throw new Exception('There was an error getting a parser for the URI: ' . $URI);
    }
  }
  public abstract function getFeedItems();
}
