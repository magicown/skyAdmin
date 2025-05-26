<?php
/**
 * =======================================================================
 * 데이터베이스 연결 설정 파일 (Database Configuration)
 * =======================================================================
 * 우리 '통합 베팅 플랫폼'의 모든 데이터베이스 연결은 이 파일을 통해 이루어집니다.
 */

// 데이터베이스 서버 정보
// 대부분의 로컬 개발 환경(XAMPP)에서는 아래 정보가 기본값입니다.
define('DB_HOST', 'localhost');      // 데이터베이스 서버 주소 (IP 또는 도메인)
define('DB_USER', 'totouser');           // 데이터베이스 사용자 아이디
define('DB_PASS', 'jun1126k!@#');               // 데이터베이스 사용자 비밀번호 (XAMPP 기본값은 비어있음)
define('DB_NAME', 'totodb'); // 우리가 생성한 데이터베이스 이름
define('DB_CHARSET', 'utf8mb4');       // 문자 인코딩 방식

/**
 * PDO(PHP Data Objects) 연결 설정
 * -----------------------------------------------------------------------
 * DSN (Data Source Name): 어떤 데이터베이스에 연결할지 알려주는 정보
 * options: PDO 연결 시 사용할 여러 가지 옵션 설정
 */
$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

$options = [
    // 오류 발생 시 경고(Warning) 대신 예외(Exception)를 발생시켜 try-catch로 잡을 수 있게 함
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // DB에서 데이터를 가져올 때 기본적으로 연관 배열 형태로 가져오도록 설정 (예: $row['username'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // SQL 구문을 서버에서 직접 처리하도록 하여, 보안을 강화하고 성능을 향상시킴
    PDO::ATTR_EMULATE_PREPARES   => false,
];

/**
 * 데이터베이스 연결 실행
 * -----------------------------------------------------------------------
 * try-catch 구문을 사용하여, 연결에 실패할 경우 에러 메시지를 명확하게 보여주고 시스템을 안전하게 중지시킵니다.
 * 성공적으로 연결되면, 앞으로 우리는 $pdo 라는 변수를 통해 데이터베이스를 제어하게 됩니다.
 */
try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (\PDOException $e) {
    // 실제 서비스 환경에서는 사용자에게 상세한 오류를 보여주면 안 되지만,
    // 개발 중에는 오류를 파악하기 위해 상세하게 출력합니다.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>