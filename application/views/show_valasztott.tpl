<div class="block" id="block-tables">

                <div class="content">
                    <div class="inner">
						<h3>Jelentkezés állapota</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
						    <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.konzulens_id}:</td>
                                <td>{$valasztott_data.konzulens_id}<a href="mailto:{$valasztott_data.konzulens_email}"><img src="iscaffold/images/email.png" alt="E-mail küldése" title="E-mail küldése" ></a></td>
                            </tr>
                            <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.sajat_tema}:</td>
                                <td>{$valasztott_data.sajat_tema}</td>
                            </tr>
                            <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.valasztott_cim}:</td>
                                <td>{$valasztott_data.valasztott_cim}</td>
                            </tr>
                            <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.valasztott_link}:</td>
                                <td><a href="{$valasztott_data.valasztott_link}" target="_blank">{$valasztott_data.valasztott_link}</a></td>
                            </tr>
                            <tr class="{if $valasztott_data.valasztott_status == 'Elutasítva'}error{else}{if $valasztott_data.valasztott_status == 'Teljesen elkészült'}success{else}{cycle values='odd,even'}{/if}{/if}">
                                <td>{$valasztott_fields.valasztott_status}:</td>
                                <td>{$valasztott_data.valasztott_status}</td>
                            </tr>
                            {if $valasztott_data.valasztott_status == '1. Bemutatás megtörtént' || $valasztott_data.valasztott_status == '2. Bemutatás megtörtént' || $valasztott_data.valasztott_status == '3. Bemutatás megtörtént'}
                            <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.program_allapot}:</td>
                                <td>{$valasztott_data.program_allapot} %</td>
                            </tr>
                            <tr class="{cycle values='odd,even'}">
                                <td>{$valasztott_fields.dokumentacio_allapot}:</td>
                                <td>{$valasztott_data.dokumentacio_allapot} %</td>
                            </tr>
                            {/if}
						</table>
                        {if $valasztott_data.valasztott_status != 'Teljesen elkészült'}
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                                <a class="button" href="valasztott/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Módosítás"> Téma adatok módosítása
                                </a>
                            </div>
                        </div>
                        {/if}
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
