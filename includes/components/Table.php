<?php
class Table
{

    protected array | null $schema =array();

    protected int $pageSize=5;



    public static function make() {return new self();}
    public function render($sender,$page,$term="")
    {
        $router=Router::resource($sender);
        $controller= new Controller($sender);
        $filters=array();
        foreach ($this->schema as $col){
            if ($col->searchable()) $filters[]=$col;
        }
        $data= $controller->getPage($page,$term,$filters);
        $total= $controller->getTotalCount($term,$filters);


        //if ($headers==[]) $headers= array_keys($data[0]);
        echo '
            <div class="ui borderless menu">
                <div class="item">
                <h1 class="ui header">'.$sender::getPluralLabel().'</h1>
                </div>
                <div class="item">
                <a href="'.$router->addNew().'" class="ui red button right"><i class="icon plus"></i>New '.$sender::getSingleLabel().'</a>
                </div>
                <div class="item right">
                    <form method="get" action="'.$router->url().'">
                        <div class="ui mini action input">
                            <input id="term" name="term" type="text" placeholder="Search..." value="'.$term.'"/>
                            <button type="submit" class="ui mini icon button">
                                <i class=" search icon"></i>
                            </button>
                        </div>
                    </form>
                </div>                
            </div>
        ';
        if ($data==[]) {echo "<h1 class='ui header' style='text-align: center'>Nothing to show Here</h1>";return;}
        echo '<table class="ui collapsing red table">';
            echo '<thead>';

                echo '<tr class="center aligned">';
                    foreach ($this->schema as $col){echo $col->renderHeader();}
                    echo '<th class="three wide">Actions</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                foreach ($data as $row){
                    echo '<tr class="center aligned">';
                    //die(var_dump($this->schema));
                        foreach ($this->schema as $col){
                            $col->render($row[$col->getName()]);
                        }
                        echo '<td>';
                            echo '<a href="'.$router->operation("edit")->arg($row['id'])->url().'"><i class="edit icon"></i></a>';
                            echo '<a href="#" class="del-btn" data-id="'.$row['id'].'" id="del-btn-'.$row['id'].'"><i class="delete red icon"></i></a>';
                        echo '</td>';
                    echo '</tr>';
                    echo '
                    <div class="ui tiny modal" id="del-'.$row['id'].'">
                      <div class="ui icon header">
                        <i class="trash icon"></i>
                        Delete this Element
                      </div>
                      <div class="content center aligned">
                        <p style="text-align: center">Are you sure you wanna do this??</p>
                      </div>
                      <div class="actions centered">
                        <div class="ui red inverted cancel button">
                          <i class="remove icon"></i>
                          Nope
                        </div>
                        <div class="ui green inverted ok button">
                          <a href="'.$router->operation("delete")->arg($row['id'])->url().'">
                          <i class="checkmark icon"></i>
                          Yah
                          </a>
                        </div>
                      </div>
                    </div>
                    ';
                }
            echo '</tbody>';
            echo '<tfoot><tr><th colspan="5">';
            //pagination links

            $params= $term==""?[]:["term"=>$term];

            if ($total < $this->pageSize) echo "";
            $total_pages = ceil($total / $this->pageSize);

            $prev = ($page - 1);
            $next = ($page + 1);
            $pagination='<div class="ui right floated pagination menu">';
            if ($page>1){
                $pagination .= '<a class="item" href="'.$router->operation()->arg($prev)->params($params)->url().'"><i class="icon small chevron left"></i> Previous</a> ';
            }
            for($i = 1; $i <= $total_pages; $i++)
            {
                if(($page) == $i)
                {
                    $pagination .= '<a class="item active" href="">'.$i.'</a>';
                }
                else
                {
                    $pagination .= '<a class="item" href="'.$router->operation()->arg($i)->params($params)->url().'">'.$i.'</a>';
                }
            }
            if($page < $total_pages)
            {
                $pagination .= '<a class="item" href="'.$router->operation()->arg($next)->params($params)->url().'"> Next <i class="icon small chevron right"></i></a>';
            }

            $pagination.='</div>';
            echo $pagination;

            echo '</th></tr></tfoot>';



        echo '</table>';


    }

    public function schema($fields=[]) {
        $this->schema=$fields;
        return $this;
    }

    public function resultPerPage($ps=5) {
        $this->pageSize=$ps;
        return $this;
    }

    public function getPageSize()
    {
        return $this->pageSize;
    }


}