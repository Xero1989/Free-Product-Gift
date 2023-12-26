<div style="padding-right: 2%;">

    <form id="wpb_form_admin">
        <br>
        <h1>Settings</h1>
        <br>

        @foreach($options as $key => $value)
        <?php
        $key_modified = str_replace("wpb_", "", $key);
        $key_modified = str_replace("_", " ", $key_modified);
        ?>
        <div class="mb-3 row">
            <label class="col-form-label"><b>{{$key_modified}}:</b></label>
            <br>
            <input type="text" class="frm-control-plaintext" id="{{$key}}" value="{{$value}}">
        </div>
        @endforeach

        <br>

        <button type="button" class="btn btn-primary bt_save_settings">Save Settings</button>

        <br>

    </form>

</div>