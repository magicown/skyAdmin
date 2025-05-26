<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions/utils.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: " . get_base_url('admin') . "/index.php");
    exit();
}

$error_message = null;
if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        $error_message = '아이디 또는 비밀번호가 일치하지 않습니다.';
    } elseif ($_GET['error'] == 2) {
        $error_message = '보안코드가 올바르지 않습니다.';
    }
}

$admin_base_url = get_base_url('admin');
$admin_assets_url = get_assets_url('admin');
?>
<!DOCTYPE html>
<html lang="ko" class="h-100">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>관리자 로그인 - 베팅 솔루션</title>
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $admin_assets_url; ?>/images/favicon.png">
    <link href="<?php echo $admin_assets_url; ?>/css/style.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        .alert.solid.alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; margin-top: 15px; }
        .captcha-container img { border: 1px solid #ccc; margin-bottom: 10px; }
        .captcha-container input { margin-bottom: 10px; }
    </style>
</head>
<body class="vh-100" style="background-image:url('<?php echo $admin_assets_url; ?>/images/bg.png'); background-position:center; background-repeat: no-repeat; background-size: cover;">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="<?php echo $admin_base_url; ?>/login.php"><img src="<?php echo $admin_assets_url; ?>/images/logo-full.png" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">관리자 계정으로 로그인</h4>
                                    
                                    <?php if ($error_message): ?>
                                        <div class="alert alert-danger text-center solid" role="alert">
                                            <?php echo htmlspecialchars($error_message); ?>
                                        </div>
                                    <?php endif; ?>

                                    <form action="login_process.php" method="post">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>아이디</strong></label>
                                            <input type="text" class="form-control" name="admin_username" placeholder="아이디를 입력하세요" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>비밀번호</strong></label>
                                            <input type="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요" required>
                                        </div>
                                        
                                        <div class="mb-3 captcha-container">
                                            <label class="mb-1"><strong>보안코드</strong></label>
                                            <img src="captcha.php" alt="보안코드 이미지" onclick="this.src='captcha.php?' + new Date().getTime();" style="cursor:pointer;">
                                            <input type="text" class="form-control" name="captcha_code" placeholder="위 이미지의 코드를 입력하세요" required autocomplete="off">
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">로그인</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo $admin_assets_url; ?>/vendor/global/global.min.js"></script>
    <script src="<?php echo $admin_assets_url; ?>/js/custom.min.js"></script>
    <script src="<?php echo $admin_assets_url; ?>/js/deznav-init.js"></script>
</body>
</html>