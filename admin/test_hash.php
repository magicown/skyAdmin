<?php

echo "PHP 버전: " . PHP_VERSION . "<br><hr>";

$password_to_test = 'betting1234!';
$correct_hash = '$2y$10$wKkYF5rUn9iS9I.eXv1qP.PzLdG3hN5aX.oJ6g7C8i9K.L0m1N2O';

echo "테스트할 비밀번호: " . $password_to_test . "<br>";
echo "비교할 해시 값: " . $correct_hash . "<br>";
echo "해시 값의 길이: " . strlen($correct_hash) . "<br><hr>";

if (password_verify($password_to_test, $correct_hash)) {
    echo "<h1>결과: 성공!</h1>";
    echo "<p>PHP의 암호화 기능이 정상적으로 동작합니다.</p>";
} else {
    echo "<h1>결과: 실패!</h1>";
    echo "<p>PHP 환경의 password_verify() 함수에 심각한 문제가 있을 수 있습니다.</p>";
}

?>