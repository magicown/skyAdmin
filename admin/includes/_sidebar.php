<?php
// _header.php에서 $admin_base_url 변수가 이미 정의되어 있다고 가정합니다.
?>
        <div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li><a href="<?php echo $admin_base_url; ?>/index.php" class="ai-icon" aria-expanded="false">
                            <i class="flaticon-381-home"></i>
                            <span class="nav-text">대시보드</span>
                        </a>
                    </li>
                    <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                            <i class="flaticon-381-user"></i>
                            <span class="nav-text">회원 관리</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="<?php echo $admin_base_url; ?>/member_list.php">전체 회원 목록</a></li>
                        </ul>
                    </li>
                     <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
							<i class="flaticon-381-settings-2"></i>
							<span class="nav-text">시스템 설정</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="#">기본 설정</a></li>
                            <li><a href="#">관리자 계정 관리</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="copyright">
                    <p><strong>베팅 솔루션 관리자</strong> © <?php echo date('Y'); ?> All Rights Reserved</p>
                    <p>Powered by 사장님</p>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="container-fluid">