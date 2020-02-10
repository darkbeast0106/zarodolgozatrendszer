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
                            <h3>{$diakok_data.diak_vnev} {$diakok_data.diak_knev} {$diakok_data.diak_knev2} által bemutatott záródolgozat értékelése</h3>
                            <h4>{$diakok_data.valasztott_cim}</h4>
                        {if isset($errors)}
                            <div class="flash"> 
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='diakok/promote/{$record_id}' enctype="multipart/form-data">

        <div class="group">
            <label class="label">{$diakok_fields.program_allapot}<span class="error">*</span></label>
            <div>
                <input class="text_field" type="number" min="0" max="100" value="{if $diakok_data.valasztott_status == '3. Bemutatás megtörtént'}100{else}{$diakok_data.program_allapot}{/if}" name="program_allapot" {if $diakok_data.valasztott_status == '3. Bemutatás megtörtént'} readonly {else} required {/if} />
            </div>
            
        </div>
                            
    	<div class="group">
            <label class="label">{$diakok_fields.dokumentacio_allapot}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="number" min="0" max="100" value="{if $diakok_data.valasztott_status == '3. Bemutatás megtörtént'}100{else}{$diakok_data.dokumentacio_allapot}{/if}" name="dokumentacio_allapot" {if $diakok_data.valasztott_status == '3. Bemutatás megtörtént'} readonly {else} required {/if} />
    		</div>
    		
    	</div>
                            <div class="group navform wat-cf">
                                    <button class="button" type="submit">
                                        {if $diakok_data.valasztott_status == 'Véglegesen elfogadva'}
                                        1. Bemutatás dokumentálása
                                        {elseif $diakok_data.valasztott_status == '1. Bemutatás megtörtént'}
                                        2. Bemutatás dokumentálása
                                        {elseif $diakok_data.valasztott_status == '2. Bemutatás megtörtént'}
                                        3. Bemutatás dokumentálása
                                        {elseif $diakok_data.valasztott_status == '3. Bemutatás megtörtént'}
                                        <img src="iscaffold/backend_skins/images/icons/tick.png" alt="OK"> A diák bemutatta a kész programot
                                        {/if}
                                    </button>
                                    <span class="text_button_padding"> </span>
                                    <a class="button" href="javascript:window.history.back();">Mégse</a>
                            </div>
                        </form>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
