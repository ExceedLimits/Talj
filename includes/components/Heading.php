<?php


class Heading extends Component
{
    public static function make($name) {return new self($name);}
    public function render()
    {
        echo '<h3 class="ui dividing header"> '.$this->label.'</h3>';
    }

    public function sql():string{
        return "";
    }

}