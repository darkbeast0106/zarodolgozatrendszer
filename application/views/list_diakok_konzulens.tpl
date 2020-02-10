<div class="block" id="block-tables">
                {if $logged_in.permission > 2}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        {if $logged_in.permission >= 4}
                        <li class="first"><a href="diakok">Összes</a></li>
                        {/if}
                        {if $osztalyfonok}
                        <li><a href="diakok/osztaly/">Osztály</a></li>
                        {/if}
                        
                        <li class="active"><a href="diakok/konzulens/">Konzultált témáim</a></li>
                        
                        {if $logged_in.permission >= 8}
                        <li><a href="diakok/create/">Diák felvétele</a></li>
                        {/if}
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
                        <h3>Diákok</h3>

                        {if !empty( $diakok_data )}
                        <form action="diakok/delete" method="post" id="listing_form">
                            <table class="table">
                            	<thead>
                                    			
			<th>{$diakok_fields.nev}</th>
			<th>{$diakok_fields.diak_oszt_id}</th>
            <th>{$diakok_fields.felhasznalo_email}</th>
            
            <th>{$diakok_fields.valasztott_cim}</th>
            <th>{$diakok_fields.valasztott_link}</th>
            <th>{$diakok_fields.valasztott_status}</th>

                                    <th width="80">Műveletek</th>
                            	</thead>
                            	<tbody>
                                	{foreach $diakok_data as $row}
                                        <tr class="
                                        {if $row.valasztott_status == 'Elfogadásra vár'}
                                        error
                                        {elseif $row.valasztott_status == 'Teljesen elkészült'}
                                        success
                                        {else}
                                        {cycle values='odd,even'}
                                        {/if}">
                                            
                                            				
				<td>{$row.diak_vnev} {$row.diak_knev} {$row.diak_knev2}</td>
				<td>{$row.diak_oszt_id}</td>
                <td><a href="mailto:{$row.felhasznalo_email}">{$row.felhasznalo_email}</a></td>
                
                <td>{$row.valasztott_cim}</td>
                <td><a href="{$row.valasztott_link}" target="_blank">{$row.valasztott_link}</a></td>
                <td>{$row.valasztott_status}</td>

                                            <td width="80">
                                                <a href="diakok/show/{$row.diak_felh_id}"><img src="iscaffold/images/view.png" alt="Részletek" title="Részletek" /></a>
                                                {if $row.valasztott_status == 'Elfogadásra vár'}
                                                <a href="javascript:elfogad('diakok/elfogad/{$row.diak_felh_id}')"><img src="iscaffold/images/tick.png" alt="Elfogad" title="Elfogad" /></a>
                                                <a href="javascript:elutasit('diakok/elutasit/{$row.diak_felh_id}')"><img src="iscaffold/images/delete.png" alt="Elutasít" title="Elutasít" /></a>
                                                {elseif $row.valasztott_status == 'Feltételesen elfogadva'}
                                                <a class="button" href="javascript:promote('diakok/elfogad2/{$row.diak_felh_id}')">
                                                    Végleges elfogadás
                                                </a>
                                                {elseif $row.valasztott_status == 'Véglegesen elfogadva' || $row.valasztott_status == '1. Bemutatás megtörtént' || $row.valasztott_status == '2. Bemutatás megtörtént' || $row.valasztott_status == '3. Bemutatás megtörtént'}
                                                <a class="button" href="diakok/promote/{$row.diak_felh_id}">
                                                    Dokumentálás
                                                </a>
                                                
                                                {/if}

                                            </td>
                            		    </tr>
                                	{/foreach}
                            	</tbody>
                            </table>
                            <div class="actions-bar wat-cf">
                                <div class="pagination">
                                    {$pager}
                                </div>
                            </div>
                        </form>
                        {else}
                            Nem található adat.
                        {/if}

                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
