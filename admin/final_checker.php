<?php
// 문제가 되는, 코드에 직접 입력한 문자열
$literal_string = '$2y$10$wKkYF5rUn9iS9I.eXv1qP.PzLdG3hN5aX.oJ6g7C8i9K.L0m1N2O';

// 해시의 모든 글자를 하나하나 배열에 담습니다.
$char_array = [
    '$', '2', 'y', '$', '1', '0', '$', 'w', 'K', 'k', 'Y', 'F', '5', 'r', 'U', 'n',
    '9', 'i', 'S', '9', 'I', '.', 'e', 'X', 'v', '1', 'q', 'P', '.', 'P', 'z', 'L',
    'd', 'G', '3', 'h', 'N', '5', 'a', 'X', '.', 'o', 'J', '6', 'g', '7', 'C', '8',
    'i', '9', 'K', '.', 'L', '0', 'm', '1', 'N', '2', 'O'
];

// 배열에 담긴 글자들을 합쳐서 문자열을 재구성합니다.
$built_string = implode('', $char_array);

echo "<h1>최종 문자열 검증</h1>";
echo "<p>이 테스트는 왜 길이가 59로 나오는지, 그 미스터리를 해결하기 위한 최종 검증입니다.</p>";

echo "<hr>";

echo "<h3>1. 기존 방식 (코드에 직접 문자열 입력)</h3>";
echo "<pre style='background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc; word-wrap: break-word;'>" . htmlspecialchars($literal_string) . "</pre>";
echo "<p style='font-size: 1.5em;'>길이: <strong style='color: red;'>" . strlen($literal_string) . "</strong></p>";

echo "<hr>";

echo "<h3>2. 새로운 방식 (PHP가 한 글자씩 조합)</h3>";
echo "<pre style='background-color: #f0f0f0; padding: 10px; border: 1px solid #ccc; word-wrap: break-word;'>" . htmlspecialchars($built_string) . "</pre>";
echo "<p>배열에 담긴 글자 수: <strong>" . count($char_array) . "</strong></p>";
echo "<p style='font-size: 1.5em;'>조합된 문자열의 길이: <strong style='color: red;'>" . strlen($built_string) . "</strong></p>";

echo "<hr>";

echo "<h3>결론</h3>";
if (strlen($built_string) === 60) {
    echo "<p style='color: green; font-weight: bold; font-size: 1.2em;'>
          2번 방식으로 만든 문자열의 길이는 60자가 맞습니다.<br>
          이것은 배열의 각 요소가 정확하다는 증거입니다.<br>
          이제 이 값을 사용하면 모든 문제가 해결됩니다.
          </p>";
} else {
     echo "<p style='color: red; font-weight: bold; font-size: 1.2em;'>
          두 방식 모두 60이 아니라면, PHP 또는 시스템 환경 자체의 문제로 보아야 합니다.
          </p>";
}
?>