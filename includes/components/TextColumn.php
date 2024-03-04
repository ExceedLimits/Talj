<?php


class TextColumn extends Column
{



    public static function make($name) {return new self($name);}
    public function render($val)
    {
        echo '<td>'.$this->xss_clean($val).'</td>';
    }

    public function searchable($isSearchable = true)
    {
        return parent::searchable($isSearchable);
    }

    public function getName()
    {
        return parent::getName();
    }


}