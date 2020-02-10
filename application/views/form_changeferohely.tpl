<div class="block" id="block-tables">

                <div class="secondary-navigation">
                    <ul class="wat-cf">
                        <li class="first"><a href="userdata/editpass">Jelszó módosítása</a></li>
                        <li><a href="userdata/editemail">E-mail módosítása</a></li>
                        <li class="active"><a href="userdata/editferohely">Férőhely módosítása módosítása</a></li>
                        
                    </ul>
                </div>

                <div class="content">
                    <div class="inner">
                            <h3>Férőhely módosítása</h3>
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
            <label class="label">{$tanarok_fields.tanar_ferohely}</label>
            <div>
                <input class="text_field" type="number" min="0" max="100" value="{if isset($tanarok_data)}{$tanarok_data.tanar_ferohely}{/if}" name="tanar_ferohely" />
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
