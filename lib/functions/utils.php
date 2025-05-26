<?php
// utils.php

/**
 * 지정된 기능 영역(admin, partner 등)의 기본 웹 URL을 반환합니다.
 * 웹 루트 바로 아래에 해당 폴더가 있다고 가정합니다. (예: /admin)
 *
 * @param string $area 'admin', 'partner' 등 기능 영역 이름
 * @return string 해당 영역의 기본 웹 URL (예: "/admin")
 */
function get_base_url($area) {
    return "/" . trim($area, "/");
}

/**
 * 특정 기능 영역 내의 assets 폴더 웹 URL을 반환합니다.
 * 예시: /admin/assets
 *
 * @param string $area 'admin', 'partner' 등 기능 영역 이름
 * @return string 해당 영역의 assets 폴더 웹 URL (예: "/admin/assets")
 */
function get_assets_url($area) {
    return get_base_url($area) . "/assets";
}

/**
 * 데이터베이스 연결 파일의 절대 서버 경로를 반환합니다.
 * $_SERVER['DOCUMENT_ROOT'] (예: C:/xampp/htdocs) 바로 아래에 lib 폴더가 있다고 가정합니다.
 *
 * @return string database.php 파일의 절대 경로
 */
function get_db_config_path() {
    return $_SERVER['DOCUMENT_ROOT'] . '/lib/config/database.php';
}

/**
 * 현재 페이지가 로그인 페이지인지 확인합니다. (리다이렉션 방지용)
 *
 * @param string $area 'admin', 'partner' 등 로그인 페이지가 속한 영역
 * @return bool 로그인 페이지이면 true, 아니면 false
 */
function is_login_page($area = 'admin') {
    // 예를 들어 /admin/login.php 또는 /partner/login.php 와 같은 형태를 확인
    return strpos($_SERVER['PHP_SELF'], '/' . trim($area, "/") . '/login.php') !== false;
}
?>