<?php
// 1. 공통 핵심 파일 포함 (세션, PDO DB 연결 등)
require_once '../lib/config/core.php';

// 2. 페이지별 권한 확인 (필요시 주석 해제)
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit();
// }

// --- 검색 및 필터링 처리 ---
$params = [];
$where_clauses = [];
$join_clause = '';

// 기본 SQL FROM 절
$from_clause = "FROM members m";

// 상위 파트너 ID로 검색
if (!empty($_GET['search_ancestor_id'])) {
    $ancestor_id = (int)$_GET['search_ancestor_id'];
    if ($ancestor_id > 0) {
        $join_clause = " JOIN partner_paths p ON m.idx = p.descendant_id";
        $where_clauses[] = "p.ancestor_id = :ancestor_id AND p.path_depth > 0";
        $params[':ancestor_id'] = $ancestor_id;
    }
}

// 아이디/닉네임으로 검색
if (!empty($_GET['search_keyword'])) {
    $where_clauses[] = "(m.userid LIKE :keyword OR m.nick LIKE :keyword)";
    $params[':keyword'] = '%' . $_GET['search_keyword'] . '%';
}

// 상태로 검색
if (!empty($_GET['search_status'])) {
    $where_clauses[] = "m.status = :status";
    $params[':status'] = $_GET['search_status'];
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(' AND ', $where_clauses) : '';

// --- 페이지네이션 처리 ---
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

// 전체 레코드 수 계산
$total_sql = "SELECT COUNT(m.idx) {$from_clause} {$join_clause} {$where_sql}";
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->execute($params);
$total_records = $total_stmt->fetchColumn();
$total_pages = ceil($total_records / $limit);

// --- 회원 데이터 조회 (거래 관련 집계 쿼리 없음) ---
$sql = "
    SELECT
        m.idx, m.userid, m.nick, m.money, m.g_money, m.point, m.level, m.is_partner, m.status,
        m.login_date, m.regdate, m.join_ip, m.login_ip,
        parent.nick AS parent_nickname
    {$from_clause}
    LEFT JOIN members parent ON m.parent_id = parent.idx
    {$join_clause}
    {$where_sql}
    ORDER BY m.idx DESC
    LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql);

$stmt_params = array_merge($params, [':limit' => $limit, ':offset' => $offset]);
foreach ($stmt_params as $key => &$val) {
    $param_type = (in_array($key, [':limit', ':offset', ':ancestor_id'])) ? PDO::PARAM_INT : PDO::PARAM_STR;
    $stmt->bindValue($key, $val, $param_type);
}
$stmt->execute();

// 헤더 파일 포함
include 'includes/_header.php';

?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">회원관리</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">회원목록</a></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">회원 검색</h4></div>
                    <div class="card-body">
                        <form method="get" action="member_list.php" class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">아이디 / 닉네임</label>
                                <input type="text" class="form-control" name="search_keyword" placeholder="아이디 또는 닉네임" value="<?php echo htmlspecialchars($_GET['search_keyword'] ?? ''); ?>">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">상위 파트너 ID (idx)</label>
                                <input type="number" class="form-control" name="search_ancestor_id" placeholder="상위 파트너의 숫자 ID" value="<?php echo htmlspecialchars($_GET['search_ancestor_id'] ?? ''); ?>">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">회원 상태</label>
                                <select name="search_status" class="form-control">
                                    <option value="">-- 전체 --</option>
                                    <option value="Y" <?php echo ($_GET['search_status'] ?? '') == 'Y' ? 'selected' : ''; ?>>정상</option>
                                    <option value="N" <?php echo ($_GET['search_status'] ?? '') == 'N' ? 'selected' : ''; ?>>정지</option>
                                    <option value="W" <?php echo ($_GET['search_status'] ?? '') == 'W' ? 'selected' : ''; ?>>승인대기</option>
                                    <option value="B" <?php echo ($_GET['search_status'] ?? '') == 'B' ? 'selected' : ''; ?>>블랙</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 align-self-end">
                                <button type="submit" class="btn btn-primary">검색</button>
                                <a href="member_list.php" class="btn btn-secondary">초기화</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header"><h4 class="card-title">전체 회원 (총 <?php echo number_format($total_records); ?>명)</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-center" style="min-width: 2800px;">
                                <thead>
                                    <tr>
                                        <th>추천인</th>
                                        <th>아이디(닉네임)</th>
                                        <th>보유머니</th>
                                        <th>게임머니</th>
                                        <th>포인트</th>
                                        <th>총 입금</th>
                                        <th>총 출금</th>
                                        <th>입-출</th>
                                        <th>총 베팅</th>
                                        <th>총 당첨</th>
                                        <th>베-당</th>
                                        <th>최근접속</th>
                                        <th>가입일시</th>
                                        <th>가입IP</th>
                                        <th>최근IP</th>
                                        <th>액션</th>
                                        <th>스위칭</th>
                                        <th>하부추가</th>
                                        <th>레벨</th>
                                        <th>회원유형</th>
                                        <th>상태</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($stmt->rowCount() > 0): ?>
                                        <?php while($row = $stmt->fetch()): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['parent_nickname'] ?? '없음'); ?></td>
                                                <td><?php echo htmlspecialchars($row['userid']); ?><small>(<?php echo htmlspecialchars($row['nick']); ?>)</small></td>
                                                <td class="text-end"><?php echo number_format($row['money']); ?></td>
                                                <td class="text-end"><?php echo number_format($row['g_money']); ?></td>
                                                <td class="text-end"><?php echo number_format($row['point']); ?></td>
                                                
                                                <td class="text-end text-success">0</td>
                                                <td class="text-end text-danger">0</td>
                                                <td class="text-end text-primary">0</td>
                                                <td class="text-end">0</td>
                                                <td class="text-end">0</td>
                                                <td class="text-end text-primary">0</td>
                                                
                                                <td><?php echo $row['login_date'] ? date('y-m-d H:i', strtotime($row['login_date'])) : '기록 없음'; ?></td>
                                                <td><?php echo date('y-m-d H:i', strtotime($row['regdate'])); ?></td>
                                                <td><?php echo htmlspecialchars($row['join_ip'] ?? ''); ?></td>
                                                <td><?php echo htmlspecialchars($row['login_ip'] ?? '기록 없음'); ?></td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href="member_status_update.php?idx=<?php echo $row['idx']; ?>&status=N" class="btn btn-danger btn-sm me-1">차단</a>
                                                        <a href="member_delete.php?idx=<?php echo $row['idx']; ?>" class="btn btn-dark btn-sm" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="member_switch.php?idx=<?php echo $row['idx']; ?>" class="btn btn-sm btn-secondary">스위칭</a>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success add-downline-btn" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#addDownlineModal"
                                                            data-bs-idx="<?php echo $row['idx']; ?>"
                                                            data-bs-userid="<?php echo htmlspecialchars($row['userid']); ?>">
                                                        추가
                                                    </button>
                                                </td>
                                                <td><span class="badge badge-light"><?php echo htmlspecialchars($row['level']); ?></span></td>
                                                <td>
                                                    <?php echo $row['is_partner'] == 'Y' ? "<span class='badge badge-info'>파트너</span>" : "<span class='badge badge-secondary'>일반</span>"; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        $status_map = ['Y' => ['class' => 'badge-success', 'text' => '정상'], 'N' => ['class' => 'badge-danger', 'text' => '정지'], 'W' => ['class' => 'badge-warning', 'text' => '대기'], 'B' => ['class' => 'badge-dark', 'text' => '블랙']];
                                                        $status_info = $status_map[$row['status']] ?? ['class' => 'badge-secondary', 'text' => '알수없음'];
                                                        echo "<span class='badge {$status_info['class']}'>" . htmlspecialchars($status_info['text']) . "</span>";
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="21">검색된 회원이 없습니다.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination justify-content-center">
                                </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addDownlineModal" tabindex="-1" aria-labelledby="addDownlineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addDownlineModalLabel">하부 회원 추가</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addDownlineForm" action="member_add_process.php" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">상위 아이디</label>
                        <input type="text" class="form-control" id="addDownlineParentUseridDisplay" value="" readonly>
                        <input type="hidden" id="addDownlineParentIdx" name="parent_idx">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineUserid" class="form-label">아이디 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addDownlineUserid" name="userid" required placeholder="일괄 생성 시 접두사">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineNick" class="form-label">닉네임 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addDownlineNick" name="nick" required placeholder="일괄 생성 시 접두사">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlinePasswd" class="form-label">비밀번호 <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="addDownlinePasswd" name="passwd" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDownlinePasswdConfirm" class="form-label">비밀번호 확인 <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="addDownlinePasswdConfirm" name="passwd_confirm" required>
                        <div class="invalid-feedback" id="passwordConfirmError" style="display: none;">비밀번호가 일치하지 않습니다.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineStartNum" class="form-label">시작번호</label>
                        <select class="form-select" id="addDownlineStartNum" name="start_num">
                            <option value="">번호선택 (일괄생성 시)</option>
                            <?php for ($i = 0; $i <= 99; $i++): ?>
                                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineEndNum" class="form-label">끝번호</label>
                        <select class="form-select" id="addDownlineEndNum" name="end_num">
                            <option value="">번호선택 (일괄생성 시)</option>
                            <?php for ($i = 0; $i <= 99; $i++): ?>
                                <option value="<?php echo sprintf('%02d', $i); ?>"><?php echo sprintf('%02d', $i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineWithdrawPasswd" class="form-label">환전비번</label>
                        <input type="password" class="form-control" id="addDownlineWithdrawPasswd" name="withdraw_passwd" maxlength="4" placeholder="숫자 4자리">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineHphone" class="form-label">전화번호</label>
                        <input type="text" class="form-control" id="addDownlineHphone" name="hphone">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineBankAccount" class="form-label">계좌번호</label>
                        <input type="text" class="form-control" id="addDownlineBankAccount" name="bank_account">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineBankOwner" class="form-label">예금주</label>
                        <input type="text" class="form-control" id="addDownlineBankOwner" name="bank_owner">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="addDownlineBankName" class="form-label">은행명</label>
                        <select class="form-select" id="addDownlineBankName" name="bank_name">
                            <option value="">선택</option>
                            <option value="산업은행">산업은행</option>
                            <option value="기업은행">기업은행</option>
                            <option value="국민은행">국민은행</option>
                            <option value="수협은행">수협은행</option>
                            <option value="농협은행">농협은행</option>
                            <option value="우리은행">우리은행</option>
                            <option value="SC제일은행">SC제일은행</option>
                            <option value="한국씨티은행">한국씨티은행</option>
                            <option value="iM뱅크">iM뱅크(대구)</option>
                            <option value="부산은행">부산은행</option>
                            <option value="광주은행">광주은행</option>
                            <option value="제주은행">제주은행</option>
                            <option value="전북은행">전북은행</option>
                            <option value="경남은행">경남은행</option>
                            <option value="새마을금고">새마을금고</option>
                            <option value="신협중앙회">신협중앙회</option>
                            <option value="상호저축은행">상호저축은행</option>
                            <option value="산림조합">산림조합</option>
                            <option value="우체국">우체국</option>
                            <option value="하나은행">하나은행</option>
                            <option value="신한은행">신한은행</option>
                            <option value="케이뱅크">케이뱅크</option>
                            <option value="카카오뱅크">카카오뱅크</option>
                            <option value="토스뱅크">토스뱅크</option>
                        </select>
                    </div>
                    
                </div>
                
                <div class="mb-3">
                    <label for="addDownlineMemo" class="form-label">메모</label>
                    <textarea class="form-control" id="addDownlineMemo" name="memo" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                <button type="submit" class="btn btn-primary">저장</button>
            </div>
        </form>       
    </div>
</div>


<?php
// 푸터 포함
include 'includes/_footer.php';
?>

<script>
$(document).ready(function() {
    if ($('#addDownlineModal').length) {
        var $addDownlineModal = $('#addDownlineModal');
        var $addDownlineForm = $('#addDownlineForm');
        var $passwdInput = $('#addDownlinePasswd');
        var $passwdConfirmInput = $('#addDownlinePasswdConfirm');
        var $passwordConfirmError = $('#passwordConfirmError');
        var $partnerRadio = $('#isPartnerY');
        var $normalRadio = $('#isPartnerN');
        var $partnerFeeSection = $('#partnerFeeSection');

        $addDownlineModal.on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var parentIdx = button[0].getAttribute('data-bs-idx');
            var parentUserid = button[0].getAttribute('data-bs-userid');

            var $modalTitle = $addDownlineModal.find('.modal-title');
            var $parentUseridDisplayInput = $('#addDownlineParentUseridDisplay');
            var $parentIdxInput = $('#addDownlineParentIdx');

            $modalTitle.text('하부 회원 추가 (상위: ' + parentUserid + ')');
            console.log(parentUserid);
            $('#addDownlineParentUseridDisplay').val(parentUserid);
            $parentUseridDisplayInput.val(parentUserid);
            $parentIdxInput.val(parentIdx);

            // 현재 부모 아이디와 인덱스 값 저장
            var currentParentUserid = $parentUseridDisplayInput.val();
            var currentParentIdx = $parentIdxInput.val();
            
            // 폼 초기화
            $addDownlineForm[0].reset();
            
            // 부모 아이디와 인덱스 값 다시 설정
            $parentUseridDisplayInput.val(currentParentUserid);
            $parentIdxInput.val(currentParentIdx);
            
            $partnerFeeSection.hide();
            $passwdConfirmInput.removeClass('is-invalid');
            $passwordConfirmError.hide();
            $normalRadio.prop('checked', true); // 기본값 일반회원
        });

        // 비밀번호 유효성 검사 (영문+숫자+특수문자 5자 이상)
        function validatePasswordStrength(password) {
            // 최소 5자 이상
            if (password.length < 5) {
                return false;
            }
            
            // 영문, 숫자, 특수문자 각각 1개 이상 포함
            var hasLetter = /[a-zA-Z]/.test(password);
            var hasNumber = /[0-9]/.test(password);
            var hasSpecial = /[!@#$%^&*(),.?\":{}<>]/.test(password);
            
            return hasLetter && hasNumber && hasSpecial;
        }

        // 비밀번호 확인 로직
        function validatePassword() {
            // 비밀번호 강도 검사
            if (!validatePasswordStrength($passwdInput.val())) {
                $passwdInput.addClass('is-invalid');
                $('<div class="invalid-feedback">비밀번호는 영문, 숫자, 특수문자를 포함하여 5자 이상이어야 합니다.</div>').insertAfter($passwdInput).show();
                return false;
            } else {
                $passwdInput.removeClass('is-invalid');
                $passwdInput.next('.invalid-feedback').remove();
            }
            
            // 비밀번호 일치 여부 검사
            if ($passwdInput.val() !== $passwdConfirmInput.val()) {
                $passwdConfirmInput.addClass('is-invalid');
                $passwordConfirmError.show();
                return false;
            } else {
                $passwdConfirmInput.removeClass('is-invalid');
                $passwordConfirmError.hide();
                return true;
            }
        }
        
        $passwdInput.on('input', validatePassword);
        $passwdConfirmInput.on('input', validatePassword);

        // 회원 유형 선택에 따른 파트너 요율 필드 표시/숨김
        function togglePartnerFeeSection() {
            if ($partnerRadio.prop('checked')) {
                $partnerFeeSection.show();
            } else {
                $partnerFeeSection.hide();
            }
        }
        
        $partnerRadio.on('change', togglePartnerFeeSection);
        $normalRadio.on('change', togglePartnerFeeSection);

        // 폼 제출 시 비밀번호 일치 여부 최종 확인
        $addDownlineForm.on('submit', function(event) {
            if (!validatePassword()) {
                event.preventDefault(); // 비밀번호 불일치 시 제출 막음
                alert('비밀번호가 유효하지 않습니다. 다시 확인해주세요.');
            }
        });
    }
});
</script>
