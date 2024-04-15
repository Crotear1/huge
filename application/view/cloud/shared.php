<?php
  // Get current URL
  $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  // Parse URL
  $urlParts = parse_url($url);

  // Get path and split it into parts
  $pathParts = explode('/', trim($urlParts['path'], '/'));

  // Check if the URL is in the expected format
  if(count($pathParts) >= 9 && $pathParts[6] == 'shared') {
      $id = $pathParts[7];
      $imageName = $pathParts[8];

      $sharedImage = Config::get('URL') . "cloud/checkIfSharedImageExists" . '/' . $id . '/' . $imageName;
  }
?>

<div class="card mx-auto" style="width: 50rem;">
  <img src="<?php echo $sharedImage?>" class="card-img-top img-fluid rounded">
  <div class="card-body">
    <h5 class="card-title">Shared Image</h5>
    <?php if(Session::get('user_id') == $id): ?>
      <form action="<?php echo Config::get('URL'); ?>cloud/removeSharedImage/<?php echo $imageName;?>" method="post" enctype="multipart/form-data">
          <input type="hidden" name="imageName" value="<?php echo $imageName; ?>">
          <button type="submit" class="btn btn-primary" style="background-color: red;"><i class="fa fa-trash"></i> Remove</button>
      </form>
    <?php endif; ?>
  </div>
</div>
