<?php
// 모든 관리자 페이지 시작 시 세션 시작
session_start();

// 만약 로그인 세션 정보가 없으면, 즉시 로그인 페이지로 쫓아냅니다.
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// 데이터베이스 연결 파일을 불러옵니다. (회원 목록 등 DB 작업에 필요)
require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/config/database.php';
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr" data-startbar="dark" data-bs-theme="light">
<head>    
    <meta charset="utf-8" />
    <title>관리자 대시보드 - 베팅 솔루션</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="통합 베팅 솔루션 관리자 페이지" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="../assets/images/favicon.ico">
    <link rel="stylesheet" href="../assets/libs/jsvectormap/css/jsvectormap.min.css">
     <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
     <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
     <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="">
    <div class="topbar d-print-none">
        <div class="container-fluid px-0">
            <nav class="topbar-custom d-flex justify-content-between" id="topbar-custom">
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li>
                        <button class="nav-link mobile-menu-btn nav-icon" id="togglemenu">
                            <i class="iconoir-menu-scale"></i>
                        </button>
                    </li>
                </ul>
                <ul class="topbar-item list-unstyled d-inline-flex align-items-center mb-0">
                    <li class="dropdown topbar-item">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <img src="../assets/images/users/avatar-6.jpg" alt="profile-user" class="rounded-circle me-1 me-md-2 thumb-lg">
                                <div class="d-none d-md-inline-block">
                                    <small class="d-none d-md-block fs-11">Admin</small>
                                    <span class="d-none d-md-block fw-semibold fs-12"><?php echo htmlspecialchars($_SESSION['admin_name']); ?> <i class="mdi mdi-chevron-down"></i></span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0">
                            <a class="dropdown-item text-danger" href="logout.php"><i class="las la-power-off fs-18 me-1 align-text-bottom"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    ```

#### 나. 사이드바 파일 (`_sidebar.php`) 생성

왼쪽의 메뉴 영역입니다. 지금은 그대로 사용하지만, 나중에 메뉴를 추가하거나 변경할 때 이 파일만 수정하면 됩니다.

`admin/includes` 폴더 안에 `_sidebar.php` 파일을 만들고 아래 코드를 저장합니다.

**`betting_solution/admin/includes/_sidebar.php`**
```php
    <div class="startbar d-print-none">
        <div class="brand">
            <a href="index.php" class="logo">
                <span>
                    <img src="../assets/images/logo-sm.png" alt="logo-small" class="logo-sm">
                </span>
                <span class="">
                    <img src="../assets/images/logo-light.png" alt="logo-large" class="logo-lg logo-light">
                    <img src="../assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
                </span>
            </a>
        </div>
        <div class="startbar-menu" >
            <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
                <div class="d-flex align-items-start flex-column w-100">
                    <ul class="navbar-nav mb-auto w-100">
                        <li class="menu-label pt-0 mt-0">
                            <span>Main Menu</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="iconoir-home-simple menu-icon"></i>
                                <span>대시보드</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="iconoir-user menu-icon"></i>
                                <span>회원 관리</span>
                            </a>
                        </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="startbar-overlay d-print-none"></div>
    <div class="page-wrapper">
        <div class="page-content">