<?php


class Profile extends Resource
{
    public static string | null $singleLabel="Profile";

    public static string | null $pluralLabel="Profiles";

    public static string | null $icon= "list";

    public static int | null $order =2;



    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("p_name")->label("Profile Name")->required(),
                Select::make("language")->label("Language")->required()->options([
                    "English"=>"English","Deutsch"=>"Deutsch","Español"=>"Español"
                ]),
                Select::make("pb")->label("Phonebooks")->required()->multiple()->relationship("Phonebook","f_name"),
                Heading::make("h2")->label("Functions - Hard Keys")

            ]
        )->columns(1);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("p_name")->label("Profile Name")->columnSpan(16)->searchable(),
        ])->resultPerPage(1);
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}