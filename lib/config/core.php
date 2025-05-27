<?php
/**
 * 공통 핵심 파일 (Core Initialization)
 *
 * 이 파일은 사이트 전역에서 사용되는 세션, DB 연결, 공통 설정 등을 처리합니다.
 * 모든 PHP 페이지의 최상단에 반드시 포함되어야 합니다.
 * require_once __DIR__ . '/../../lib/config/core.php';
 */

// 1. 세션 시작 (세션이 시작되지 않은 경우에만 시작)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. 에러 리포팅 설정
// 개발 중에는 모든 에러를 표시하여 문제를 빠르게 파악하고,
// 실제 서비스 시에는 에러를 로그 파일에만 기록하도록 변경해야 합니다.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 3. 기본 시간대 설정 (대한민국 표준시)
date_default_timezone_set('Asia/Seoul');

// 4. 데이터베이스 연결
// 위에서 만든 database.php 파일을 포함하여 $conn 객체를 생성합니다.
require_once __DIR__ . '/database.php';

// 5. 전역 상수 및 설정 정의 (필요시 추가)
// define('SITE_NAME', 'SkyAdmin 솔루션');
// define('ITEMS_PER_PAGE', 20); // 페이지당 표시할 항목 수

// 6. 공통 함수 라이브러리 포함 (선택 사항, 추후 확장)
// require_once __DIR__ . '/../functions.php';

?>