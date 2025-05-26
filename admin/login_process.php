<?php
// PHP 세션을 시작합니다. captcha.php 에서 세션을 사용하므로 여기서도 필요합니다.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/functions/utils.php'; // 경로 함수 사용
require_once get_db_config_path(); // DB 연결

// 입력값 검증 (캡챠 포함)
if (empty($_POST['admin_username']) || empty($_POST['password']) || empty($_POST['captcha_code'])) {
    // 모든 필드가 채워지지 않았을 경우의 에러 처리도 가능하나,
    // login.php의 required 속성으로 기본 방어되므로 여기서는 생략 가능
    // 만약 에러 메시지를 다르게 하고 싶다면, login.php?error=3 등으로 구분
    header("Location: " . get_base_url('admin') . "/login.php?error=1"); // 우선 기존 에러로 처리
    exit();
}

$admin_username = $_POST['admin_username'];
$password = $_POST['password'];
$user_captcha_code = strtolower($_POST['captcha_code']); // 사용자가 입력한 캡챠 (소문자로 변환)
$session_captcha_code = $_SESSION['captcha_code'] ?? ''; // 세션에 저장된 캡챠 (이미 소문자)

// 1. 캡챠 코드 일치 여부 확인
if (empty($session_captcha_code) || $user_captcha_code !== $session_captcha_code) {
    // 캡챠 코드가 틀리면, 세션의 캡챠 코드를 비워 보안 강화
    unset($_SESSION['captcha_code']);
    header("Location: " . get_base_url('admin') . "/login.php?error=2"); // error=2는 캡챠 오류
    exit();
}

// 캡챠 코드 검증 성공 시, 세션의 캡챠 코드는 비워줍니다 (재사용 방지)
unset($_SESSION['captcha_code']);

// 2. 데이터베이스에서 관리자 정보 조회 (준비된 구문 사용)
$sql = "SELECT id, admin_username, password, admin_name, role FROM admins WHERE admin_username = ?";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$admin_username]);
    $admin = $stmt->fetch();

    // 3. 아이디 존재 여부 및 비밀번호 일치 여부 확인
    if ($admin && password_verify($password, $admin['password'])) {
        
        session_regenerate_id(true);
        
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['admin_username'];
        $_SESSION['admin_name'] = $admin['admin_name'];
        $_SESSION['admin_role'] = $admin['role'];

        header("Location: " . get_base_url('admin') . "/index.php");
        exit();

    } else {
        // 로그인 실패 (아이디 또는 비밀번호 불일치)
        header("Location: " . get_base_url('admin') . "/login.php?error=1");
        exit();
    }

} catch (PDOException $e) {
    // 데이터베이스 오류 시에는 사용자에게 일반적인 오류 메시지를 보여주는 것이 좋습니다.
    // 여기서는 개발 편의를 위해 상세 에러를 출력하거나, 특정 에러 페이지로 리다이렉션 할 수 있습니다.
    // die("데이터베이스 오류가 발생했습니다: " . $e->getMessage());
    header("Location: " . get_base_url('admin') . "/login.php?error=db"); // 예시: ?error=db
    exit();
}
?>