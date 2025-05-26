<?php
// 문제가 되고 있는 바로 그 해시 문자열입니다.
$hash_string = '$2y$10$wKkYF5rUn9iS9I.eXv1qP.PzLdG3hN5aX.oJ6g7C8i9K.L0m1N2O';

// 화면에 결과를 보기 쉽게 출력합니다.
echo "<h1>해시 문자열 길이 검증</h1>";
echo "<p>검증할 문자열:</p>";
// pre 태그를 사용해 문자열을 그대로 보여줍니다.
echo "<pre style='font-size: 1.2em; background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc; word-wrap: break-word;'>" . htmlspecialchars($hash_string) . "</pre>";

// PHP의 strlen() 함수로 실제 길이를 계산합니다.
$length = strlen($hash_string);

echo "<p style='font-size: 1.5em;'>문자열의 실제 길이 (strlen 함수 결과): <strong style='color: red;'>" . $length . "</strong></p>";

if ($length === 60) {
    echo "<p style='font-size: 1.2em; color: green;'>결과: 정상입니다. 해시의 길이는 60자가 맞습니다.</p>";
} else {
    echo "<p style='font-size: 1.2em; color: blue;'>결과: 문제가 있습니다. 해시의 길이가 60자가 아닙니다. 복사/붙여넣기 과정이나 원본 문자열을 다시 확인해야 합니다.</p>";
}
?>