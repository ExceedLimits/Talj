<?php


class Select extends Field
{
    protected array | null $opts=[];

    protected string | null $selected;
    protected bool | null $multi=false;
    public static function make($name) {return new self($name);}
    public function render($data)
    {
        //$dataval= array_key_exists($this->name,$data)?$data[$this->name]:"";

        $options="";
        foreach ($this->opts as $key=>$value){
            $options.="<option ".((in_array($key,explode(",",$data)))?'selected':'')." value='".$key."'>".$value."</option>";
        }

        Template::make(
            '
            <div class="{{CLASSES}}" style="{{STYLES}}">
                <label>{{$label}}</label>
                <select id="{{$name}}" name="{{$name}}" class="ui fluid dropdown search" {{$multi}} data-required="{{$req}}">
                <option value="">Select</option>
                {{$options}}
                </select>
            </div>
            '
        )->classes([
            'field',$this->isRequired()?"required":""
        ])
        ->styles([
            "padding:0.5rem"
        ])
        ->with(
            ["options"=>$options,"label"=>$this->label,"name"=>($this->multi)?$this->name."[]":$this->name,"multi"=>$this->multi,"req"=>$this->isRequired()?1:0]
        )
        ->render();

    }

    public function options($ops){
        $this->opts=$ops;
        return $this;
    }

    public function relationship($resource,$label){
        $this->opts=[];
        if (DB()->table($resource)->found()){
            $ops= DB()->table($resource)->select(['id',$label]);
            foreach ($ops as $op) $this->opts[$op["id"]]=$op[$label];
        }
        return $this;
    }

    public function multiple($multi=true){
        $this->multi=$multi;
        return $this;
    }

}