<?php


class Contact extends Resource
{
    public static string | null $singleLabel="Contact";

    public static string | null $pluralLabel="Contacts";

    protected static string | null $icon= "vcard";

    public static int | null $order =3;



    public static function form()
    {
        return Form::make()->schema(
            [
                TextInput::make("f_name")->label("First Name")->required(),
                TextInput::make("l_name")->label("Last Name")->required(),
                TextInput::make("num")->label("Phone Number")->required()->telephone(),
                Select::make("pb")->label("Phonebooks")->required()->multiple()->relationship("Phonebook","f_name"),
            ]
        )->columns(1);
    }

    protected static function table()
    {
        return Table::make()->schema([
            //TextColumn::make("id")->label("ID")->columnSpan(1)->searchable(),
            TextColumn::make("f_name")->label("First Name")->columnSpan(4)->searchable(),
            TextColumn::make("l_name")->label("Last Name")->columnSpan(4)->searchable(),
            TextColumn::make("num")->label("Phone Number")->columnSpan(3)->searchable(),
            SelectColumn::make("pb")->label("Phonebooks")->relationship("Phonebook","f_name")->columnSpan(5)

        ])->resultPerPage(1);
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}