<?php
// 1. 헤더 파일 포함 (세션 시작, 로그인 체크, DB연결 등)
require_once 'includes/_header.php';

// 2. 사이드바 파일 포함
require_once 'includes/_sidebar.php';

// 3. DB에서 회원 목록 데이터 가져오기
try {
    $stmt = $pdo->query("SELECT id, username, nickname, balance, member_type, status, created_at FROM members ORDER BY id DESC");
    $members = $stmt->fetchAll();
} catch (PDOException $e) {
    die("데이터베이스에서 회원 정보를 가져오는 데 실패했습니다: " . $e->getMessage());
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">전체 회원 목록</h4>
                    <p class="text-muted mb-0">플랫폼에 가입된 모든 회원의 목록입니다.</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>고유ID</th>
                                    <th>아이디</th>
                                    <th>닉네임</th>
                                    <th>보유머니</th>
                                    <th>타입</th>
                                    <th>상태</th>
                                    <th>가입일</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($members) > 0): ?>
                                    <?php foreach ($members as $member): ?>
                                        <tr>
                                            <td><?php echo $member['id']; ?></td>
                                            <td><?php echo htmlspecialchars($member['username']); ?></td>
                                            <td><?php echo htmlspecialchars($member['nickname']); ?></td>
                                            <td><?php echo number_format($member['balance'], 2); ?></td>
                                            <td>
                                                <?php if ($member['member_type'] == 'partner'): ?>
                                                    <span class="badge bg-success-subtle text-success">파트너</span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary-subtle text-primary">일반회원</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($member['status'] == 'active'): ?>
                                                    <span class="badge bg-light-success text-success">정상</span>
                                                <?php else: ?>
                                                    <span class="badge bg-light-danger text-danger"><?php echo htmlspecialchars($member['status']); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo date('Y-m-d H:i', strtotime($member['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">가입된 회원이 없습니다.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div></div></div></div> </div> </div><?php
// 4. 푸터 파일 포함 (자바스크립트 등)
require_once 'includes/_footer.php';
?>