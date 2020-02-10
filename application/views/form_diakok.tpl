<div class="block" id="block-tables">

                {if $logged_in.permission > 2}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        {if $logged_in.permission > 4}
                        <li class="first"><a href="diakok">Összes</a></li>
                        {/if}
                        {if $osztalyfonok}
                        <li><a href="diakok/osztaly/">Osztály</a></li>
                        {/if}
                        {if $logged_in.permission % 2 == 1}
                        <li><a href="diakok/konzulens/">Konzultált témáim</a></li>
                        {/if}
                        {if $logged_in.permission > 8}
                        <li {if $action_mode == 'create'} class="active"{/if}><a href="diakok/create/">Diák felvétele</a></li>
                        {/if}
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
                        {if $action_mode == 'create'}
                            <h3>Diák felvétele</h3>
                        {else}
                            <h3>Diák adatainak módosítása: {$diakok_data.diak_vnev} {$diakok_data.diak_knev} {$diakok_data.diak_knev2}</h3>
                        {/if}
                        {if isset($errors)}
                            <div class="flash"> 
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='diakok/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

        <div class="group">
            <label class="label">{$diakok_fields.diak_felh_id}<span class="error">*</span></label>
            <div>
                <input class="text_field" type="text" maxlength="255" value="{if isset($diakok_data)}{$diakok_data.felhasznalo_id}{/if}" name="felhasznalo_id" />
            </div>
            
        </div>
                            
    	<div class="group">
            <label class="label">{$diakok_fields.diak_vnev}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($diakok_data)}{$diakok_data.diak_vnev}{/if}" name="diak_vnev" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$diakok_fields.diak_knev}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($diakok_data)}{$diakok_data.diak_knev}{/if}" name="diak_knev" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$diakok_fields.diak_knev2}</label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($diakok_data)}{$diakok_data.diak_knev2}{/if}" name="diak_knev2" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$diakok_fields.diak_oszt_id}<span class="error">*</span></label>
    		<select class="field select addr" name="diak_oszt_id" >
                <option value="0"></option>
                {foreach $related_osztalyok as $rel}
                    <option value="{$rel.osztalyok_id}"{if isset($diakok_data)}{if $diakok_data.diak_oszt_id == $rel.osztalyok_id} selected="selected"{/if}{/if}>{$rel.osztalyok_name}</option>
                {/foreach}
        	</select>
    		
        </div>

        <div class="group">
            <label class="label">{$diakok_fields.felhasznalo_jelszo}
                {if $action_mode == 'create'}<span class="error">*</span>{/if}
                {if $action_mode == 'edit'}<span class="error"><small>Hagyja üresen, ha nem szeretné változtatni.</small></span>{/if}<br>
                <span><small>Diák születési dátuma YYYY-MM-DD formában</small></span>
            </label>

            <div>
                <input class="text_field" type="password" maxlength="255" value="" name="felhasznalo_jelszo" />
            </div>
            
        </div>
    
        <div class="group">
            <label class="label">{$diakok_fields.felhasznalo_email}</label>
            <div>
                <input class="text_field" type="text" maxlength="255" value="{if isset($diakok_data)}{$diakok_data.felhasznalo_email}{/if}" name="felhasznalo_email" />
            </div>
            
        </div>

                            <div class="group navform wat-cf">
                                    <button class="button" type="submit">
                                        <img src="iscaffold/backend_skins/images/icons/tick.png" alt="Mentés"> Mentés
                                    </button>
                                    <span class="text_button_padding"> </span>
                                    <a class="button" href="javascript:window.history.back();">Mégse</a>
                            </div>
                        </form>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
