<div class="block" id="block-tables">

                {if $logged_in.permission >= 8}
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first active"><a href="osztalyok">Osztályok</a></li>
                        <li><a href="osztalyok/create/">Új osztály felvétele</a></li>
                    </ul>
                </div>
                {/if}

                <div class="content">
                    <div class="inner">
                        <h3>Osztályok</h3>

                        {if !empty( $osztalyok_data )}
                        <form action="osztalyok/delete" method="post" id="listing_form">
                            <table class="table">
                            	<thead>
                                    {if $logged_in.permission >= 8}
                                    <th width="20"> </th>
                                    			{/if}
			<th>{$osztalyok_fields.osztaly_nev}</th>
			<th>{$osztalyok_fields.osztalyfonok_id}</th>
			<th>{$osztalyok_fields.vegzes_eve}</th>

                                    <th width="80">Műveletek</th>
                            	</thead>
                            	<tbody>
                                	{foreach $osztalyok_data as $row}
                                        <tr class="{cycle values='odd,even'}">
                                            {if $logged_in.permission >= 8}
                                            <td><input type="checkbox" class="checkbox" name="delete_ids[]" value="{$row.osztaly_id}" /></td>
                                            				{/if}
				<td>{$row.osztaly_nev}</td>
				<td>{$row.osztalyfonok_id}</td>
				<td>{$row.vegzes_eve}</td>

                                            <td width="80">
                                                <a href="osztalyok/show/{$row.osztaly_id}"><img src="iscaffold/images/view.png" alt="Show record" /></a>
                                                {if $logged_in.permission >= 8}
                                                <a href="osztalyok/edit/{$row.osztaly_id}"><img src="iscaffold/images/edit.png" alt="Edit record" /></a>
                                                <a href="javascript:chk('osztalyok/delete/{$row.osztaly_id}')"><img src="iscaffold/images/delete.png" alt="Delete record" /></a>
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
