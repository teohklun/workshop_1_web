<label class="form-label" for="Profile">Profile</label>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="ContactNo">Contact No<span><?= isFieldRequired('ContactNo') == true ? ' *' : ''?></span></label>
            <input type="text" class="form-control" name="ContactNo" id="ContactNo" 
            <?= isFieldRequired('ContactNo') ?>
            value="<?= isset($input['ContactNo']) ? $input['ContactNo'] : ''?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="Name">Name<span><?= isFieldRequired('Name') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="text" name="Name" id="Name" 
            <?= isFieldRequired('Name') ?>
            value="<?= isset($input['Name']) ? $input['Name'] : ''?>">
        </div>

    </div>

    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="IC">IC<span><?= isFieldRequired('IC') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="text" name="IC" id="IC" 
            <?= isFieldRequired('IC') ?>
            value="<?= isset($input['IC']) ? $input['IC'] : ''?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="Email">Email<span><?= isFieldRequired('Email') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="text" name="Email" id="Email" 
            <?= isFieldRequired('Email') ?>
            value="<?= isset($input['Email']) ? $input['Email'] : ''?>">
        </div>

    </div>
        <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="picture">picture<span><?= isFieldRequired('img') == true ? ' *' : ''?></span></label>
            <input class="form-control" type="file" name="img" id="img" 
            <?= isFieldRequired('img') ?>
            value="<?= isset($input['ProfilePath']) ? $input['ProfilePath'] : ''?>">
            <blockquote id='img-error' class='hidden error-message'>file uploaded must me image</blockquote>
            <div class='container-img'>
                <img class="<?= isset($input['ProfilePath']) && $input['ProfilePath'] !== '' ? '' : 'hidden' ?> preview-img" id='preview-img' src='<?= isset($input['ProfilePath']) ? $input['ProfilePath'] : '' ?>'/>
                <div class='<?= isset($input['ProfilePath']) && $input['ProfilePath'] !== '' ? '' : 'hidden' ?> overlay'>
                    <div class='icon'>
                        x
                    </div>
                </div>
                <input type='hidden' name='DelProfile' value='0' id='del-profile-path'>
            </div>
        </div>
    </div>

<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        if (file.type.match('image.*')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // document.getElementById('preview-img').src = window.URL.createObjectURL(input.files[0])
                $('.preview-img').attr('src',window.URL.createObjectURL(input.files[0]));
                $('.hidden.preview-img').removeClass('hidden');
                $('#img-error').addClass('hidden');
                $('.hidden.overlay').removeClass('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('.hidden.error-message').removeClass('hidden');
        }
    }
}

$('.overlay').click(function(){
    var path = $('.preview-img').attr('src');
    var fileName = path.split('/').pop();
    $('#del-profile-path').val('1');
    $('.preview-img').attr('src','');
    $('.overlay').addClass('hidden');
    $('.preview-img').addClass('hidden');
    $('#img').val('');
})

$("#img").change(function() {
readURL(this);
});
</script>

<label class="form-label" for="Address" 
<?= isFieldRequired('Address') ?>
value="<?= isset($input['Address']) ? $input['Address'] : ''?>">Address</label>
<br/>
