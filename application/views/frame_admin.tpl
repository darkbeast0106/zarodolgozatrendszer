<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Petrik záródolgozat rendszer</title>
    <base href="{$config.base_url}" />
    <link rel="stylesheet" href="iscaffold/backend_skins/stylesheets/base.css" type="text/css" media="screen" />
    <link rel="shortcut icon" href="iscaffold/images/favicon.ico" />
    <link rel="icon" type="image/gif" href="iscaffold/images/animated_favicon1.gif" />
    <!--
        You can change the admin theme by changing the 'warehouse' directory in the path below
    -->
    <link rel="stylesheet" href="iscaffold/backend_skins/stylesheets/themes/warehouse/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="iscaffold/backend_skins/stylesheets/override.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="iscaffold/editor/CLEditor/jquery.CLEditor.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="iscaffold/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" />

    <script type="text/javascript" src="iscaffold/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="iscaffold/editor/CLEditor/jquery.cleditor.min.js"></script>
    <script type="text/javascript" src="iscaffold/editor/CLEditor/jquery.cleditor.extimage.js"></script>
    <script type="text/javascript" src="iscaffold/jquery-ui/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="iscaffold/js/main.js"></script>
</head>
<body>
    <div id="container">
        <div id="header">
            <h1><a href="">Záródolgozat rendszer - BMSZC - Petrik Lajos SZG</a></h1>
            
                <div id="user-navigation">
                    <ul class="wat-cf">
                        {if isset($logged_in.name)}
                        <li><span>{$logged_in.name}</span></li>
                        {/if}
                        {if $logged_in == true}
                        <li><a class="logout" href="login/logout">Kijelentkezés</a></li>
                        {else}
                        <li><a class="logout" href="login">Bejelentkezés</a></li>
                        {/if}
                    </ul>
                </div>

                <div id="main-navigation">
                    <ul class="wat-cf">
                        <li{if isset($table_name)}{if $table_name == 'home'} class='active'{/if}{/if}><a href='home'>Főoldal</a></li>
                        <li{if isset($table_name)}{if $table_name == 'Temak'} class='active'{/if}{/if}><a href='temak'>Témák</a></li>
                    {if $logged_in == true}
                        
                        {if $logged_in.permission > 0}
                        <li{if isset($table_name)}{if $table_name == 'Diakok'} class='active'{/if}{/if}><a href='diakok'>Diákok és témáik</a></li>
                        {/if}
                        {if $logged_in.permission >= 4}
                        <li{if isset($table_name)}{if $table_name == 'Osztalyok'} class='active'{/if}{/if}><a href='osztalyok'>Osztályok</a></li>
                        <li{if isset($table_name)}{if $table_name == 'Tanarok'} class='active'{/if}{/if}><a href='tanarok'>Tanárok</a></li>
                        <li{if isset($table_name)}{if $table_name == 'Hataridok'} class='active'{/if}{/if}><a href='hataridok'>Határidők</a></li>
                        {/if}
                        {if $logged_in.permission == -1}
                        <li{if isset($table_name)}{if $table_name == 'Valasztott'} class='active'{/if}{/if}><a href='valasztott'>Téma kidolgozás</a></li>
                        {/if}
                        <li{if isset($table_name)}{if $table_name == 'userdata'} class='active'{/if}{/if}><a href='userdata'>Felhasználói beállítások</a></li>
                    {/if}
                    </ul>
                </div>
        </div>

        {if isset($template) && $template != form_login}
        <div id="wrapper" class="wat-cf">
            <div id="main">

                {include file="$template.tpl"}

                <div id="footer">
                    <div class="block">
                        <p>
                            <a href="http://www.petrik.hu" target="_blank">
                                Budapesti Műszaki Szakképzési Centrum Petrik Lajos Két Tanítási Nyelvű Vegyipari Környezetvédelmi és Informatikai Szakgimnáziuma
                            </a>
                        </p>
                        <p>
                            Minden jog fenntartva. A rendszert készítette 
                            <a href="mailto:bence0630@gmail.com?Subject=Petrik%20Konzultációs%20Rendszer">
                                Budaházi Bence Nándor
                            </a>
                            Copyright © 2018.
                        </p>

                    </div>
                </div>
            </div>

        </div><!-- wrapper -->

        {else}
            {include file="form_login.tpl"}
        {/if}

    </div><!-- container -->
</body>
</html>