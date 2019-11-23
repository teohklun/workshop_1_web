<label class="form-label" for="Address">Address</label>

<div class="form-row">
    <div class="col-md-3 mb-3">
        <label for="City">City</label>
        <input class="form-control" type="text" name="City" id="City" value="<?= isset($input['City']) ? $input['City'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label for="State">State</label>
        <input class="form-control" type="text" name="State" id="State" value="<?= isset($input['State']) ? $input['State'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label for="Postcode">Postcode</label>
        <input class="form-control" type="text" name="Postcode" id="Postcode" value="<?= isset($input['Postcode']) ? $input['Postcode'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label for="Street">Street</label>
        <input class="form-control" type="text" name="Street" id="Street" value="<?= isset($input['Street']) ? $input['Street'] : '' ?>">
    </div>
</div>