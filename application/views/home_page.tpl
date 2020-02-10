<div class="block" id="block-tables">

                <div class="content">
                    <div class="inner">
                      <h1>Üdvözöllek a Petrik Lajos SZG Záródolgozati konzultációs rendszerében.</h1>
                      <p><b>A záródolgozat témaválasztás rendjéről <a href="iscaffold/documents/temavalasztas_rendje.pdf" target="_blank">itt</a> találsz információt</b></p>
                      <p><b>A záródolgozat tartalmi és formai követelményeiről <a href="iscaffold/documents/kovetelmenyek.pdf" target="_blank">itt</a> találsz információt</b></p>
                      <h3>Fontosabb határidők</h3>
                  	<table id="hataridok">
                  	{foreach $hataridok_data as $row}
                  	
                    	<tr>
							<td> - </td>                                            				
							<td>{$row.hatarido_megnevezes}: </td>
							<td>{$row.hataridok_ertek}</td>
						</tr>
                	{/foreach}
                	</table>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
