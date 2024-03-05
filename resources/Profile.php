<?php


class Profile extends Resource
{
    public static string | null $singleLabel="Profile";

    public static string | null $pluralLabel="Profiles";

    public static string | null $icon= "list";

    public static int | null $order =2;

    private static $actions=[
        "Nothing"=>"",
        "Line"=>"line",
        "Settings"=>"keyevent F_SETTINGS",
        "Call Forwarding"=>"redirect",
        "Do Not Disturb"=>"keyevent F_DND",
        "List Missed Calls"=>"keyevent F_MISSED_LIST",
        "List Dialed Calls"=>"keyevent F_DIALED_LIST",
        "Voice Mail"=>"keyevent F_RETRIEVE",
        "Next Page"=>"keyevent F_LABEL_PAGE_NEXT",
        "Call History"=>"keyevent F_CALL_LIST",
        "Speed Dial"=>"speed",
        "Directory"=>"keyevent F_ADR_BOOK",
        "Busy Lamp Field Offline"=>"blf",
        "Private Hold"=>"keyevent F_REDIAL",
        "ReDial"=>"keyevent F_REDIAL",
        "Transfer"=>"transfer",
        "Conference"=>"conference",
        "Extension"=>"dest",
        "Park"=>"orbit",
        "Hold"=>"keyevent F_HOLD",
        "Info Message"=>"keyevent F_STATUS",
        "Missed Calls"=>"keyevent F_MISSED_LIST",
        "Accepted Calls"=>"keyevent F_ACCEPTED_LIST",
        "Dialed Calls"=>"keyevent F_DIALED_LIST",
        "Instant Redial"=>"keyevent F_INSTANT_REDIAL",
        "XML"=>"xml",
        "Server Directory"=>"keyevent F_SERVER_AB",
        "Automate Call Distribution"=>"BW-ACD",
        "Action Url"=>"url https",
        "Multicast"=>"multicast",
    ];

    private static $hard_keys=[
        "retrieve",
        "conf",
        "directory",
        "transfer",
        "redial",
        "hold"
    ];

    private static $langs=[
        "Deutsch"=>"Deutsch","English"=>"English","Español"=>"Español"
    ];

    private static $icons=[
        "Deutsch"=>"de","English"=>"en","Español"=>"es"
    ];

    public static function form()
    {

        $hk=array();
        $sd=array();
        $cs=array();
        $lk=array();

        foreach (self::$hard_keys as $hkey){
            $hk[]=Select::make("dkey_".$hkey)->label(ucfirst($hkey))->options(array_flip(self::$actions));
            $hk[]=TextInput::make("dkey_".$hkey."_extra")->label(ucfirst($hkey)." Extra Info.");
        }

        for($i=1;$i<=30;$i++){
            $sd[]=TextInput::make("sd_".$i)->label("Button: ".ucfirst($i));
        }
        $sd[]=TextInput::make("sd_zero")->label("Button: 0");
        $sd[]=TextInput::make("sd_pound")->label("Button: #");
        $sd[]=TextInput::make("sd_star")->label("Button: *");

        for($i=1;$i<=12;$i++){
            $cs[]=Select::make("cs_".$i)->label("Button: ".ucfirst($i))->options(array_flip(self::$actions));
            $cs[]=TextInput::make("cs_".$i."_extra")->label("Button: ".ucfirst($i)." Extra Info.");
        }

        for($i=1;$i<=40;$i++){
            $lk[]=Select::make("lk_".$i)->label("Button: ".ucfirst($i))->options(array_flip(self::$actions));
            $lk[]=TextInput::make("lk_".$i."_extra")->label("Button: ".ucfirst($i)." Extra Info.");
        }


        return Form::make()->schema([
            TextInput::make("p_name")->label("Profile Name")->required(),
            Select::make("language")->label("Language")->required()->options(self::$langs),
            Select::make("pb")->label("Phonebooks")->required()->multiple()->columnSpan(2)->relationship("Phonebook","f_name"),
            Tabs::make("Functions")->tabs([
                Group::make("hk")->label("Functions - Hard Keys")->schema($hk)->columns(2)->columnSpan(2),
                Group::make("cs")->label("Functions - Context Sensitive Keys")->schema($cs)->columns(2)->columnSpan(2),
                Group::make("sd")->label("Functions - Speed Dial")->schema($sd)->columns(4)->columnSpan(2),
                Group::make("lk")->label("Functions - Line Keys")->schema($lk)->columns(2)->columnSpan(2),

            ])->columnSpan(2)

        ])->columns(2);
    }

    protected static function table()
    {
        return Table::make()->schema([
            TextColumn::make("p_name")->label("Profile Name")->columnSpan(6)->searchable(),
            SelectColumn::make("language")->label("Language")->columnSpan(8)->options(self::$langs),
            SelectColumn::make("pb")->label("Phonebooks")->columnSpan(3)->relationship("Phonebook","f_name")
        ])->resultPerPage(10);
    }

    protected static function afterSave($id,$data)
    {

        parent::afterSave($id,$data);
        if ($id!="new") $profile= DB()->get("Profile",$id); else $profile=$data;
        self::createXML($profile);


    }

    protected static function createXML($profile){
        $file = 'assets/xml/template.xml';
        $xml = file_get_contents($file);

        $replacements=array();

        $replacements["ST_LANG"]=$profile['language'];

        $replacements["HARD_KEYS"]="";
        $innerData=self::getDataArray($profile["hk"]);
        foreach ($innerData as $key=>$data){
            if (str_ends_with($key,"extra_grp_hk")) continue;
            $k=str_replace("_grp_hk","",$key);
            if (strpos($k,"dkey")>-1) {
                $replacements["HARD_KEYS"].="<".$k.' perm="">'.trim($data." ".$innerData[$k."_extra_grp_hk"]).'</'.$k.'>';
            }
        }

        $replacements["CONTEXT_KEYS"]="";
        $innerData=self::getDataArray($profile["cs"]);
        foreach ($innerData as $key=>$data){
            if (str_ends_with($key,"extra_grp_hk")) continue;
            $k=str_replace("_grp_hk","",$key);
            if (strpos($k,"cs")>-1) {
                $replacements["CONTEXT_KEYS"].='<context_key idx="'.str_replace("cs_","",$k).'" perm="">'.trim($data." ".$innerData[$k."_extra_grp_hk"]).'</context_key>';
            }
        }



        $replacements["SPEED_DAIL"]="";
        $innerData=self::getDataArray($profile["sd"]);
        //die(var_dump($innerData));
        foreach ($innerData as $key=>$data){
            //if (str_ends_with($key,"extra_grp_hk")) continue;
            $k=str_replace("sd_","",str_replace("_grp_hk","",$key));
            if ($k=="zero") $k="0";if ($k=="pound") $k="#";if ($k=="star") $k="*";
            $replacements["SPEED_DAIL"].='<speed idx="'.$k.'" perm="">'.$innerData[$key].'</speed>';

        }

        $tbookitem='<item context="active" type="none" fav="false" mod="true" index="0"><name>TB_NX</name><number>TB_NUMX</number><number_type>extension</number_type><birthday>00.00.99</birthday></item>';
        $replacements["PHONE_BOOK"]='<tbook e="2">';
        foreach (DB()->getIn("Phonebook",$profile['pb']) as $phonebook){
            foreach(DB()->getIn("Contact",$phonebook['id']) as $contact)
                $replacements["PHONE_BOOK"].= str_replace(["TB_NX","TB_NUMX"],[$contact['f_name'],$contact['num']],$tbookitem);
        }
        $replacements["PHONE_BOOK"].='</tbook>';

        //die(var_dump($replacements));

        $text = str_replace(array_keys($replacements),array_values($replacements),$xml);

        file_put_contents($profile['p_name'].".xml", $text);

        //update related phones
        $data= file_get_contents("".$profile["p_name"].".xml");
        foreach (DB()->query("select * from Phone where profile =".$profile["id"])->fetchAll() as $phone)
        file_put_contents("snomD865/".$phone["mac"].".xml",$data);

    }

    protected static function getDataArray($s){
        $innerData=[];
        foreach (explode("|",$s) as $one){
            if ($one=="") continue;
            $innerData[explode(':',$one)[0]."_grp_hk"]=explode(":",$one)[1];
        }
        return $innerData;
    }


    public static function migrate(): void
    {
        parent::migrate();
    }




}