<div class="block" id="block-tables">

                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="userdata/editpass">Jelszó módosítása</a></li>
                        <li class="active"><a href="userdata/editemail">E-mail módosítása</a></li>
                        {if $logged_in.permission > 0 && $logged_in.permission % 2 == 1}
                        <li><a href="userdata/editferohely">Férőhely módosítása módosítása</a></li>
                        {/if}
                    </ul>
                </div>

                <div class="content">
                    <div class="inner">
                            <h3>E-mail módosítása</h3>
                        {if isset($errors)}
                            <div class="flash">
                                <div class="message error">
                                    <p>{$errors}</p>
                                </div>
                            </div>
                        {/if}
                        {if isset($success)}
                            <div class="flash">
                                <div class="message success">
                                    <p>{$success}</p>
                                </div>
                            </div>
                        {/if}

                        <form class="form" method='post' action='userdata/{$action_mode}/' enctype="multipart/form-data">

        <div class="group">
            <label class="label">{$felhasznalok_fields.felhasznalo_email}</label>
            <div>
                <input class="text_field" type="email" maxlength="255" value="{if isset($felhasznalok_data)}{$felhasznalok_data.felhasznalo_email}{/if}" name="felhasznalo_email" />
            </div>
            
        </div>

       	<div class="group">
            <label class="label">Megerősítéshez {$felhasznalok_fields.felhasznalo_jelszo}<span class="error">*</span></label>
    		<div>
    	       	<input class="text_field" type="password" maxlength="255" value="" name="felhasznalo_jelszo" />
    		</div>
    		
    	</div>
    
	                        <div class="group navform wat-cf">
                                    <button class="button" type="submit">
                                        Módosítás
                                    </button>
                            </div>
                        </form>
                    </div><!-- .inner -->
                </div><!-- .content -->
            </div><!-- .block -->
