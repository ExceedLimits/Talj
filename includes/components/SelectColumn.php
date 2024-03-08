<?php


class SelectColumn extends Column
{

    protected string $resource="";
    protected string $resourceLabel="";

    protected array | null $opts=[];
    protected bool | null $searchable=false;

    public static function make($name) { return new self($name);}
    public function render($val)
    {
        $html="<td>";
        if ($this->resource==""){
            foreach (explode(",",$val) as $v){
                $html.='<a class="ui image label">'.$this->opts[$v].'</a>';
            }
        }else{
            $dataarr=DB()->table($this->resource)->where("id",$val,"IN")->select(["id",$this->resourceLabel]);
            if (sizeof($dataarr)==0) $html="Not Set";
            else{
                foreach ($dataarr as $v){
                    $html.='<a href="'.Router::resource($this->resource)->operation("edit")->arg($v['id'])->url().'" class="ui image label"><i class="icon '.$this->resource::getIcon().'"></i>'.$v[$this->resourceLabel].'</a>';
                }
            }

        }
        $html.="</td>";
        echo $html;
    }

    public function searchable($isSearchable=true)
    {
        $this->searchable=$isSearchable;
        return $this;
    }

    public function options($ops){
        $this->opts=$ops;
        return $this;
    }

    public function getName()
    {
        return parent::getName();
    }

    public function relationship($resource,$label){
        $this->resource=$resource;
        $this->resourceLabel=$label;
        return $this;
    }


}