<div class="block" id="block-tables">
                {if isset($logged_in.permission) && $logged_in.permission % 2 == 1}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="temak">Összes</a></li>
                        <li><a href="temak/own">Saját</a></li>
                        <li><a href="temak/create/">Téma felvétele</a></li>
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
						<h3>{$temak_data.tema_cim} részletei</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$temak_fields.kiiro_id}:</td>
                            <td>{$temak_data.kiiro_nev}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$temak_fields.tema_cim}:</td>
                            <td>{$temak_data.tema_cim}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$temak_fields.tema_leiras}:</td>
                            <td>{$temak_data.tema_leiras}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$temak_fields.tema_eszkozok}:</td>
                            <td>{$temak_data.tema_eszkozok}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$temak_fields.tema_evszam}:</td>
                            <td>{$temak_data.tema_evszam}</td>
                        </tr>
						</table>
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                                <a class="button" href="temak">Vissza a témákra</a>
                                {if $temak_data.kiiro_id == $logged_in.uid}
                                <a class="button" href="temak/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Téma módosítása"> Téma módosítása
                                </a>
                                {/if}
                            </div>
                        </div>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
