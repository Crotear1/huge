

<h1>Uploaded Pictures</h1>

<!-- echo out the system feedback (error and success messages) -->
<?php $this->renderFeedbackMessages(); ?>

<div class="box">
    <h3>Upload a new picture</h3>

    <form action="<?php echo Config::get('URL'); ?>cloud/upload" method="post" enctype="multipart/form-data">
        <label for="file">Select a file to upload</label>
        <input type="file" name="file" id="file" required>
        <input type="submit" value="Upload">
    </form>
</div>

<div class="box">
    <h3>My Pictures</h3>

    <div class="row">
        <?php foreach($this->imageNames as $imageName): ?>
            <div class="col-md-3">
                <img src="<?php echo Config::get('URL')?>cloud/showImages/<?php echo $imageName; ?>" class="img-fluid">
            </div>
        <?php endforeach; ?>

    </div>
</div>
