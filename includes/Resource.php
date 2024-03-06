<?php


class Resource
{
    protected static string | null $singleLabel="Entity";

    protected static string | null $pluralLabel="Entities";

    protected static string | null $icon= "list";

    protected static int | null $order =1;

    protected static bool | null $dashboarded=true;


    public static function getIcon(){return get_called_class()::$icon;}
    public static function getSingleLabel(){return get_called_class()::$singleLabel;}
    public static function getPluralLabel(){return get_called_class()::$pluralLabel;}
    public static function getOrder(){return get_called_class()::$order;}

    public static function getDashboarded(){return get_called_class()::$dashboarded;}

    protected static function form()
    {
        return Form::make();
    }

    protected static function table()
    {
        return Table::make();
    }



    public static function render(Router $router)
    {

        $sender= $router->getResource();
        $operation= $router->getOperation();
        $arg= $router->getArg();
        $term= $router->getparams()["term"]??"";



        $controller= new Controller($sender);

        //phone/show/all
        if ($operation=="show"){
            $sender::table()->render($sender,$arg,$term);
            return;
        }

        //phone/delete/1
        if ($operation=="delete"){
            $controller->delete($arg);
            $router->operation()->arg()->goto();
        }

        if($operation=="save"){

            //die(var_dump($_POST));

            foreach ($_POST as $key=>$p){
                if (is_array($_POST[$key])){
                    $_POST[$key]=implode(",",array_values($_POST[$key]));
                }

                if (strpos($key,"_grp_")>-1){
                    $namebits=explode("_grp_",$key);
                    if (!array_key_exists($namebits[1],$_POST)){$_POST[$namebits[1]]="";}
                    $_POST[$namebits[1]].=$namebits[0].":".$p."|";
                    unset($_POST[$key]);
                }
            }




            if (isset($_POST['password'])){
                $_POST['password']=password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $controller->updateIfFound($_POST,$arg);
            $sender::afterSave($id=$arg,$data=$_POST);
            $router->operation()->arg()->goto();
        }



        $sender::form()->render($sender,$arg=="new"?[]:$controller->getByID($arg));

    }

    public static function getTablePageSize(){
        $sender= get_called_class();
        return  $sender::table()->getPageSize();
    }


    protected static function afterSave($id,$data)
    {

    }

    public static function migrate():void{
        $sender= get_called_class();
        $fields=array();
        foreach ($sender::form()->getSchema() as $field) if ($field->sql()!="") $fields[]=$field->sql();
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