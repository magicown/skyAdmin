<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 캡챠 문자열 생성 (예: 5글자)
$captcha_string_length = 5;
$allowed_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // 영문 대문자와 숫자만 사용
$captcha_code = '';
$allowed_chars_len = strlen($allowed_chars);
for ($i = 0; $i < $captcha_string_length; $i++) {
    $captcha_code .= $allowed_chars[rand(0, $allowed_chars_len - 1)];
}

// 생성된 캡챠 코드를 세션에 저장 (대소문자 구분 없이 비교하기 위해 소문자로 저장)
$_SESSION['captcha_code'] = strtolower($captcha_code);

// 이미지 생성 준비
$image_width = 150;
$image_height = 50;
$font_size = 24; // 폰트 크기 조정

// 사용할 TTF 폰트 파일 경로
// C:\Windows\Fonts\arial.ttf 와 같이 시스템 폰트 경로를 직접 사용하거나,
// admin/assets/fonts/ 폴더에 폰트 파일을 위치시키고 경로를 지정합니다.
// 여기서는 admin/assets/fonts/arial.ttf 를 사용한다고 가정합니다.
$font_path = __DIR__ . '/assets/fonts/arial.ttf'; // __DIR__은 현재 captcha.php 파일이 있는 폴더를 가리킵니다.

// GD 라이브러리가 로드되었는지, 폰트 파일이 실제 존재하는지 확인
$gd_loaded = extension_loaded('gd') && function_exists('gd_info');
$font_exists = file_exists($font_path);

if (!$gd_loaded || !$font_exists) {
    // GD 라이브러리가 없거나 폰트 파일이 없을 경우, 간단한 텍스트 기반 이미지 생성 (imagestring 사용)
    $image = imagecreatetruecolor($image_width, $image_height);
    $background_color = imagecolorallocate($image, 230, 230, 230); // 연한 회색 배경
    $text_color = imagecolorallocate($image, 50, 50, 50);         // 어두운 회색 텍스트
    imagefill($image, 0, 0, $background_color);
    
    // 텍스트를 중앙에 위치시키기 위한 계산
    $text_width = imagefontwidth(5) * strlen($captcha_code);
    $text_height = imagefontheight(5);
    $x = ($image_width - $text_width) / 2;
    $y = ($image_height - $text_height) / 2;
    
    imagestring($image, 5, $x, $y, $captcha_code, $text_color);
} else {
    $image = imagecreatetruecolor($image_width, $image_height);
    
    // 배경색 (약간의 랜덤 요소 추가 가능)
    $background_color = imagecolorallocate($image, rand(230, 255), rand(230, 255), rand(230, 255));
    imagefill($image, 0, 0, $background_color);

    // 노이즈 추가 (선)
    for ($i = 0; $i < 3; $i++) {
        $line_color = imagecolorallocate($image, rand(180, 220), rand(180, 220), rand(180, 220));
        imageline($image, rand(0, $image_width/2), rand(0, $image_height), rand($image_width/2, $image_width), rand(0, $image_height), $line_color);
    }

    // 노이즈 추가 (점)
    for ($i = 0; $i < 200; $i++) {
        $pixel_color = imagecolorallocate($image, rand(200, 230), rand(200, 230), rand(200, 230));
        imagesetpixel($image, rand(0, $image_width), rand(0, $image_height), $pixel_color);
    }
    
    // 텍스트 쓰기 (TTF 폰트 사용)
    $x_offset = 10; // 시작 x 위치
    $y_offset = $image_height - (int)($image_height / 3); // y 위치 (폰트 크기에 따라 조정)

    for ($i = 0; $i < strlen($captcha_code); $i++) {
        $char_color = imagecolorallocate($image, rand(0, 120), rand(0, 120), rand(0, 120));
        $angle = rand(-10, 10); // 글자 각도
        imagettftext($image, $font_size, $angle, $x_offset + ($i * ($font_size + 2)), $y_offset, $char_color, $font_path, $captcha_code[$i]);
    }
}

// 이미지를 PNG로 출력
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
exit();
?>