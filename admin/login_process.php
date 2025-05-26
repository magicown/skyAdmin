<?php
// PHP 세션을 시작합니다.
session_start();

// 데이터베이스 연결 파일을 '절대 경로'로 정확하게 불러옵니다.
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/config/database.php';

// 입력값 검증
if (empty($_POST['admin_username']) || empty($_POST['password'])) {
    die("아이디와 비밀번호를 모두 입력해주세요.");
}

$admin_username = $_POST['admin_username'];
$password = $_POST['password'];

// 데이터베이스에서 관리자 정보 조회
$sql = "SELECT id, admin_username, password, admin_name, role FROM admins WHERE admin_username = ?";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$admin_username]);
    $admin = $stmt->fetch();

    // 아이디 존재 여부 및 비밀번호 일치 여부 확인
    if ($admin && password_verify($password, $admin['password'])) {
        
        // 로그인 성공: 세션에 관리자 정보 저장
        session_regenerate_id(true);
        
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['admin_username'];
        $_SESSION['admin_name'] = $admin['admin_name'];
        $_SESSION['admin_role'] = $admin['role'];

        header("Location: index.php");
        exit();

    } else {
        // 로그인 실패
        echo "<script>
                alert('아이디 또는 비밀번호가 일치하지 않습니다.');
                window.history.back();
              </script>";
        exit();
    }

} catch (PDOException $e) {
    die("데이터베이스 오류가 발생했습니다: " . $e->getMessage());
}
?>