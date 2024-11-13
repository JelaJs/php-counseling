    <div class="container">
        <?php if(isset($_GET['success_register']) && isset($_SESSION['success_register'])) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <p><?= $_SESSION['success_register']; ?></p>
                <?php unset($_SESSION['success_register']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        <?php endif; ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <div class="row">
                    <!-- Logo on the left side -->
                     <?php if(isset($_SESSION['user_id'])) : ?>
                        <a href="index.php" class="navbar-brand">You're logged in as: <?= $_SESSION['username']; ?></a>
                     <?php else : ?>
                        <a href="index.php" class="navbar-brand">MyWebsite</a>
                     <?php endif; ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!-- Menu items on the right side -->
                 <div class="row">
                     <div class="collapse navbar-collapse" id="navbarNav">
                         <ul class="navbar-nav ml-auto">
                             <?php if(isset($_SESSION['user_id'])) : ?>
                                 <li class="nav-item">
                                     <a class="nav-link" href="controller/logout.php">Logout</a>
                                 </li>
                             <?php else : ?>
                                 <li class="nav-item">
                                     <a class="nav-link" href="login.php">Login</a>
                                 </li>
                                 <li class="nav-item">
                                     <a class="nav-link" href="register.php">Register</a>
                                 </li>
                             <?php endif; ?>
                         </ul>
                     </div>
                 </div>
            </div>
        </nav>
    </div>