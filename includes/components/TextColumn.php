<?php


class TextColumn extends Column
{
    public static function make($name) {return new self($name);}
    public function render($val)
    {
        echo '<td>'.$val.'</td>';
    }



}