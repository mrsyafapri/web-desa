<?php
require_once __DIR__ . "/includes/configuration.php";
require_once __DIR__ . "/includes/class.php";
require_once __DIR__ . "/includes/function.php";

$app = new WebApplication($cfg);
// cek apakah sudah login
if ($app->getUser()->id != 0) {
    header("Location: " . $app->siteUrl . "/admin.php");
    exit;
}

// login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $sql = "SELECT *
                FROM pengguna
                WHERE username=:username AND password=:password";
    $params = array(
        ":username" => $username,
        ":password" => $password
    );
    $obj = $app->queryObject($sql, $params);
    if ($obj) {
        $objUserAccount = new UserAccount();
        $objUserAccount->id = $obj->id;
        $objUserAccount->username = $obj->username;

        $_SESSION = array();
        $_SESSION['user'] = $objUserAccount;

        header("Location:" . $app->siteUrl . "/admin.php");
    } else {
        $error = "Username atau password salah";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="Web Desa Teluk Jira">
    <meta name="author" content="KKN UIN SUSKA Riau 2023">

    <title>Login Admin -
        <?= $app->siteName; ?>
    </title>

    <link rel="shortcut icon" type="image/png" href="<?= $app->siteUrl; ?>/public/img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= $app->siteUrl; ?>/public/css/style.css">
</head>

<body class="my-bg-primary">
    <div class="container my-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <div class="card p-2">
                    <div class="card-header bg-transparent border-0">
                        <div class="text-center">
                            <img src="<?= $app->siteUrl; ?>/public/img/logo.png" alt="Logo" class="img-fluid" width="100">
                        </div>
                    </div>
                    <div class="card-body py-4 px-md-4">
                        <form method="post">
                            <h2 class="text-center mb-4">Login Admin</h2>
                            <?php if (isset($error)) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= $error; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <div class="form-outline mb-4">
                                <label class="form-label fw-bold" for="username">Username</label>
                                <input type="text" id="username" class="form-control" name="username" required autofocus />
                            </div>
                            <div class="form-outline mb-4">
                                <label class="form-label fw-bold" for="password">Password</label>
                                <input type="password" id="password" class="form-control" name="password" required />
                            </div>
                            <div class="text-center text-lg-start d-grid gap-2 mx-auto">
                                <button type="submit" class="btn btn-primary my-bg-primary text-uppercase fw-bold btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</body>

</html>