<div class="block" id="block-tables">

                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="tanarok">Tanárok</a></li>
                        <li class="{if $action_mode == 'create'}active{/if}"><a href="tanarok/create/">Új tanár felvétele</a></li>
                    </ul>
                </div>

                <div class="content">
                    <div class="inner">
                        {if $action_mode == 'create'}
                            <h3>Új tanár felvétele</h3>
                        {else}
                            <h3>{$tanarok_data.tanar_vnev} {$tanarok_data.tanar_knev} {$tanarok_data.tanar_knev2} adatainak módosítása</h3>
                        {/if}
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='tanarok/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

        <div class="group">
            <label class="label">{$tanarok_fields.tanar_felh_id}<span class="error">*</span></label>
            <div>
                <input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.felhasznalo_id}{/if}" name="felhasznalo_id" />
            </div>
            
        </div>

       	<div class="group">
            <label class="label">{$tanarok_fields.tanar_vnev}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.tanar_vnev}{/if}" name="tanar_vnev" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$tanarok_fields.tanar_knev}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.tanar_knev}{/if}" name="tanar_knev" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$tanarok_fields.tanar_knev2}</label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.tanar_knev2}{/if}" name="tanar_knev2" />
    		</div>
    		
    	</div>
    
        <div class="group">
            <label class="label">{$tanarok_fields.tanar_ferohely}</label>
            <div>
                <input class="text_field" type="number" min="0" max="100" value="{if isset($tanarok_data)}{$tanarok_data.tanar_ferohely}{/if}" name="tanar_ferohely" />
            </div>
            
        </div>

    	<div class="group">
            <label class="label">{$tanarok_fields.tanar_jogosultsag_id}<span class="error">*</span></label>
    		<select class="field select addr" name="tanar_jogosultsag_id" >
                {foreach $related_jogosultsag as $rel}
                    <option value="{$rel.jogosultsag_id}"{if isset($tanarok_data)}{if $tanarok_data.tanar_jogosultsag_id == $rel.jogosultsag_id} selected="selected"{/if}{/if}>{$rel.jogosultsag_name}</option>
                {/foreach}
        	</select>
    		
        </div>
    
        <div class="group">
            <label class="label">{$tanarok_fields.felhasznalo_nev}<span class="error">*</span></label>
            <div>
                <input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.felhasznalo_nev}{/if}" name="felhasznalo_nev" />
            </div>
            
        </div>
    
        <div class="group">
            <label class="label">{$tanarok_fields.felhasznalo_jelszo}
                {if $action_mode == 'create'}<span class="error">*</span>{/if}
                {if $action_mode == 'edit'}<span class="error"><small>Hagyja üresen, ha nem szeretné változtatni.</small></span>{/if}
                <span><small>Javasolt jelszó generátort használni <a href="https://passwordsgenerator.net/">erős jelszóhoz</a></small></span>
            </label>
            <div>
                <input class="text_field" type="password" maxlength="255" value="" name="felhasznalo_jelszo" />
            </div>
            
        </div>
    
        <div class="group">
            <label class="label">{$tanarok_fields.felhasznalo_email}</label>
            <div>
                <input class="text_field" type="text" maxlength="255" value="{if isset($tanarok_data)}{$tanarok_data.felhasznalo_email}{/if}" name="felhasznalo_email" />
            </div>
            
        </div>

                            <div class="group navform wat-cf">
                                    <button class="button" type="submit">
                                        <img src="iscaffold/backend_skins/images/icons/tick.png" alt="Save"> Mentés
                                    </button>
                                    <span class="text_button_padding"> </span>
                                    <a class="button" href="javascript:window.history.back();">Mégse</a>
                            </div>
                        </form>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
