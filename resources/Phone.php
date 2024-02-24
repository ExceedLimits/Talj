<?php


class Phone extends Resource
{
    public static string | null $singleLabel="Phone";

    public static string | null $pluralLabel="Phones";

    public static string | null $icon= "fa fa-phone";

    public static int | null $order =1;

    protected static int | null $formColumns=2;

    public static function form()
    {
        return [
            TextInput::make("phname")->label("Phone Name")->required()->columnSpan(2),
            TextInput::make("mac")->label("MAC Address")->required(),
            TextInput::make("ip")->label("IP Address")->required(),
            Select::make("op")->label("IP Options")->options(["0"=>"on","y"=>"off"])->selected("y")->required(),
        ];
    }

    public static function render()
    {
        parent::render();
    }


}