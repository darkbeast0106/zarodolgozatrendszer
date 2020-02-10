<div class="block" id="block-tables">
                {if $logged_in.permission >= 8}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="tanarok">Tanárok</a></li>
                        <li><a href="tanarok/create/">Új tanár felvétele</a></li>
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
						<h3>{$tanarok_data.tanar_vnev} {$tanarok_data.tanar_knev} {$tanarok_data.tanar_knev2} adatai</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
						    <tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.tanar_felh_id}:</td>
                            <td>{$tanarok_data.tanar_felh_id}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.tanar_vnev}:</td>
                            <td>{$tanarok_data.tanar_vnev}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.tanar_knev}:</td>
                            <td>{$tanarok_data.tanar_knev} {$tanarok_data.tanar_knev2}</td>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.felhasznalo_email}:</td>
                            <td><a href="mailto:{$tanarok_data.felhasznalo_email}">{$tanarok_data.felhasznalo_email}</a></td>
                        </tr>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.tanar_jogosultsag_id}:</td>
                            <td>{$tanarok_data.tanar_jogosultsag_id}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$tanarok_fields.tanar_ferohely}:</td>
                            <td>{$tanarok_data.tanar_ferohely}</td>
                        </tr>
						</table>
                        
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                        {if $logged_in.permission >= 8}
                                <a class="button" href="tanarok/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Edit record"> Adatok módosítása
                                </a>
                        {else}
                                <a class="button" href="tanarok">
                                    Vissza a tanárok listájára
                                </a>
                        {/if}
                            </div>
                        </div>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
