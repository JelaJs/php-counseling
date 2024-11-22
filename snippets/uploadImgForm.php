<div class="card-body">
    <h5 class="card-title"><?= $username; ?></h5>
    <form action="controller/uploadController.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" class="btn p-0">
        <button type="submit" name="submit" class="btn btn-primary mt-1">Upload Image</button>
    </form>
</div>