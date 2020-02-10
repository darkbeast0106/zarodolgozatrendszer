<div class="block" id="block-tables">

                <div class="content">
                    <div class="inner">
                        <h3>Határidők</h3>

                        {if !empty( $hataridok_data )}
                        <form action="hataridok/delete" method="post" id="listing_form">
                            <table class="table">
                            	<thead>
                
                                    			
			<th>{$hataridok_fields.hatarido_megnevezes}</th>
			<th>{$hataridok_fields.hataridok_ertek}</th>
                                    {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                    <th width="80">Műveletek</th>
                                    {/if}
                            	</thead>
                            	<tbody>
                                	{foreach $hataridok_data as $row}
                                        <tr class="{cycle values='odd,even'}">
                                            				
				<td>{$row.hatarido_megnevezes}</td>
				<td>{$row.hataridok_ertek}</td>
                                            {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                            <td width="80">
                                             <!--    <a href="hataridok/show/{$row.hatarido_id}"><img src="iscaffold/images/view.png" alt="Show record" /></a> -->
                                                <a href="hataridok/edit/{$row.hatarido_id}"><img src="iscaffold/images/edit.png" alt="Határidő módosítása" /></a>
                                             </td>
                                            {/if}
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
                            No records found.
                        {/if}

                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
