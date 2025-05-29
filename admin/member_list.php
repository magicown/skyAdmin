<?php
// 1. 공통 핵심 파일 포함 (세션, PDO DB 연결 등)
require_once '../lib/config/core.php';

// 2. 페이지별 권한 확인 (필요시 주석 해제)
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit();
// }

// --- 검색 및 필터링 파라미터 ---
$params = [];
$where_clauses = [];
$join_clause = '';
$from_clause = "FROM members m";

// 날짜 검색
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
if ($start_date && $end_date) {
    if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $start_date) &&
        preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $end_date)) {
        // 검색 기준을 '가입일'(regdate)로 할지, 다른 날짜 컬럼으로 할지 결정 필요. 여기서는 가입일로 가정.
        $where_clauses[] = "DATE(m.regdate) BETWEEN :start_date AND :end_date";
        $params[':start_date'] = $start_date;
        $params[':end_date'] = $end_date;
    }
}

// 상위 파트너 ID로 검색 (기존 상세 검색 영역에 있던 기능)
if (!empty($_GET['search_ancestor_id'])) {
    $ancestor_id = (int)$_GET['search_ancestor_id'];
    if ($ancestor_id > 0) {
        $join_clause = " JOIN partner_paths p ON m.idx = p.descendant_id";
        $where_clauses[] = "p.ancestor_id = :ancestor_id AND p.path_depth > 0";
        $params[':ancestor_id'] = $ancestor_id;
    }
}

// 상태로 검색 (기존 상세 검색 영역에 있던 기능)
if (!empty($_GET['search_status'])) {
    $where_clauses[] = "m.status = :status";
    $params[':status'] = $_GET['search_status'];
}

// 새로운 통합 검색 (이미지의 우측 검색 영역)
$search_field = $_GET['search_field'] ?? 'all'; // 이미지의 '전체' 드롭다운
$search_query = $_GET['search_query'] ?? '';   // 이미지의 검색어 입력 필드

if (!empty($search_query)) {
    $search_query_like = '%' . $search_query . '%';
    switch ($search_field) {
        case 'userid':
            $where_clauses[] = "m.userid LIKE :search_query";
            $params[':search_query'] = $search_query_like;
            break;
        case 'nick':
            $where_clauses[] = "m.nick LIKE :search_query";
            $params[':search_query'] = $search_query_like;
            break;
        case 'name': // '이름' 검색 추가
            $where_clauses[] = "m.name LIKE :search_query";
            $params[':search_query'] = $search_query_like;
            break;
        case 'hphone': // '연락처' 검색 추가
            $where_clauses[] = "m.hphone LIKE :search_query";
            $params[':search_query'] = $search_query_like;
            break;
        case 'join_ip': // '가입IP' 검색 추가
            $where_clauses[] = "m.join_ip = :search_query_ip"; // IP는 정확히 일치 또는 LIKE
            $params[':search_query_ip'] = $search_query;
            break;
        case 'all':
        default:
            $where_clauses[] = "(m.userid LIKE :sq_all OR m.nick LIKE :sq_all OR m.name LIKE :sq_all OR m.hphone LIKE :sq_all OR m.join_ip = :sq_all_ip)";
            $params[':sq_all'] = $search_query_like;
            $params[':sq_all_ip'] = $search_query;
            break;
    }
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(' AND ', $where_clauses) : '';

// --- 페이지네이션 처리 ---
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && in_array((int)$_GET['limit'], [20, 50, 100, 200, 500]) ? (int)$_GET['limit'] : 20;
$offset = ($page - 1) * $limit;

// 전체 레코드 수 계산
$total_sql = "SELECT COUNT(m.idx) {$from_clause} {$join_clause} {$where_sql}";
$total_stmt = $pdo->prepare($total_sql);
$total_stmt->execute($params);
$total_records = $total_stmt->fetchColumn();
$total_pages = ceil($total_records / $limit);

// --- 회원 데이터 조회 ---
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
$stmt_params_paged = array_merge($params, [':limit' => $limit, ':offset' => $offset]);

foreach ($stmt_params_paged as $key => &$val) {
    // :limit, :offset, :ancestor_id는 PDO::PARAM_INT로, 나머지는 PDO::PARAM_STR로 바인딩
    $param_type = (in_array($key, [':limit', ':offset']) || ($key === ':ancestor_id' && is_int($val))) ? PDO::PARAM_INT : PDO::PARAM_STR;
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
                    <div class="card-header">
                        <h4 class="card-title">회원 정보 검색 및 관리</h4>
                    </div>
                    <div class="card-body detail-search-toolbar">
                        <form method="GET" action="member_list.php" id="filterForm">
                            <div class="row gx-2 align-items-end mb-2">
                                <div class="col-md-5 col-lg-5">
                                    <label for="startDate" class="form-label">가입일</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="startDate" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" style="min-width: 120px;">
                                        <span class="input-group-text">~</span>
                                        <input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" style="min-width: 120px;">
                                        <button type="button" class="btn btn-primary" onclick="filterForm.submit()">조회</button>
                                    </div>
                                </div>
                                <div class="col-md-auto ms-md-auto">
                                     <label class="form-label d-block d-md-none">&nbsp;</label> <div class="btn-group mt-2 mt-md-0" role="group">
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="all">전체</button>
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="W">요청회원</button>
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="Y">정상회원</button>
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="N">차단회원</button>
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="D">삭제회원</button>
                                        <button type="button" class="btn btn-outline-dark status-filter-btn" data-status="B">대기회원</button>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row gx-2 align-items-end mt-md-2">
                                <div class="col-md-2 col-lg-1 mt-2 mt-md-0">
                                    <label for="itemsPerPage" class="form-label">표시 항목 수</label>
                                    <select class="form-select" id="itemsPerPage" name="limit" onchange="this.form.submit()">
                                        <option value="20" <?php if ($limit == 20) echo 'selected'; ?>>20개</option>
                                        <option value="50" <?php if ($limit == 50) echo 'selected'; ?>>50개</option>
                                        <option value="100" <?php if ($limit == 100) echo 'selected'; ?>>100개</option>
                                        <option value="200" <?php if ($limit == 200) echo 'selected'; ?>>200개</option>
                                        <option value="500" <?php if ($limit == 500) echo 'selected'; ?>>500개</option>
                                    </select>
                                </div> 

                                <div class="col-md-4 col-lg-3 ms-md-auto">
                                    <label for="searchField" class="form-label">통합검색</label>
                                    <div class="input-group">
                                        <select class="form-select" id="searchField" name="search_field" style="max-width: 100px;">
                                            <option value="all" <?php if ($search_field == 'all') echo 'selected'; ?>>전체</option>
                                            <option value="userid" <?php if ($search_field == 'userid') echo 'selected'; ?>>아이디</option>
                                            <option value="nick" <?php if ($search_field == 'nick') echo 'selected'; ?>>닉네임</option>
                                            <option value="name" <?php if ($search_field == 'name') echo 'selected'; ?>>이름</option>
                                            <option value="hphone" <?php if ($search_field == 'hphone') echo 'selected'; ?>>연락처</option>
                                            <option value="join_ip" <?php if ($search_field == 'join_ip') echo 'selected'; ?>>가입IP</option>
                                        </select>
                                        <input type="text" class="form-control" placeholder="검색어" name="search_query" value="<?php echo htmlspecialchars($search_query); ?>">
                                    </div>
                                </div>
                                <div class="col-md-auto mt-2 mt-md-0">
                                     <label class="form-label d-block d-md-none">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary">검색</button>                                    
                                    <button type="button" class="btn btn-success" id="addNewMemberBtn" data-bs-toggle="modal" data-bs-target="#addDownlineModal">회원추가</button>
                                    <button type="button" class="btn btn-warning" id="bulkBlockBtn">선택차단</button>
                                    <button type="button" class="btn btn-danger" id="bulkDeleteBtn">선택삭제</button>
                                </div>                               
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">회원 목록 (총 <?php echo number_format($total_records); ?>명)</h4>
                    </div>
                    <div class="card-body">
                        <form id="memberListForm" action="member_bulk_action.php" method="POST">
                        <input type="hidden" name="bulk_action_type" id="bulkActionType">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover text-center member-list-table">
                                <thead>
                                    <tr>
                                        <th class="th-checkbox"><input type="checkbox" id="selectAllCheckbox"></th>
                                        <th>추천인</th>
                                        <th>아이디(닉네임)</th>
                                        <th>지급/회수</th>
                                        <th>게임회수</th>
                                        <th>보유머니</th>                                        
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
                                        <th style="text-align:center !important">상태</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($stmt->rowCount() > 0): ?>
                                        <?php while($row = $stmt->fetch()): ?>
                                            <tr>
                                                <td class="td-checkbox"><input type="checkbox" name="member_idx[]" class="rowCheckbox" value="<?php echo $row['idx']; ?>"></td>
                                                <td><button class="btn btn-sm btn-secondary w-100"><?php echo htmlspecialchars($row['parent_nickname'] ?? '없음'); ?></button></td>
                                                <td><button class="btn btn-sm btn-primary w-100"><?php echo htmlspecialchars($row['userid']); ?>(<?php echo htmlspecialchars($row['nick']); ?>)</button></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success money-action-btn" data-action="deposit" data-member-idx="<?php echo $row['idx']; ?>" data-member-id="<?php echo htmlspecialchars($row['userid']); ?>" data-member-nick="<?php echo htmlspecialchars($row['nick']); ?>" data-member-balance="<?php echo $row['money']; ?>">지급</button>
                                                    <button type="button" class="btn btn-sm btn-danger money-withdraw-btn" data-action="withdraw" data-member-idx="<?php echo $row['idx']; ?>" data-member-id="<?php echo htmlspecialchars($row['userid']); ?>" data-member-nick="<?php echo htmlspecialchars($row['nick']); ?>" data-member-balance="<?php echo $row['money']; ?>">회수</button>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger game-money-withdraw-btn" data-action="game_withdraw" data-member-idx="<?php echo $row['idx']; ?>" data-member-id="<?php echo htmlspecialchars($row['userid']); ?>" data-member-nick="<?php echo htmlspecialchars($row['nick']); ?>" data-member-balance="<?php echo $row['money']; ?>">회수</button>
                                                </td>
                                                <td class="text-end"><?php echo number_format($row['money']); ?></td>                                                
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
                                                    <button class="btn btn-sm btn-warning">차단</button>
                                                    <button class="btn btn-sm btn-danger">삭제</button>                                                        
                                                </td>
                                                <td>                                                    
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input switch" data-id="hajutest" type="checkbox">
                                                    </div>
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
                                                <td><span class="badge badge-dark"><?php echo htmlspecialchars($row['level']); ?></span></td>
                                                <td>
                                                    <?php echo $row['is_partner'] == 'Y' ? "<span class='badge badge-info'>파트너</span>" : "<span class='badge badge-secondary'>일반</span>"; ?>
                                                </td>
                                                <td style="text-align:center !important">
                                                    <?php
                                                        $status_map = ['Y' => ['class' => 'badge-success', 'text' => '정상'], 'N' => ['class' => 'badge-danger', 'text' => '정지'], 'W' => ['class' => 'badge-warning', 'text' => '대기'], 'B' => ['class' => 'badge-dark', 'text' => '블랙']];
                                                        $status_info = $status_map[$row['status']] ?? ['class' => 'badge-secondary', 'text' => '알수없음'];
                                                        echo "<span class='badge {$status_info['class']}'>" . htmlspecialchars($status_info['text']) . "</span>";
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="22">검색된 회원이 없습니다.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        </form>

                        <nav>
                            <ul class="pagination justify-content-center">
                                <?php
                                    $current_query_params = $_GET;
                                    $current_query_params['page'] = $page > 1 ? $page - 1 : 1;
                                    $prev_page_link = '?' . http_build_query($current_query_params);

                                    $current_query_params['page'] = $page < $total_pages ? $page + 1 : $total_pages;
                                    $next_page_link = '?' . http_build_query($current_query_params);
                                ?>
                                <?php if ($page > 1): ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo $prev_page_link; ?>">이전</a></li>
                                <?php endif; ?>
                                <?php for ($i = 1; $i <= $total_pages; $i++): 
                                    $current_query_params['page'] = $i;
                                    $page_link = '?' . http_build_query($current_query_params);
                                ?>
                                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="<?php echo $page_link; ?>"><?php echo $i; ?></a></li>
                                <?php endfor; ?>
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item"><a class="page-link" href="<?php echo $next_page_link; ?>">다음</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// 모달 파일 포함
include 'includes/modals/add_downline_modal.php';
include 'includes/modals/money_modal.php';
?>


<?php
// 푸터 포함
include 'includes/_footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 전체선택 체크박스 로직
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const rowCheckboxes = document.querySelectorAll('.rowCheckbox');

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
        });
    }
    if(rowCheckboxes) {
        rowCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    if(selectAllCheckbox) selectAllCheckbox.checked = false;
                } else {
                    let allChecked = true;
                    rowCheckboxes.forEach(function(cb) {
                        if (!cb.checked) {
                            allChecked = false;
                        }
                    });
                    if(selectAllCheckbox) selectAllCheckbox.checked = allChecked;
                }
            });
        });
    }

    // 회원 상태 필터 버튼 로직
    const statusFilterButtons = document.querySelectorAll('.status-filter-btn');
    const filterForm = document.getElementById('filterForm');
    
    if(statusFilterButtons && filterForm) {
        // 현재 선택된 상태에 따라 버튼 활성화
        const currentStatus = new URLSearchParams(window.location.search).get('search_status') || 'all';
        statusFilterButtons.forEach(function(button) {
            if(button.dataset.status === currentStatus) {
                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-secondary');
            }
        });
        
        // 버튼 클릭 이벤트
        statusFilterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const status = this.dataset.status;
                
                // 히든 필드 생성 또는 업데이트
                let statusInput = filterForm.querySelector('input[name="search_status"]');
                if(!statusInput) {
                    statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'search_status';
                    filterForm.appendChild(statusInput);
                }
                
                // all인 경우 필드 제거, 아니면 값 설정
                if(status === 'all') {
                    if(statusInput) {
                        filterForm.removeChild(statusInput);
                    }
                } else {
                    statusInput.value = status;
                }
                
                // 폼 제출
                filterForm.submit();
            });
        });
    }
    
    // 날짜 입력 필드
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');

    // 하부회원 추가 모달 로직 (이전과 동일, 상단 회원추가 버튼에 대한 처리 추가)
    var addDownlineModal = document.getElementById('addDownlineModal');
    var addDownlineForm = document.getElementById('addDownlineForm'); 
    
    if (addDownlineModal && addDownlineForm) {
        var passwdInputModal = addDownlineForm.querySelector('#addDownlinePasswd');
        var passwdConfirmInputModal = addDownlineForm.querySelector('#addDownlinePasswdConfirm');
        var passwordConfirmErrorModal = addDownlineForm.querySelector('#passwordConfirmError');
        var partnerRadioModal = addDownlineForm.querySelector('#addDownlineIsPartnerY'); 
        var normalRadioModal = addDownlineForm.querySelector('#addDownlineIsPartnerN');
        var partnerFeeSectionModal = addDownlineForm.querySelector('#partnerFeeSectionModal');

        addDownlineModal.addEventListener('show.bs.modal', function (event) {
            addDownlineForm.reset(); 
            
            if(passwdConfirmInputModal) passwdConfirmInputModal.classList.remove('is-invalid');
            if(passwordConfirmErrorModal) passwordConfirmErrorModal.style.display = 'none';
            
            if(partnerFeeSectionModal) partnerFeeSectionModal.style.display = 'none';
            if(normalRadioModal) normalRadioModal.checked = true; 

            var button = event.relatedTarget; // 모달을 연 버튼
            var parentIdx = ""; 
            var parentUserid = "없음 (신규 최상위)"; 

            // 어떤 버튼에서 모달이 열렸는지 확인
            if (button && button.classList.contains('add-downline-btn')) { // 테이블 내 '하부추가' 버튼
                 parentIdx = button.getAttribute('data-bs-idx');
                 parentUserid = button.getAttribute('data-bs-userid');
            } else if (button && button.id === 'addNewMemberBtn') { // 상단 '회원추가' 버튼
                 // parentIdx 와 parentUserid는 기본값(최상위)을 사용
            }

            var modalTitle = addDownlineModal.querySelector('.modal-title');
            var parentUseridDisplayInput = addDownlineForm.querySelector('#addDownlineParentUseridDisplay');
            var parentIdxInput = addDownlineForm.querySelector('#addDownlineParentIdx');

            if (modalTitle) modalTitle.textContent = '회원 추가 (상위: ' + parentUserid + ')';
            if (parentUseridDisplayInput) parentUseridDisplayInput.value = parentUserid + (parentIdx ? ' (ID: ' + parentIdx + ')' : '');
            if (parentIdxInput) parentIdxInput.value = parentIdx; 
        });

        function validatePasswordModal() {
            if (passwdInputModal && passwdConfirmInputModal) { 
                if (passwdInputModal.value !== passwdConfirmInputModal.value) {
                    passwdConfirmInputModal.classList.add('is-invalid');
                    if(passwordConfirmErrorModal) passwordConfirmErrorModal.style.display = 'block';
                    return false;
                } else {
                    passwdConfirmInputModal.classList.remove('is-invalid');
                    if(passwordConfirmErrorModal) passwordConfirmErrorModal.style.display = 'none';
                    return true;
                }
            }
            return true; 
        }
        if(passwdInputModal) passwdInputModal.addEventListener('input', validatePasswordModal);
        if(passwdConfirmInputModal) passwdConfirmInputModal.addEventListener('input', validatePasswordModal);
        
        function togglePartnerFeeSectionModal() {
            if (partnerRadioModal && partnerFeeSectionModal) {
                 if (partnerRadioModal.checked) {
                    partnerFeeSectionModal.style.display = 'block';
                } else {
                    partnerFeeSectionModal.style.display = 'none';
                }
            }
        }
        if(partnerRadioModal) partnerRadioModal.addEventListener('change', togglePartnerFeeSectionModal);
        if(normalRadioModal) normalRadioModal.addEventListener('change', togglePartnerFeeSectionModal);

        addDownlineForm.addEventListener('submit', function(event) {
            if (!validatePasswordModal()) {
                event.preventDefault(); 
                alert('비밀번호가 일치하지 않습니다. 다시 확인해주세요.');
            }
        });
    }

    // 일괄 작업 버튼 로직
    const bulkBlockBtn = document.getElementById('bulkBlockBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const memberListForm = document.getElementById('memberListForm'); // 테이블을 감싸는 form
    const bulkActionTypeInput = document.getElementById('bulkActionType'); // 액션 종류를 담을 hidden input

    if (bulkBlockBtn && memberListForm && bulkActionTypeInput) {
        bulkBlockBtn.addEventListener('click', function() {
            const selectedMembers = memberListForm.querySelectorAll('.rowCheckbox:checked');
            if (selectedMembers.length === 0) {
                alert('차단할 회원을 선택해주세요.');
                return;
            }
            if (confirm(selectedMembers.length + '명의 회원을 정말로 차단하시겠습니까?')) {
                bulkActionTypeInput.value = 'block';
                memberListForm.submit();
            }
        });
    }

    if (bulkDeleteBtn && memberListForm && bulkActionTypeInput) {
        bulkDeleteBtn.addEventListener('click', function() {
            const selectedMembers = memberListForm.querySelectorAll('.rowCheckbox:checked');
            if (selectedMembers.length === 0) {
                alert('삭제할 회원을 선택해주세요.');
                return;
            }
            if (confirm(selectedMembers.length + '명의 회원을 정말로 삭제하시겠습니까? (삭제된 데이터는 복구할 수 없습니다)')) {
                 bulkActionTypeInput.value = 'delete';
                 memberListForm.submit();
            }
        });
    }
});
</script>