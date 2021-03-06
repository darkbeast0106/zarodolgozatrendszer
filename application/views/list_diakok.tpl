<div class="block" id="block-tables">
                {if $logged_in.permission > 2}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first active"><a href="diakok">Összes</a></li>
                        {if $osztalyfonok}
                        <li><a href="diakok/osztaly/">Osztály</a></li>
                        {/if}
                        {if $logged_in.permission % 2 == 1}
                        <li><a href="diakok/konzulens/">Konzultált témáim</a></li>
                        {/if}
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
                                    {if $logged_in.permission >= 8}    
                                    <th width="20"> </th>
                                    {/if}
                                    			
			<th>{$diakok_fields.nev}</th>
			<th>{$diakok_fields.diak_oszt_id}</th>
            <th>{$diakok_fields.felhasznalo_email}</th>
            <th>{$diakok_fields.valasztott_cim}</th>
            <th>{$diakok_fields.valasztott_status}</th>


                                    <th width="80">Műveletek</th>
                            	</thead>
                            	<tbody>
                                	{foreach $diakok_data as $row}
                                        <tr class="
                                        {if $row.valasztott_status == 'Elutasítva'}
                                        error
                                        {elseif $row.valasztott_status == 'Nincs' || $row.valasztott_status == 'Elfogadásra vár'}
                                        warning
                                        {elseif $row.valasztott_status == 'Teljesen elkészült'}
                                        success
                                        {else}
                                        {cycle values='odd,even'}
                                        {/if}
                                        "
                                        >
                                            {if $logged_in.permission >= 8}
                                            <td><input type="checkbox" class="checkbox" name="delete_ids[]" value="{$row.diak_felh_id}" /></td>
                                            {/if}
                                            				
				<td>{$row.diak_vnev} {$row.diak_knev} {$row.diak_knev2}</td>
				<td>{$row.diak_oszt_id}</td>
                <td><a href="mailto:{$row.felhasznalo_email}">{$row.felhasznalo_email}</a></td>
                <td>{$row.valasztott_cim}</td>
                <td>{$row.valasztott_status}</td>

                                            <td width="80">
                                                <a href="diakok/show/{$row.diak_felh_id}"><img src="iscaffold/images/view.png" alt="Show record" /></a>
                                                                        {if $logged_in.permission >= 8}
                                                <a href="diakok/edit/{$row.diak_felh_id}"><img src="iscaffold/images/edit.png" alt="Edit record" /></a>
                                                <a href="javascript:chk('diakok/delete/{$row.diak_felh_id}')"><img src="iscaffold/images/delete.png" alt="Delete record" /></a>
                                                                        {/if}
                                            </td>
                            		    </tr>
                                	{/foreach}
                            	</tbody>
                            </table>
                            <div class="actions-bar wat-cf">
                                <div class="actions">
                                    {if $logged_in.permission >= 8}
                                    <button class="button" type="submit">
                                        <img src="iscaffold/backend_skins/images/icons/cross.png" alt="Delete"> Kiválasztottak törlése
                                    </button>
                                    {/if}
                                </div>
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
