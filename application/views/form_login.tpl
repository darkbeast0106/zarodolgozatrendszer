
    <div id="box">
      <div class="block" id="block-login">
        <h2>Jelentkezzen be</h2>
        <div class="content login">
		{if isset($error)}
          <div class="flash">
            <div class="message error">
              <p>Hibás felhasználónév vagy jelszó!</p>
            </div>
          </div>
		{/if}
          <form action="login/validate" class="form login" method="post" enctype="multipart/form-data">
            <div class="group wat-cf">
              <div class="left">
                <label class="label right">Felhasználónév</label>
              </div>
              <div class="right">
                <input type="text" name="user" class="text_field" />
              </div>
            </div>
            <div class="group wat-cf">
              <div class="left">
                <label class="label right">Jelszó</label>
              </div>
              <div class="right">
                <input type="password" name="pass" class="text_field" />
              </div>
            </div>
            <div class="group navform wat-cf">
              <div class="right">
                <button class="button" type="submit">
                  <img src="iscaffold/backend_skins/images/icons/key.png" alt="Save" /> Bejelentkezés
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>