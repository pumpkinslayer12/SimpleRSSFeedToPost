<?php
require_once('loadRequirements.php');
class Run
{
  public function build($URI)
  {
    $parser = FeedParser::getParser($URI);
    $feedItems = $parser->getFeedItems();
    #------FullyTested Above this Point-------
    $postingSystem = PostingSystem::getPostingSystem();
    return $postingSystem->postItems($feedItems);
  }
}
