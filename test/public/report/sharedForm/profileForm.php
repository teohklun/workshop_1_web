<label class="form-label" for="Profile">Profile</label>

<div class="form-row">
    <div class="col-md-3 mb-3">
        <label for="IC">IC</label>
        <input class="form-control" type="text" name="IC" id="IC" value="<?= isset($input['IC']) ? $input['IC'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label for="Name">Name <span><?= isFieldRequired('Name');?></span></label>
        <input class="form-control" type="text" name="Name" id="Name" value="<?= isset($input['Name']) ? $input['Name'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
        <label for="Email">Email</label>
        <input class="form-control" type="text" name="Email" id="Email" value="<?= isset($input['Email']) ? $input['Email'] : '' ?>">
    </div>
    <div class="col-md-3 mb-3">
          <label for="ContactNo">ContactNo</label>
          <input class="form-control" type="text" name="ContactNo" id="ContactNo" value="<?= isset($input['ContactNo']) ? $input['ContactNo'] : '' ?>">
    </div>
</div>