<?php

abstract class PostingSystem
{
  public static function getPostingSystem()
  {
    return new WordPressPostingSystem();
  }
  public abstract function postItems($posts);
}
