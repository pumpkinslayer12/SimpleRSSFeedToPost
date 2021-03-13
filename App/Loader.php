<?php

namespace SimpleRSSFeedToPost;

class Loader
{
    public static function loader()
    {
        $applicationRoot = '../Assets/';
        $loaderExtension = '.class';
        foreach (glob("$applicationRoot*$loaderExtension.php") as $file) {
            require_once($file);
        }
    }
}
Loader::loader();
