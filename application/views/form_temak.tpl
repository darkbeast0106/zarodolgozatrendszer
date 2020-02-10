<div class="block" id="block-tables">
                {if isset($logged_in.permission) && $logged_in.permission % 2 == 1}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="temak">Összes</a></li>
                        <li><a href="temak/own">Saját</a></li>
                        <li class="{if $action_mode == 'create'}active{/if}"><a href="temak/create/">Téma felvétele</a></li>
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
                        {if $action_mode == 'create'}
                            <h3>Új téma felvétele</h3>
                        {else}
                            <h3>Téma módosítása: {$temak_data.tema_cim}</h3>
                        {/if}
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='temak/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

                            
    	<div class="group">
            <label class="label">{$temak_fields.tema_cim}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="text" maxlength="255" value="{if isset($temak_data)}{$temak_data.tema_cim}{/if}" name="tema_cim" />
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$temak_fields.tema_leiras}</label>
    		<div>
                <textarea class="text_area" type="text" rows="5" name="tema_leiras" >{if isset($temak_data)}{$temak_data.tema_leiras}{/if}</textarea>
    		</div>
    		
    	</div>
    
    	<div class="group">
            <label class="label">{$temak_fields.tema_eszkozok}</label>
    		<div>
                <textarea class="text_area" type="text" rows="5" name="tema_eszkozok" >{if isset($temak_data)}{$temak_data.tema_eszkozok}{/if}</textarea>
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
