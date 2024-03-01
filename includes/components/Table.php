<?php
class Table
{

    protected array | null $schema =array();

    protected int $pageSize=5;



    public static function make() {return new self();}
    public function render($sender,$arg)
    {
        $controller= new Controller($sender);
        $data= $controller->getPage($arg);

        if ($data==[]) {echo "<div class='ui container'><h4>No Rows to show..</h4></div>"; return;}

        //if ($headers==[]) $headers= array_keys($data[0]);
        echo '
            <div class="ui borderless menu">
                <div class="item">
                <h2 class="ui header">'.$sender::$pluralLabel.'</h2>
                </div>
                <div class="item right">
                <a href="'.APP_URL.'/'.$sender.'/add/new'.'" class="ui red button right">New '.$sender::$singleLabel.'</a>
                </div>
            </div>
        ';

        echo '<table class="ui collapsing red table">';
            echo '<thead>';

                echo '<tr class="center aligned">';
                    foreach ($this->schema as $col){echo $col->renderHeader();}
                    echo '<th class="three wide"></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                foreach ($data as $row){
                    echo '<tr class="center aligned">';
                        foreach ($this->schema as $col){echo '<td>'; echo xss_clean($row[$col->getName()]); echo '</td>';}
                        echo '<td>';
                            echo '<a href="'.APP_URL."/".$sender."/edit/".$row['id'].'"><i class="edit icon"></i></a>';
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
                          <a href="'.APP_URL."/".$sender."/delete/".$row['id'].'">
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
            $this->getPaginationLinks($sender,$arg);
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

    protected function getPaginationLinks($sender,$page){

        $controller= new Controller($sender);
        $total= $controller->getTotalCount();
        if ($total < $this->pageSize) return "";
        $total_pages = ceil($total / $this->pageSize);
        $prev = ($page - 1);
        $next = ($page + 1);
        $pagination='<div class="ui right floated pagination menu">';
        if ($page>1){
            $pagination .= '<a class="item" href="'.APP_URL.'/'.$sender.'/show/'.$prev.'"><i class="icon small chevron left"></i> Previous</a> ';
        }
        for($i = 1; $i <= $total_pages; $i++)
        {
            if(($page) == $i)
            {
                $pagination .= '<a class="item active" href="">'.$i.'</a>';
            }
            else
            {
                $pagination .= '<a class="item" href="'.APP_URL.'/'.$sender.'/show/'.$i.'">'.$i.'</a>';
            }
        }
        if($page < $total_pages)
        {
            $pagination .= '<a class="item" href="'.APP_URL.'/'.$sender.'/show/'.$next.'"> Next <i class="icon small chevron right"></i></a>';
        }

        $pagination.='</div>';
        echo $pagination;
    }

}