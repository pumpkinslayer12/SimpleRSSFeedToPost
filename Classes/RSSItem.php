<?php
class RSSItem {
    private $label;
    private $value;
    private $attributes;
   
    public function __construct($label = '', $value = '' , $attributes = []){
        $this -> label = $label;
        $this -> value = $value;
        $this -> attributes = $attributes;  
    }

    public function get_label(){
    return $this -> label;
    }

    public function get_value(){
        return $this -> value;
    }
    public function get_attributes(){
        return $this -> attributes;
        }
    public function get_label_value_pair(){
        return [$this -> label => $this -> value];
    }
}
?>