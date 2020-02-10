<div class="block" id="block-tables">
                {if $logged_in.permission >= 8}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="osztalyok">Osztályok</a></li>
                        <li><a href="osztalyok/create/">Új osztály felvétele</a></li>
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
						<h3>Osztály adatai: {$osztalyok_data.osztaly_nev} - {$osztalyok_data.vegzes_eve}</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
						    <tr class="{cycle values='odd,even'}">
                            <td>{$osztalyok_fields.osztaly_id}:</td>
                            <td>{$osztalyok_data.osztaly_id}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$osztalyok_fields.osztaly_nev}:</td>
                            <td>{$osztalyok_data.osztaly_nev}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$osztalyok_fields.osztalyfonok_id}:</td>
                            <td>{$osztalyok_data.osztalyfonok_id}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$osztalyok_fields.vegzes_eve}:</td>
                            <td>{$osztalyok_data.vegzes_eve}</td>
                        </tr>
						</table>
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                                {if $logged_in.permission >= 8}
                                <a class="button" href="osztalyok/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Edit record"> Adatok módosítása
                                </a>
                                {else}
                                <a class="button" href="osztalyok">
                                    Vissza az osztályokra
                                </a>
                                {/if}
                            </div>
                        </div>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
