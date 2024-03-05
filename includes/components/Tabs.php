<?php


class Tabs extends Component
{
    protected array | null $tabs=[];

    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        echo '<div class="ui pointing secondary demo menu">';
        $active=" active ";
            foreach ($this->tabs as $tab){
                echo '<a class="'.$active.' item" data-tab="'.$tab->getName().'">'.$tab->getLabel().'</a>';
                $active="vvv";
            }
        echo '</div>';
        $active=" active ";
        foreach ($this->tabs as $tab){
            echo '<div class="ui '.$active.' tab segment" data-tab="'.$tab->getName().'">';
            $active="";
            $tab->render($data);
            echo '</div>';
        }

    }

    public function tabs($tabs){
        $this->tabs=$tabs;
        return $this;
    }


    public function sql():string{
        $sql=[];
        foreach ($this->tabs as $tab){
            $sql[]=$tab->sql();
        }
        return implode(",",$sql);//$this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}