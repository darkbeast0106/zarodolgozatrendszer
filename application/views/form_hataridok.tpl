<div class="block" id="block-tables">

                <div class="content">
                    <div class="inner">
                        {$record_show=$record_id-1}
                        {*
                            A határidők számozása 1-től kezdődik míg a tömb 0-tól.
                        *}
                            <h3>Határidő módisítása: {$metadata.hatarido_megnevezes.enum_names.$record_show}</h3>
                        
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='hataridok/{$action_mode}/{if isset($record_id)}{$record_id}{/if}' enctype="multipart/form-data">

                            
    	
    	<div class="group">
            <span>
    		      <input class="text_field short" name="hataridok_ertek" size="16" type="date" maxlength="16" value="{if isset($hataridok_data)}{$hataridok_data.hataridok_ertek}{/if}"/>
    		</span>
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
