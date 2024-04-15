<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="box mt-2 card p-2">
    <h3>Bilder hochladen</h3>

    <form action="<?php echo Config::get('URL'); ?>cloud/upload" method="post" enctype="multipart/form-data">
        <label for="file">Wähle ein Bild aus</label>
        <input type="file" name="file" id="file" required>
        <input type="submit" value="Upload">
    </form>
</div>

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
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <div class="card-image-hover">
                                <img src="<?php echo Config::get('URL')?>cloud/showImages/<?php echo $imageName; ?>" class="card-img-top img-fluid">
                                <div class="card-hover-buttons">
                                    <form action="<?php echo Config::get('URL'); ?>cloud/shareImage/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="imageName" value="<?php echo $imageName; ?>">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-share"></i></button>
                                    </form>
                                    <form action="<?php echo Config::get('URL'); ?>cloud/deleteImage/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="imageName" value="<?php echo $imageName; ?>">
                                        <button type="submit" class="btn btn-primary ml-2"><i class="fa fa-trash"></i></button>
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
