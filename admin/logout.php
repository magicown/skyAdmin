<?php
session_start();

// 모든 세션 변수를 지웁니다.
$_SESSION = array();

// 세션 쿠키를 삭제합니다.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 마지막으로 세션을 파괴합니다.
session_destroy();

// 로그아웃 후 로그인 페이지로 이동합니다.
header("Location: login.php");
exit();
?>