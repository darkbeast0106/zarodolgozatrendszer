<div class="block" id="block-tables">
                {if $logged_in.permission >= 8}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first active"><a href="tanarok">Tanárok</a></li>
                        <li><a href="tanarok/create/">Új tanár felvétele</a></li>
                    </ul>
                </div>
                {/if}

                <div class="content">
                    <div class="inner">
                        <h3>Tanárok</h3>

                        {if !empty( $tanarok_data )}
                        <form action="tanarok/delete" method="post" id="listing_form">
                            <table class="table">
                            	<thead>
                                    {if $logged_in.permission >= 8}
                                    <th width="20"> </th>
                                    {/if}
                                    			
			<th>{$tanarok_fields.nev}</th>
            <th>{$tanarok_fields.felhasznalo_email}</th>
			<th>{$tanarok_fields.tanar_jogosultsag_id}</th>
            <th>{$tanarok_fields.tanar_ferohely}</th>

                                    <th width="80">Actions</th>
                            	</thead>
                            	<tbody>
                                	{foreach $tanarok_data as $row}
                                        <tr class="{cycle values='odd,even'}">
                                            {if $logged_in.permission >= 8}
                                            <td><input type="checkbox" class="checkbox" name="delete_ids[]" value="{$row.tanar_felh_id}" /></td>
                                            {/if}
                                            				
				<td>{$row.tanar_vnev} {$row.tanar_knev} {$row.tanar_knev2}</td>
                <td><a href="mailto:{$row.felhasznalo_email}">{$row.felhasznalo_email}</a></td>
				<td>{$row.tanar_jogosultsag_id}</td>
                <td>{$row.tanar_ferohely}</td>
                                            <td width="80">
                                                <a href="tanarok/show/{$row.tanar_felh_id}"><img src="iscaffold/images/view.png" alt="Show record" /></a>
                                                {if $logged_in.permission >= 8}
                                                <a href="tanarok/edit/{$row.tanar_felh_id}"><img src="iscaffold/images/edit.png" alt="Edit record" /></a>
                                                <a href="javascript:chk('tanarok/delete/{$row.tanar_felh_id}')"><img src="iscaffold/images/delete.png" alt="Delete record" /></a>
                                                {/if}
                                            </td>
                            		    </tr>
                                	{/foreach}
                            	</tbody>
                            </table>
                            <div class="actions-bar wat-cf">
                                {if $logged_in.permission >= 8}
                                <div class="actions">
                                    <button class="button" type="submit">
                                        <img src="iscaffold/backend_skins/images/icons/cross.png" alt="Delete"> Kiválasztottak törlése
                                    </button>
                                </div>
                                {/if}
                                <div class="pagination">
                                    {$pager}
                                </div>
                            </div>
                        </form>
                        {else}
                            No records found.
                        {/if}

                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
