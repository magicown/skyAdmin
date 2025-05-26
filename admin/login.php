<?php
// 로그인 실패 시 에러 메시지를 표시하기 위한 PHP 코드
$error_message = null;
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $error_message = '아이디 또는 비밀번호가 일치하지 않습니다.';
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr" data-startbar="dark" data-bs-theme="light">
    <head>        
        <meta charset="utf-8" />
        <title>관리자 로그인 - 베팅 솔루션</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="통합 베팅 솔루션 관리자 페이지" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="shortcut icon" href="../assets/images/favicon.ico">
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
         <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
         <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
         <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" type="text/css" />
    </head>
    
    <body class="bg-black">
        <div class="container-fluid">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 col-lg-6 col-xl-4 col-xxl-3 mx-auto">
                                <div class="card">
                                    <div class="card-body p-0 bg-black auth-header-box rounded-top">
                                        <div class="text-center p-3">
                                            <a href="login.php" class="logo logo-admin">
                                                <img src="../assets/images/logo-sm.png" height="50" alt="logo" class="auth-logo">
                                            </a>
                                            <h4 class="mt-3 mb-1 fw-semibold text-white fs-18">Betting Solution</h4>
                                           <p class="text-muted fw-medium mb-0">관리자 로그인을 진행해주세요.</p>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <?php if ($error_message): ?>
                                            <div class="alert alert-danger text-center mt-3" role="alert">
                                                <?php echo $error_message; ?>
                                            </div>
                                        <?php endif; ?>

                                        <form class="my-4" action="login_process.php" method="post">
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="admin_username">Admin Username</label>
                                                <input type="text" class="form-control" id="admin_username" name="admin_username" placeholder="Enter username" required>
                                            </div><div class="form-group">
                                                <label class="form-label" for="userpassword">Password</label>                                                                                        
                                                <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password" required>
                                            </div><div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <div class="d-grid mt-3">
                                                        <button class="btn btn-primary" type="submit">Log In <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                    </div>
                                                </div></div> </form><div class="text-center text-muted">
                                            <p>&copy; <?php echo date('Y'); ?> Betting Solution. All rights reserved.</p>
                                        </div>
                                    </div></div></div></div></div></div></div></div></body>
</html>