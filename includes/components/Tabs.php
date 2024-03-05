<?php


class Tabs extends Component
{
    protected array | null $tabs=[];

    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        echo '<div class="ui pointing secondary demo menu">';
            foreach ($this->tabs as $tab){
                echo '<a class="item" data-tab="'.$tab->getName().'">'.$tab->getLabel().'</a>';
            }
        echo '</div>';

        foreach ($this->tabs as $tab){
            echo '<div class="ui tab segment" data-tab="'.$tab->getName().'">';
            $tab->render($data);
            echo '</div>';
        }

    }

    public function tabs($tabs){
        $this->tabs=$tabs;
        return $this;
    }


    public function sql():string{
        return "";//$this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}