<?php
class Form
{
    protected int | null $cols=1;

    protected array | null $schema =array();

    public static function make() {return new self();}
    public function render($sender,$arg)
    {
        if ($arg=="new"){
           $op="Add ".$sender;
           if (!$sender::canAdd()){
               echo '<div class="ui error message"><h3 class="ui header">Add Operation was Restricted by System Admin</h3></div>';
               return;
           }
        }else{
            $op="Edit ".$sender;
            if (!$sender::canEdit()){
                echo '<div class="ui error message"><h3 class="ui header">Edit Operation was Restricted by System Admin</h3></div>';
                return;
            }
        }

        $data= DB()->table($sender)->where("id",$arg)->first();
        $actionURL= Router::resource($sender)->operation("save")->arg($arg)->url();


        $elements=array();

        foreach ($this->schema as $elem){
            $value=array_key_exists($elem->getName(),$data)?$data[$elem->getName()]:"";
            $elements[]='<div class="'.$this->getRealColumnSpan($elem->getColumnSpan()).' wide column" style="padding:0.5rem">'.$elem->render($value).'</div>';
        }

        echo Template::make('
            <form class="ui form responsive" style="padding:1rem" method="post" action="{{$actionURL}}">
            <h1 class="ui dividing header"> {{$op}}</h1>
            <div class="ui error message"></div>
                <section class="ui grid">
                <div class="row">
                    {{$elements}}
                </div>
                </section>            
            <div class="ui divider"></div>
            <button type="submit" class="red ui button" style="margin-right: 0.5rem">  {{$op}}</button>
            <a href="javascript:history.go(-1)" class="button ui" style="">Cancel</a>
            
            </form>
        ')->with([
            "actionURL"=>$actionURL,"op"=>$op,"elements"=>implode($elements)
        ])->render();


        /*$html='
        <form class="ui form responsive" style="padding:1rem" method="post" action="'. $actionURL .'">
            <h1 class="ui dividing header"> '.$op.'</h1><div class="ui error message"></div>
            
            <div class="">
                <section class="ui grid">
                <div class="row">';
        echo $html;
                    foreach ($this->schema as $elem){
                        echo '<div class="'.$f->format((16/($this->cols))*$elem->getColumnSpan()).' wide column" style="padding:0.5rem">';
                        if ($elem instanceof Heading)
                            $elem->render();
                        else
                            $elem->render($data);
                        echo '</div>';
                    }
        $html='</div> 
            </section>
            </div>
            <div class="ui divider"></div>
            <button type="submit" class="red ui button" style="margin-right: 0.5rem"> '.$op.'</button>
            <a href="javascript:history.go(-1)" class="button ui" style="">Cancel</a>
            
            </form>
       ';
        echo $html;*/

    }


    public function columns($cols=1) {

        $this->cols=($cols);
        return $this;
    }

    public function schema($fields=[]) {
        $this->schema=$fields;
        return $this;
    }
    public function schemaAdd($elem){$this->schema[]=$elem;return $this;}

    public function getSchema() {
        return $this->schema;
    }

    protected function getRealColumnSpan($colspan):string{
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);

        return $f->format((16/($this->cols))*$colspan);
    }

}