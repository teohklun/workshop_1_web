    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="City">City<span><?= isFieldRequired('City') == true ? ' *' : ''?></span></label>
            <input type="text" class="form-control" name="City" id="City" 
            value="<?= isset($input['City']) ? $input['City'] : ''?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="State">State<span><?= isFieldRequired('State') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="text" name="State" id="State" 
            value="<?= isset($input['State']) ? $input['State'] : ''?>">
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="Postcode">Postcode<span><?= isFieldRequired('Postcode') == true ? ' *' : ''?></span></label>
            <input type="text" class="form-control" name="Postcode" id="Postcode" 
            value="<?= isset($input['Postcode']) ? $input['Postcode'] : ''?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="Street">Street<span><?= isFieldRequired('Street') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="text" name="Street" id="Street" 
            value="<?= isset($input['Street']) ? $input['Street'] : ''?>">
        </div>
    </div>