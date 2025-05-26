<?php
// 1. 안전하고 새로운 임의의 비밀번호를 생성합니다.
$new_password = 'pw' . rand(100000, 999999);

// 2. 이 비밀번호로 사장님의 PHP 환경에서 직접 완벽한 60자 해시를 생성합니다.
$new_hash = password_hash($new_password, PASSWORD_BCRYPT);

// 3. 이 정보로 데이터베이스 UPDATE SQL 구문을 자동으로 생성합니다.
$update_sql = "UPDATE admins SET password = '" . $new_hash . "' WHERE admin_username = 'superadmin';";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>비밀번호 및 SQL 생성기</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .container { border: 2px solid #007bff; padding: 20px; border-radius: 8px; }
        h1, h2 { color: #007bff; }
        pre { background-color: #f0f0f0; padding: 15px; border: 1px solid #ccc; word-wrap: break-word; font-size: 1.1em; }
        p { font-size: 1.2em; }
        strong { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>자동 생성된 로그인 정보</h1>
        <p>이 페이지는 새로고침할 때마다 새로운 비밀번호와 SQL을 생성합니다.</p>
        <hr>
        <h2>1. 새로운 관리자 비밀번호</h2>
        <p>앞으로 사용할 새로운 비밀번호입니다. 이 값을 사용해 로그인하세요.</p>
        <pre><strong><?php echo htmlspecialchars($new_password); ?></strong></pre>

        <h2>2. 데이터베이스 업데이트용 SQL</h2>
        <p>아래 SQL 전체를 복사하여 phpMyAdmin에서 실행해주세요.</p>
        <pre><?php echo htmlspecialchars($update_sql); ?></pre>
        <p>생성된 해시의 길이: <strong><?php echo strlen($new_hash); ?></strong> (이 값은 반드시 60이어야 합니다.)</p>
    </div>
</body>
</html>