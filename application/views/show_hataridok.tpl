<div class="block" id="block-tables">
                <div class="content">
                    <div class="inner">
						<h3>Határidő részletei</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
						    <tr class="{cycle values='odd,even'}">
                            <td>{$hataridok_fields.hatarido_megnevezes}:</td>
                            <td>{$hataridok_data.hatarido_megnevezes}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$hataridok_fields.hataridok_ertek}:</td>
                            <td>{$hataridok_data.hataridok_ertek}</td>
                        </tr>
						</table>
                        {if isset($logged_in.permission) && $logged_in.permission >= 8}
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                                <a class="button" href="hataridok/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Edit record"> Módosítás
                                </a>
                            </div>
                        </div>
                        {/if}
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
