<?php
require_once "Classes/UserDiscution.php";
require_once "Classes/SessionConfig.php";

$session = new SessionConfig();
$discution = new UserDiscution();

$session->startSession();

if(!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header('Location: index.php');
    die();
}

$curDiscution = $discution->getDiscutionByDiscutionId($_GET['id']);

?>

<?php require_once "snippets/header.php"; ?>
    <?php require_once "snippets/navbar.php"; ?>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <form action="controller/renameDiscutionController.php" method="POST">
                        <input type="text" name="heading" value="<?= $curDiscution['topic']; ?>" class="form-control">
                        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
                        <button>Rename</button>
                        <a href="index.php">Cancel</a>
                    </form>
                </div>
            </div>
            <?php if(isset($_SESSION['invalidId'])) : ?>
                <p><?= $_SESSION['invalidId']; ?></p>
                <?php unset($_SESSION['invalidId']); ?>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['emptyHeader'])) : ?>
                <p><?= $_SESSION['emptyHeader']; ?></p>
                <?php unset($_SESSION['emptyHeader']); ?>
            <?php endif; ?>
        </div>
    </div>
<?php require_once "snippets/footer.php"; ?>