<?php

class WordPressPostingSystem extends PostingSystem
{

    public function postItems($posts)
    {
        $arrayMapPostbackFunction = function ($post) {
            return $this->postProcessing($post);
        };
        return array_map($arrayMapPostbackFunction, $posts);
    }

    private function postProcessing($post)
    {
        $wordPressDataGateway = new WordPressPostDataGateway();
        $postExists = $wordPressDataGateway->doesPostExist($post);
        if ($postExists > 0) {
            return $postExists;
        } else {
            return $wordPressDataGateway->createNewPost($post);
        }
    }
}
