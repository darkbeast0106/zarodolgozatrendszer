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
                        <li><a href="diakok/create/">Diák felvétele</a></li>
                        {/if}
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
						<h3>{$diakok_data.diak_vnev} {$diakok_data.diak_knev} {$diakok_data.diak_knev2} adatai</h3>

						<table class="table" width="50%">
                        	<thead>
                                <th width="20%"></th>
                                <th></th>
                        	</thead>
						    <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.diak_felh_id}:</td>
                            <td>{$diakok_data.diak_felh_id}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.diak_vnev}:</td>
                            <td>{$diakok_data.diak_vnev}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.diak_knev}:</td>
                            <td>{$diakok_data.diak_knev} {$diakok_data.diak_knev2}</td>
                        </tr><tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.diak_oszt_id}:</td>
                            <td>{$diakok_data.diak_oszt_id}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.felhasznalo_email}:</td>
                            <td><a href="mailto:{$diakok_data.felhasznalo_email}">{$diakok_data.felhasznalo_email}</a></td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.valasztott_status}:</td>
                            <td>{$diakok_data.valasztott_status}</td>
                        </tr>
                        {if $diakok_data.valasztott_status != 'Nincs'}
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.konzulens_id}:</td>
                            <td>{$diakok_data.konzulens_id}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.sajat_tema}:</td>
                            <td>{$diakok_data.sajat_tema}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.valasztott_cim}:</td>
                            <td>{$diakok_data.valasztott_cim}</td>
                        </tr>
                        <tr class="{cycle values='odd,even'}">
                            <td>{$diakok_fields.valasztott_link}:</td>
                            <td><a href="{$diakok_data.valasztott_link}" target="_blank">{$diakok_data.valasztott_link}</a></td>
                        </tr>
                        {if $diakok_data.valasztott_status == '1. Bemutatás megtörtént' || $diakok_data.valasztott_status == '2. Bemutatás megtörtént' || $diakok_data.valasztott_status == '3. Bemutatás megtörtént'}
                            <tr class="{cycle values='odd,even'}">
                                <td>{$diakok_fields.program_allapot}:</td>
                                <td>{$diakok_data.program_allapot} %</td>
                            </tr>
                            <tr class="{cycle values='odd,even'}">
                                <td>{$diakok_fields.dokumentacio_allapot}:</td>
                                <td>{$diakok_data.dokumentacio_allapot} %</td>
                            </tr>
                            {/if}
                        {/if}                        
						</table>
                        <div class="actions-bar wat-cf">
                            <div class="actions">
                                {if $logged_in.permission <= 2}
                                <a class="button" href="diakok">
                                    Vissza a diákokra
                                </a>
                                {/if}
                                {if $logged_in.permission >= 8 || $osztalyfonoke}
                                <a class="button" href="diakok/edit/{$id}">
                                    <img src="iscaffold/backend_skins/images/icons/application_edit.png" alt="Szerkesztés"> Diák adatainak módosítása
                                </a>
                                {/if}
                                {if $konzulense}
                                    {if $diakok_data.valasztott_status == 'Elfogadásra vár'}
                                    <a class="button" href="javascript:elfogad('diakok/elfogad/{$id}')">
                                        <img src="iscaffold/backend_skins/images/icons/tick.png" alt="Elfogad"> Téma feltételes elfogadása
                                    </a>
                                    <a class="button" href="javascript:elutasit('diakok/elutasit/{$id}')">
                                        <img src="iscaffold/backend_skins/images/icons/cross.png" alt="Elutasit"> Téma elutasítása
                                    </a>
                                    {elseif $diakok_data.valasztott_status == 'Feltételesen elfogadva'}
                                    <a class="button" href="javascript:promote('diakok/elfogad2/{$id}')">
                                        Téma végleges elfogadása
                                    </a>
                                    {elseif $diakok_data.valasztott_status == 'Véglegesen elfogadva'}
                                    <a class="button" href="diakok/promote/{$id}">
                                        1. Bemutatás adminisztrálása
                                    </a>
                                    {elseif $diakok_data.valasztott_status == '1. Bemutatás megtörtént'}
                                    <a class="button" href="diakok/promote/{$id}">
                                        2. Bemutatás adminisztrálása
                                    </a>
                                    {elseif $diakok_data.valasztott_status == '2. Bemutatás megtörtént'}
                                    <a class="button" href="diakok/promote/{$id}">
                                        3. Bemutatás adminisztrálása
                                    </a>
                                    {elseif $diakok_data.valasztott_status == '3. Bemutatás megtörtént'}
                                    <a class="button" href="diakok/promote/{$id}">
                                       <img src="iscaffold/backend_skins/images/icons/tick.png" alt="Elfogad"> Kész állapot elfogadása
                                    </a>
                                    {/if}
                                {/if}
                            </div>
                        </div>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
