<?php


class Tab extends Component
{
    protected array | null $schema=[];

    public static function make($name) {return new self($name);}
    public function render($data)
    {
        /*echo '<div class="ui pointing secondary demo menu">';
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
            $tab->setLabel("");
            $tab->render($data);
            echo '</div>';
        }*/

        $elements=array();

        foreach ($this->schema as $elem){
            $value=array_key_exists($elem->getName(),$data)?$data[$elem->getName()]:"";
            $elements[]='<div class="'.$this->getRealColumnSpan($elem->getColumnSpan()).' wide column" style="padding:0.5rem">'.$elem->render($value).'</div>';
        }

        echo Template::make('

                <section class="ui grid">
                <div class="row">
                    {{$elements}}
                </div>
                </section>            
            
        ')->with([
            "elements"=>implode($elements)
        ])->render();

    }

    public function schema($schema){
        $this->schema=$schema;
        return $this;
    }



    public function sql():string{
        $sql=[];
        foreach ($this->schema as $elem){
            $sql[]=$elem->sql();
        }
        return implode(",",$sql);

    }

}