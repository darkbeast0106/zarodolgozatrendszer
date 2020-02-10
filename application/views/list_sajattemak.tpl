<div class="block" id="block-tables">
                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="temak">Összes</a></li>
                        <li class="active"><a href="temak/own">Saját</a></li>
                        <li><a href="temak/create/">Téma felvétele</a></li>
                    </ul>
                </div>
                <div class="content">
                    <div class="inner">
                        <h3>Témák</h3>

                        {if !empty($temak_data)}
                        <form action="temak/delete" method="post" id="listing_form"> 
                            <table class="table">
                            	<thead>
                                    <th width="20"> </th>
                                    			
			<th>{$temak_fields.tema_cim}</th>
			<th>{$temak_fields.tema_leiras}</th>
			<th>{$temak_fields.tema_eszkozok}</th>
			<!-- <th>{$temak_fields.tema_evszam}</th> -->
                                    
                                    <th width="80">Műveletek</th>
                                    
                            	</thead>
                            	<tbody>
                                    {foreach $temak_data as $row}
                                        <tr class="{cycle values='odd,even'}">
                                            <td><input type="checkbox" class="checkbox" name="delete_ids[]" value="{$row.tema_id}" /></td>
                                            
                                                            
                <td>{$row.tema_cim}</td>
                <td>{$row.tema_leiras}</td>
                <td>{$row.tema_eszkozok}</td>
                <!-- <td>{$row.tema_evszam}</td> -->
                                            <td width="80">
                                                <a href="temak/show/{$row.tema_id}"><img src="iscaffold/images/view.png" alt="Részletes megjelenítés" /></a>
                                                <a href="temak/edit/{$row.tema_id}"><img src="iscaffold/images/edit.png" alt="Téma módosítása" /></a>
                                                <a href="javascript:chk('temak/delete/{$row.tema_id}')"><img src="iscaffold/images/delete.png" alt="Téma törlése" /></a>
                                            </td>
                                        </tr>
                                    {/foreach}
                            	</tbody>
                            </table>
                            <div class="actions-bar wat-cf">
                                <div class="actions">
                                    <button class="button" type="submit">
                                        <img src="iscaffold/backend_skins/images/icons/cross.png" alt="Delete"> Kiválasztottak törlése
                                    </button>
                                </div>
                                <div class="pagination">
                                    {$pager}
                                </div>
                            </div>
                        </form>
                        {else}
                            Nem található bejegyzés.
                        {/if}

                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
