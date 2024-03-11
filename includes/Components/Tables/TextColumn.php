<?php


class TextColumn extends Column
{
    public function render($val)
    {
        echo '<td>'.$this->xss_clean($val).'</td>';
    }
    public static function make($name) {return new self($name);}

}