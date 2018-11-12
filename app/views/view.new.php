<form class="" id="firmware" action="/firmware/build" method="post">

  <hr>

  <div class="form-group row">
    <label for="company" class="col-sm-2 col-form-label">Company Name: </label>
    <div class="col-md-10 col-form-label">
      <input name="company" class="form-control col-sm-4" id="company">
    </div>
  </div>

  <div class="form-group row">
    <label for="model" class="col-sm-2 col-form-label">STB Model: </label>
    <div class="col-md-10 col-form-label">
      <select name="model" class="form-control col-sm-4" id="model">
        <?php foreach($models as $model): ?>
          <option value="<?=$model?>">MAG<?=$model?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <label for="rootfs_version" class="col-sm-2 col-form-label">Version Number: </label>
    <div class="col-md-10 col-form-label">
      <select name="rootfs_version" class="form-control col-sm-4" id="rootfs_version">
        <?php foreach($versions as $version): ?>
          <option value="<?=$version?>"><?=$version?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <hr>

  <div class="form-group row">
    <label for="image_number" class="col-sm-2 col-form-label">Image Version: </label>
    <div class="col-md-10 col-form-label">
      <input name="image_number" class="form-control col-sm-4" id="image_number">
    </div>
  </div>

  <div class="form-group row">
    <label for="image_desc" class="col-sm-2 col-form-label">Image Description: </label>
    <div class="col-md-10 col-form-label">
      <input name="image_desc" class="form-control col-sm-4" id="image_desc">
    </div>
  </div>

  <hr>

    <?php foreach($env['inputs'] as $item): ?>

      <div class="form-group row">
        <label for="<?=$item['name']?>" class="col-sm-2 col-form-label"><?=$item['label']?> </label>
        <div class="col-md-10 form-inline col-form-label">
          <input name="env_<?=$item['name']?>" class="form-control col-sm-4" id="<?=$item['name']?>">
          <input name="checked_env_<?=$item['name']?>" id="check_<?=$item['name']?>" class="form-check-input" style="margin-left: 5px;" type="checkbox">Check
        </div>
      </div>

    <?php endforeach; ?>

    <?php foreach($env['selects'] as $item): ?>

      <div class="form-group row">
        <label for="<?=$item['name']?>" class="col-sm-2 col-form-label"><?=$item['label']?> </label>
        <div class="col-md-10 form-inline col-form-label">
          <select name="env_<?=$item['name']?>" class="form-control col-sm-4" id="<?=$item['name']?>">
            <?php foreach($item['values'] as $value => $label): ?>
              <option value="<?=$value?>"><?=$label?></option>
            <?php endforeach; ?>
          </select>
          <input name="checked_env_<?=$item['name']?>" id="check_<?=$item['name']?>" class="form-check-input" style="margin-left: 5px;" type="checkbox">Check
        </div>
      </div>

    <?php endforeach; ?>

    <?php foreach($env['radios'] as $item): ?>

      <div class="form-group row">
        <label for="<?=$item['name']?>" class="col-sm-2 col-form-label"><?=$item['label']?> </label>
        <div class="col-md-10 form-inline col-form-label">
          <?php foreach ($item['values'] as $value => $label): ?>
            <label class="radio-inline col-sm-2">
              <input type="radio" name="env_<?=$item['name']?>" value="<?=$value?>"><?=$label?>
            </label>
          <?php endforeach; ?>
          <input name="checked_env_<?=$item['name']?>" id="check_<?=$item['name']?>" class="form-check-input" style="margin-left: 5px;" type="checkbox">Check
        </div>
      </div>

    <?php endforeach; ?>

  <button type="submit" class="btn">Build!</button>

</form>

<script type="text/javascript">
$(document).ready(function () {

  $.validator.addMethod( "pattern", function( value, element, param ) {
  	if ( this.optional( element ) ) {
  		return true;
  	}
  	if ( typeof param === "string" ) {
  		param = new RegExp( "^(?:" + param + ")$" );
  	}
  	return param.test( value );
  }, "Invalid format, must be like 0x00RRGGBB" );

  $.validator.addMethod( "alphanumeric", function( value, element ) {
	   return this.optional( element ) || /^\w+$/i.test( value );
   }, "Letters, numbers, and underscores only please" );

  $.validator.addMethod( "nowhitespace", function( value, element ) {
	   return this.optional( element ) || /^\S+$/i.test( value );
  }, "No white space please" );

  $.validator.methods.url = function( value, element ) {
    return this.optional( element ) || /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[\/?#]\S*)?$/i.test( value );
  }

  $("#firmware").validate({
      rules: {

        company: {
          required: true,
          alphanumeric: true,
          nowhitespace: true
        },

        rootfs_version: {
          required: true
        },

        model: {
          required: true,
        },

        image_number: {
          required: true,
          digits: true,
          minlength: 3,
          maxlength: 3
        },

        image_desc: {
          required: true,
          nowhitespace: true,
          alphanumeric: true
        },

        env_bg_color: {
          pattern: /^0x([0-9A-F]){8}$/
        },

        env_fg_color: {
          pattern: /^0x([0-9A-F]){8}$/
        },

        env_audio_initial_volume: {
          digits: true,
          range: [0, 100]
        },

        env_input_buffer_size: {
          digits: true,
          range: [0, 20000]
        },

        env_portal1: {
          required: true,
          url: true
        },

        env_portal2: {
          url: true
        },

        env_update_url: {
          required: true,
          url: true
        },

        env_autoupdateURL: {
          url: true
        },

        env_timezone_conf: {
          required: true
        },

        env_bootTVsystem: {
          required: true
        },

        env_tvsystem: {
          required: true,
        },

        env_graphicres: {
          required: true,
        },

        env_autoupdate_cond: {
          required: true,
        },

      }

    });
  });
</script>
