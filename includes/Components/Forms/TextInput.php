<?php


class TextInput extends Field
{
    protected string $type="text";

    public static function make($name) {return new self($name);}


    public function render($data):string
   {
       $val=$data;//array_key_exists($this->name,$data)?$data[$this->name]:"";
       if ($this->type=="password") $val="";

        return Template::make(
            '
        <div class="{{CLASSES}}" style="{{STYLES}}">
            <label>{{$label}}</label>
            <input id="{{$name}}" name="{{$name}}" type="{{$type}}" value="{{$value}}" data-required="{{$req}}">
        </div>
        '
        )
            ->classes([
                'field',$this->isRequired()?"required":""
            ])
            ->styles([
                "padding:0.5rem"
            ])
            ->with(
            ["label"=>$this->label,"name"=>$this->name,"type"=>$this->type,"value"=>$val,"req"=>$this->isRequired()?1:0]
            )
            ->render();

       /*$style="";
       //if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
       $html='
        <div class="field '.($this->isRequired()?"required":"").'" style="'.$style.'">
            <label>'.$this->label.'</label>
            <input id="'.$this->name.'" name="'.$this->name.'" data-required="'.($this->isRequired()?1:0).'" type="'.$this->type.'"  value="'.$val.'" />
        </div>
       ';
       echo $html;*/
   }



    public function password(){
        $this->type="password";
        return $this;
    }

    public function numeric(){
        $this->type="number";
        return $this;
    }

    public function telephone(){
        $this->type="tel";
        return $this;
    }



}