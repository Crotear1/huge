<div class="box mt-2 card p-2">
    <h3>Bilder hochladen</h3>

    <form action="<?php echo Config::get('URL'); ?>cloud/upload" method="post" enctype="multipart/form-data">
        <label for="file">Wähle ein Bild aus</label>
        <input type="file" name="file" id="file" required>
        <input type="submit" value="Upload">
    </form>
</div>

<?php $this->renderFeedbackMessages(); ?>

<style>
    .card-image-hover {
        position: relative;
        overflow: hidden;
    }
    .card-image-hover img {
        width: 100%;
    }
    .card-image-hover .card-hover-buttons {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card-image-hover:hover .card-hover-buttons {
        opacity: 1;
    }
</style>

<div class="container mt-2">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Meine Bilder</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach($this->imageNames as $imageName): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-image-hover">
                                <img src="<?php echo Config::get('URL')?>cloud/showImages/<?php echo $imageName; ?>" class="card-img-top img-fluid">
                                <div class="card-hover-buttons">
                                    <!-- <form class="myForm" action="<?php echo Config::get('URL'); ?>cloud/shareImage/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" class="myInput" name="imageName" value="<?php echo $imageName; ?>">
                                        <button type="submit" class="btn btn-success copyBtn" onclick="event.preventDefault(); copyToClipboard('<?php echo Session::get('user_id') ?>', '<?php echo $imageName; ?>', this.parentElement)"><i class="fa fa-share"></i></button>
                                    </form>
                                    <form action="<?php echo Config::get('URL'); ?>cloud/deleteImage/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="imageName" value="<?php echo $imageName; ?>">
                                        <button type="submit" class="btn btn-primary ml-2"><i class="fa fa-trash"></i></button>
                                    </form> -->
                                    <form action="<?php echo Config::get('URL'); ?>cloud/sendEmail/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="imageName" value="<?php echo $imageName; ?>">
                                        <input type="email" name="email" placeholder="Email" required>
                                        <button type="submit" class="btn btn-primary ml-2"><i class="fa fa-download"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(userId, imageName, form) {
    var url = "<?php echo Config::get('URL'); ?>";
    var fullUrl = url + "cloud/shared/" + userId + "/" + imageName;

    navigator.clipboard.writeText(fullUrl);

    alert("Copied the text: " + fullUrl);

    form.submit();
}
</script>
