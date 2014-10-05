<div class="row">
  <div class="col-md-12">
    Hi all! Issue right now with timezone being off. These times are 2 hours back from EST!
  </div>
</div>
<div class="row">
  <div class="col-md-4"></div>
  <div class="col-md-4">
    <ul class="list-group">
      <?php foreach($logins as $login): ?>
        <li class="list-group-item">
          <h4 class="list-group-item-heading"><?php echo $login["UserName"] ?></h4>
          <div class="list-group-item-text">
            Logged in: <?php echo $login["Login"] ?>, LastAction: <?php echo $login["LastAction"] ?>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="col-md-4"></div>
</div>
