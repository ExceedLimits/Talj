<?php


class Select extends Component
{
    protected array | null $opts=[];

    protected string | null $selected;
    protected bool | null $multi=false;
    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        //$this->selected=array_key_exists($this->name,$data)?$data[$this->name]:"";
        $dataval= array_key_exists($this->name,$data)?$data[$this->name]:"";
        $name= ($this->multi)?$this->name."[]":$this->name;
        $style="padding:0.5rem";
        //if ($this->colSpan!=0) $style.="grid-column:span ".$this->colSpan;
        $options="";
        foreach ($this->opts as $key=>$value){

            $options.="<option ".((in_array($key,explode(",",$dataval)))?'selected':'')." value='".$key."'>".$value."</option>";
        }
        $html='
        <div class="field '.($this->isRequired()?"required":"").'" style="'.$style.'">
            <label>'.$this->label.'</label>
            <select '.(($this->multi)?"multiple":"").' class="ui fluid dropdown search" data-required="'.($this->isRequired()?1:0).'" id="'.$this->name.'" name="'.$name.'">
            <option value="">Select</option>'.$options.'
            </select>            
        </div>
       ';
        echo $html;
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


    public function selected($key){
        $this->selected=$key;
        return $this;
    }

    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}