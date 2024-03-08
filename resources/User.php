<?php


class User extends Resource
{
    public static string | null $singleLabel="User";

    public static string | null $pluralLabel="Users";

    public static string | null $icon= "user";

    public static int | null $order =5;

    public static bool | null $dashboarded=false;


    public static function canList(): bool
    {
        return currentUser()["kind"]=="admin";
    }

    public static function canDelete():bool
    {
        return false;
    }

    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("username")->label("User Name")->required(),
                TextInput::make("password")->label("Password")->password()->required(),
                Select::make("kind")->label("Kind")->options(["admin"=>"Admin","normal"=>"Normal"])->required()
            ]
        )->columns(3);
    }

    protected static function table()
    {
        return Table::make()->schema([
            TextColumn::make("username")->label("User Name")->columnSpan(8)->searchable(),
            SelectColumn::make("kind")->label("Kind")->options(["admin"=>"Admin","normal"=>"Normal"])->columnSpan(8)->searchable(),
        ])->resultPerPage(10);
    }

    protected static function afterCreation()
    {
        DB()->table("User")->data(["username"=>"admin","password"=>password_hash("admin",PASSWORD_DEFAULT),"kind"=>"admin"])->insert();
        DB()->table("User")->data(["username"=>"normal","password"=>password_hash("normal",PASSWORD_DEFAULT),"kind"=>"normal"])->insert();

    }

}