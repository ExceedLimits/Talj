<?php


class Repeater extends Component
{
    protected array | null $schema=[];

    protected int | null $cols=1;

    public static function make($name) {return new self($name);}
    public function render($data=[])
    {
        $html='
        <table class="ui single line table">
          <tbody>
            <tr>
            ';
        echo $html;
              foreach ($this->schema as $elem){
                  echo '<td>';
                  $elem->render($data);
                  echo '</td>';
              }
         $html= '</tr>
            
          </tbody>
          <tfoot class="full-width">
            <tr>
              <th></th>
              <th colspan="full">
                <button class="ui right floated small primary labeled icon button">
                  <i class="add icon"></i> Add New
                </button>
                
              </th>
            </tr>
          </tfoot>
        </table>
       ';
        echo $html;
    }

    public function schema($schema){
        $this->schema=$schema;
        return $this;
    }
    public function columns($cols=1){
        $this->cols=$cols;
        return $this;
    }





    public function sql():string{
        return $this->name." TEXT ". ($this->required?"":"NOT")." NULL ";
    }

}