<div class="block" id="block-tables">
                {if isset($logged_in.permission) && $logged_in.permission % 2 == 1}

                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first active"><a href="temak">Összes</a></li>
                        <li><a href="temak/own">Saját</a></li>
                        <li><a href="temak/create/">Téma felvétele</a></li>
                    </ul>
                </div>
                {/if}
                <div class="content">
                    <div class="inner">
                        <h3>Témák</h3>

                        {if !empty($temak_data)}
                        <form action="temak/delete" method="post" id="listing_form"> 
                            <table class="table">
                            	<thead>
                                    {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                    <th width="20"> </th>
                                    {/if}
                                    			
			<th>{$temak_fields.kiiro_id}</th>
			<th>{$temak_fields.tema_cim}</th>
			<th>{$temak_fields.tema_leiras}</th>
			<th>{$temak_fields.tema_eszkozok}</th>
			<!-- <th>{$temak_fields.tema_evszam}</th> -->
                                    {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                    <th width="80">Műveletek</th>
                                    {/if}
                            	</thead>
                            	<tbody>
                                    {foreach $temak_data as $row}
                                        <tr class="{cycle values='odd,even'}">
                                            {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                            <td><input type="checkbox" class="checkbox" name="delete_ids[]" value="{$row.tema_id}" /></td>
                                            {/if}
                                                            
                <td>{$row.kiiro_id}</td>
                <td>{$row.tema_cim}</td>
                <td>{$row.tema_leiras}</td>
                <td>{$row.tema_eszkozok}</td>
                <!-- <td>{$row.tema_evszam}</td> -->
                                            {if isset($logged_in.permission) && $logged_in.permission >= 8}
                                            <td width="80">
                                                <!-- <a href="temak/show/{$row.tema_id}"><img src="iscaffold/images/view.png" alt="Show record" /></a>
                                                <a href="temak/edit/{$row.tema_id}"><img src="iscaffold/images/edit.png" alt="Edit record" /></a> -->
                                                <a href="javascript:chk('temak/delete/{$row.tema_id}')"><img src="iscaffold/images/delete.png" alt="Téma törlése" /></a>
                                            </td>
                                            {/if}
                                        </tr>
                                    {/foreach}
                            	</tbody>
                            </table>
                            <div class="actions-bar wat-cf">
                                {if isset($logged_in.permission) && $logged_in.permission >= 8}
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
