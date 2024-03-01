<?php


class Resource
{
    protected static string | null $singleLabel="Entity";

    protected static string | null $pluralLabel="Entities";

    protected static string | null $icon= "fa fa-list";

    protected static int | null $order =1;

    protected static function form()
    {
        return Form::make();
    }

    protected static function table()
    {
        return Table::make();
    }

    public static function render($uri)
    {

        $sender= ($uri[2])??'';
        $operation= $uri[3]??'';
        $arg= $uri[4]??'';

        $controller= new Controller($sender);

        //phone/show/all
        if ($operation=="show"){
            $sender::table()->render($sender,$arg);
            return;
        }

        //phone/delete/1
        if ($operation=="delete"){
            $controller->delete($arg);
            return;
        }

        if($operation=="save"){
            $controller->updateIfFound($_POST,$arg);
            while (ob_get_status()) {ob_end_clean();}
            header("Location: ".APP_URL."/".$sender."/show/all");
            exit();
        }



        $sender::form()->render($sender,$arg=="new"?[]:$controller->getByID($sender,$arg));

        /*if ($arg=="new"){
            //phone/add/new
            if ($operation=="add"){
                self::renderForm($sender,$arg);
            }
            //phone/save/new
            if($operation=="save"){
                self::add($sender,$_POST);
            }
        }else{
            //phone/edit/1
            if ($operation=="edit"){
                self::renderForm($sender,$arg,self::get($sender,$arg));
            }
            //phone/save/1
            if($operation=="save"){
                self::update($sender,$_POST,$arg);
            }
        }*/


    }

    public static function getTablePageSize(){
        $sender= get_called_class();
        return  $sender::table()->getPageSize();
    }







    protected static function migrate():void{
        $sender= get_called_class();
        $fields=array();
        foreach ($sender::form()->getSchema() as $field) $fields[]=$field->sql();
        //die("fff");
        $last_migration= DB()->getLastMigration($sender);
        $current_migration=DB()->structure($sender,$fields);
        //structure changed
        if ($last_migration!=$current_migration)
        {
            DB()->drop($sender);
            DB()->create($sender,$fields);
            DB()->addMigration($sender,$current_migration);
        }

    }



















}