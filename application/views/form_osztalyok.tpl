<div class="block" id="block-tables">

                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="osztalyok">Osztályok</a></li>
                        <li class="{if $action_mode == 'create'}active{/if}"><a href="osztalyok/create/">Új osztály felvétele</a></li>
                    </ul>
                </div>

                <div class="content">
                    <div class="inner">
                        {if $action_mode == 'create'}
                            <h3>Osztály felvétele</h3>
                        {else}
                            <h3>Osztály adatainak módosítása: {$osztalyok_data.osztaly_nev} - {$osztalyok_data.vegzes_eve}</h3>
                        {/if}
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='osztalyok/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

                            
    	<div class="group">
            <label class="label">{$osztalyok_fields.osztaly_nev}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($osztalyok_data)}{$osztalyok_data.osztaly_nev}{/if}" name="osztaly_nev" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$osztalyok_fields.osztalyfonok_id}<span class="error">*</span></label>
    		<select class="field select addr" name="osztalyfonok_id" >
                <option value="0"></option>
                {foreach $related_tanarok as $rel}
                    <option value="{$rel.tanarok_id}"{if isset($osztalyok_data)}{if $osztalyok_data.osztalyfonok_id == $rel.tanarok_id} selected="selected"{/if}{/if}>{$rel.tanarok_name}</option>
                {/foreach}
        	</select>
    		
        </div>
    
    	<div class="group">
            <label class="label">{$osztalyok_fields.vegzes_eve}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($osztalyok_data)}{$osztalyok_data.vegzes_eve}{/if}" name="vegzes_eve" />
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
