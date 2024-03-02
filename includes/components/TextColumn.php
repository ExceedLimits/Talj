<?php


class TextColumn extends Column
{

    protected bool | null $searchable=false;

    public static function make($name) {return new self($name);}
    public function render($val)
    {
        echo '<td>'.$val.'</td>';
    }

    public function searchable($isSearchable=true)
    {
        $this->searchable=$isSearchable;
        return $this;
    }

    public function getName()
    {
        return parent::getName();
    }


}