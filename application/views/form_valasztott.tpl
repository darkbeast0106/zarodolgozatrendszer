<script type="text/javascript" src="iscaffold/js/jquery-valasztott.js"></script>
<div class="block" id="block-tables">
                <div class="content">
                    <div class="inner">
                        {if $action_mode == 'create'}
                            <h3>Ön még nem jelentkezett témára, kérem jelentkezzen.</h3>
                        {else}
                            {if $logged_in.permission != -1}
                            <h3>Diák konzulensének módosítása: {$valasztott_data.valaszto_diak_id}</h3>
                            {else}
                            <h3>Jelentkezés módosítása</h3>
                            {/if}
                        {/if}
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='valasztott/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

        {if $action_mode == 'create' || (isset($valasztott_data) && $valasztott_data.valasztott_status == 'Elutasítva') || (isset($valasztott_data) && $valasztott_data.valasztott_status == 'Elfogadásra vár') }                            
    	<div class="group">
            <label class="label">{$valasztott_fields.konzulens_id}<span class="error">*</span></label>
    		<select class="field select addr" name="konzulens_id" >
                {*
                {if !isset($valasztott_data)}<option value="0" id="nooption" selected disabled></option> {/if} 
                *}
                {foreach $related_tanarok as $rel}
                    <option value="{$rel.tanarok_id}"{if isset($valasztott_data)}{if $valasztott_data.konzulens_id == $rel.tanarok_id} selected="selected"{/if}{/if}>{$rel.tanarok_name}</option>
                {/foreach}
        	</select><br>
            <b><span id="szabadhely"></span></b>
    	</div>
        {/if}
         {if !((isset($valasztott_data) && $valasztott_data.valasztott_status == '2. Bemutatás megtörtént') || (isset($valasztott_data) && $valasztott_data.valasztott_status == '3. Bemutatás megtörtént'))}            
    	<div class="group">
            <label class="label">{$valasztott_fields.valasztott_tema_id}</label>
    		<select class="field select addr" name="valasztott_tema_id" >
                <option value="0">Saját téma</option>
                {foreach $related_temak as $rel}
                    <option value="{$rel.temak_id}"{if isset($valasztott_data)}{if $valasztott_data.valasztott_tema_id == $rel.temak_id} selected="selected"{/if}{/if}>{$rel.temak_name}</option>
                {/foreach}
        	</select>
    		
        </div>
    
    	<div class="group">
            <label class="label">{$valasztott_fields.valasztott_cim}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($valasztott_data)}{$valasztott_data.valasztott_cim}{/if}" id="valasztott_cim" name="valasztott_cim" />
    		</div>
    		
    	</div>
        {/if}
    	<div class="group">
            <label class="label">{$valasztott_fields.valasztott_link}<span class="error">*</span><br><span><small>A linken elérhető kell, hogy legyen a specifikáció majd későbbiekben a felületterv, illetve a szakdolgozat és a dokumentáció verziói</small></span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($valasztott_data)}{$valasztott_data.valasztott_link}{/if}" name="valasztott_link" />
    		</div>
            {if $action_mode == 'edit'}
    		<input type="hidden" maxlength="255" value="{if isset($valasztott_data)}{$valasztott_data.valasztott_status}{/if}" name="valasztott_status" />
            {/if}
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
