<!-- 머니 지급/회수/게임머니 회수 모달 -->
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .btn-group-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 5px;
        width: 100%;
    }
    .btn-group-grid .btn {
        width: 100%;
    }
</style>

<!-- 머니 지급/회수 모달 -->
<div class="modal fade" id="moneyActionModal" tabindex="-1" aria-labelledby="moneyActionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold p-2" id="moneyActionModalLabel">머니 지급/회수</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="moneyActionForm" action="member_money_action.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="moneyActionType" name="action_type" value="">
                    <input type="hidden" id="memberIdx" name="member_idx" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">회원 정보</label>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="fw-bold">아이디:</span> <span id="memberIdDisplay"></span>
                            </div>
                            <div>
                                <span class="fw-bold">닉네임:</span> <span id="memberNickDisplay"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">현재 잔액</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="currentBalance" readonly>
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="actionAmount" class="form-label">금액 <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="actionAmount" name="amount"  min="1">
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <!-- 간편 금액 버튼 -->
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="btn-group-grid">
                                <button type="button" class="btn btn-primary quick-amount" data-amount="10000">1만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="30000">3만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="50000">5만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="100000">10만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="300000">30만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="500000">50만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="1000000">100만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="5000000">500만</button>
                                <button type="button" class="btn btn-primary quick-amount" data-amount="10000000">1000만</button>
                                <button type="button" class="btn btn-warning quick-amount" data-amount="0">정정</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="actionMemo" class="form-label">메모</label>
                        <textarea class="form-control" id="actionMemo" name="memo" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-primary" id="actionSubmitBtn">지급하기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 머니 회수 모달 -->
<div class="modal fade" id="moneyWithdrawModal" tabindex="-1" aria-labelledby="moneyWithdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold p-2" id="moneyWithdrawModalLabel">머니 회수</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="moneyWithdrawForm" action="member_money_action.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="action_type" value="withdraw">
                    <input type="hidden" id="withdrawMemberIdx" name="member_idx" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">회원 정보</label>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="fw-bold">아이디:</span> <span id="withdrawMemberIdDisplay"></span>
                            </div>
                            <div>
                                <span class="fw-bold">닉네임:</span> <span id="withdrawMemberNickDisplay"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">현재 잔액</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="withdrawCurrentBalance" readonly>
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdrawAmount" class="form-label">금액 <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="withdrawAmount" name="amount"  min="1">
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <!-- 간편 금액 버튼 -->
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="btn-group-grid">
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="10000">1만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="30000">3만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="50000">5만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="100000">10만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="300000">30만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="500000">50만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="1000000">100만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="5000000">500만</button>
                                <button type="button" class="btn btn-primary withdraw-quick-amount" data-amount="10000000">1000만</button>
                                <button type="button" class="btn btn-warning withdraw-quick-amount" data-amount="0">정정</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="withdrawMemo" class="form-label">메모</label>
                        <textarea class="form-control" id="withdrawMemo" name="memo" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-danger">회수하기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 게임회수 모달 -->
<div class="modal fade" id="gameMoneyWithdrawModal" tabindex="-1" aria-labelledby="gameMoneyWithdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-dark fw-bold p-2" id="gameMoneyWithdrawModalLabel">게임회수</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="gameMoneyWithdrawForm" action="member_game_money_action.php" method="post">
                <div class="modal-body">
                    <input type="hidden" name="action_type" value="withdraw">
                    <input type="hidden" id="gameWithdrawMemberIdx" name="member_idx" value="">
                    
                    <div class="mb-3">
                        <label class="form-label">회원 정보1</label>
                        <div class="d-flex">
                            <div class="me-3">
                                <span class="fw-bold">아이디:</span> <span id="gameWithdrawMemberIdDisplay"></span>
                            </div>
                            <div>
                                <span class="fw-bold">닉네임:</span> <span id="gameWithdrawMemberNickDisplay"></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">현재 게임 잔액</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="gameWithdrawCurrentBalance" readonly>
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="gameWithdrawAmount" class="form-label">금액 <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="gameWithdrawAmount" name="amount"  min="1">
                            <span class="input-group-text">원</span>
                        </div>
                    </div>
                    
                    <!-- 간편 금액 버튼 -->
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="btn-group-grid">
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="10000">1만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="30000">3만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="50000">5만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="100000">10만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="300000">30만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="500000">50만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="1000000">100만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="5000000">500만</button>
                                <button type="button" class="btn btn-primary game-withdraw-quick-amount" data-amount="10000000">1000만</button>
                                <button type="button" class="btn btn-warning game-withdraw-quick-amount" data-amount="0">정정</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="gameWithdrawMemo" class="form-label">메모</label>
                        <textarea class="form-control" id="gameWithdrawMemo" name="memo" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                    <button type="submit" class="btn btn-danger">회수하기</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 머니 액션 버튼 클릭 이벤트
    const moneyActionBtns = document.querySelectorAll('.money-action-btn');
    if (moneyActionBtns) {
        moneyActionBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const memberIdx = this.getAttribute('data-member-idx');
                const memberId = this.getAttribute('data-member-id');
                const memberNick = this.getAttribute('data-member-nick');
                const memberBalance = this.getAttribute('data-member-balance');
                
                // 모달 타이틀 및 버튼 텍스트 설정
                document.getElementById('moneyActionModalLabel').textContent = 
                    action === 'deposit' ? '머니 지급' : '머니 회수';
                document.getElementById('actionSubmitBtn').textContent = 
                    action === 'deposit' ? '지급하기' : '회수하기';
                
                // 폼 데이터 설정
                document.getElementById('moneyActionType').value = action;
                document.getElementById('memberIdx').value = memberIdx;
                document.getElementById('memberIdDisplay').textContent = memberId;
                document.getElementById('memberNickDisplay').textContent = memberNick;
                document.getElementById('currentBalance').value = Number(memberBalance).toLocaleString() + ' 원';
                
                // 모달 표시
                const moneyModal = new bootstrap.Modal(document.getElementById('moneyActionModal'));
                moneyModal.show();
            });
        });
    }
    
    // 머니 회수 버튼 클릭 이벤트
    const moneyWithdrawBtns = document.querySelectorAll('.money-withdraw-btn');
    if (moneyWithdrawBtns) {
        moneyWithdrawBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const memberIdx = this.getAttribute('data-member-idx');
                const memberId = this.getAttribute('data-member-id');
                const memberNick = this.getAttribute('data-member-nick');
                const memberBalance = this.getAttribute('data-member-balance');
                
                // 폼 데이터 설정
                document.getElementById('withdrawMemberIdx').value = memberIdx;
                document.getElementById('withdrawMemberIdDisplay').textContent = memberId;
                document.getElementById('withdrawMemberNickDisplay').textContent = memberNick;
                document.getElementById('withdrawCurrentBalance').value = Number(memberBalance).toLocaleString() + ' 원';
                
                // 모달 표시
                const withdrawModal = new bootstrap.Modal(document.getElementById('moneyWithdrawModal'));
                withdrawModal.show();
            });
        });
    }
    
    // 게임회수 버튼 클릭 이벤트
    const gameMoneyWithdrawBtns = document.querySelectorAll('.game-money-withdraw-btn');
    if (gameMoneyWithdrawBtns) {
        gameMoneyWithdrawBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const memberIdx = this.getAttribute('data-member-idx');
                const memberId = this.getAttribute('data-member-id');
                const memberNick = this.getAttribute('data-member-nick');
                const gameBalance = this.getAttribute('data-game-balance');
                
                // 폼 데이터 설정
                document.getElementById('gameWithdrawMemberIdx').value = memberIdx;
                document.getElementById('gameWithdrawMemberIdDisplay').textContent = memberId;
                document.getElementById('gameWithdrawMemberNickDisplay').textContent = memberNick;
                document.getElementById('gameWithdrawCurrentBalance').value = Number(gameBalance).toLocaleString() + ' 원';
                
                // 모달 표시
                const gameWithdrawModal = new bootstrap.Modal(document.getElementById('gameMoneyWithdrawModal'));
                gameWithdrawModal.show();
            });
        });
    }
    
    // 간편 금액 버튼 클릭 이벤트 (머니 지급/회수)
    const quickAmountBtns = document.querySelectorAll('.quick-amount');
    if (quickAmountBtns) {
        quickAmountBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const amount = parseInt(this.getAttribute('data-amount'));
                const currentInput = document.getElementById('actionAmount');
                
                if (amount === 0) {
                    // 정정 버튼인 경우 값을 초기화
                    currentInput.value = '';
                } else {
                    // 현재 값이 있으면 더하고, 없으면 새 값 설정
                    const currentAmount = currentInput.value ? parseInt(currentInput.value) : 0;
                    currentInput.value = currentAmount + amount;
                }
            });
        });
    }
    
    // 간편 금액 버튼 클릭 이벤트 (머니 회수)
    const withdrawQuickAmountBtns = document.querySelectorAll('.withdraw-quick-amount');
    if (withdrawQuickAmountBtns) {
        withdrawQuickAmountBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const amount = parseInt(this.getAttribute('data-amount'));
                const currentInput = document.getElementById('withdrawAmount');
                
                if (amount === 0) {
                    // 정정 버튼인 경우 값을 초기화
                    currentInput.value = '';
                } else {
                    // 현재 값이 있으면 더하고, 없으면 새 값 설정
                    const currentAmount = currentInput.value ? parseInt(currentInput.value) : 0;
                    currentInput.value = currentAmount + amount;
                }
            });
        });
    }
    
    // 간편 금액 버튼 클릭 이벤트 (게임회수)
    const gameWithdrawQuickAmountBtns = document.querySelectorAll('.game-withdraw-quick-amount');
    if (gameWithdrawQuickAmountBtns) {
        gameWithdrawQuickAmountBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                const amount = parseInt(this.getAttribute('data-amount'));
                const currentInput = document.getElementById('gameWithdrawAmount');
                
                if (amount === 0) {
                    // 정정 버튼인 경우 값을 초기화
                    currentInput.value = '';
                } else {
                    // 현재 값이 있으면 더하고, 없으면 새 값 설정
                    const currentAmount = currentInput.value ? parseInt(currentInput.value) : 0;
                    currentInput.value = currentAmount + amount;
                }
            });
        });
    }
    
    // 머니 지급/회수 폼 제출 이벤트
    const moneyActionForm = document.getElementById('moneyActionForm');
    if (moneyActionForm) {
        moneyActionForm.addEventListener('submit', function(event) {
            const amountInput = document.getElementById('actionAmount');
            const actionType = document.getElementById('moneyActionType').value;
            const actionText = actionType === 'deposit' ? '지급' : '회수';
            
            if (!amountInput.value || amountInput.value === '0') {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: '입력 오류',
                    text: `머니를 입력해주세요.`,
                    confirmButtonText: '확인'
                });
            }
        });
    }
    
    // 머니 회수 폼 제출 이벤트
    const moneyWithdrawForm = document.getElementById('moneyWithdrawForm');
    if (moneyWithdrawForm) {
        moneyWithdrawForm.addEventListener('submit', function(event) {
            const amountInput = document.getElementById('withdrawAmount');
            
            if (!amountInput.value || amountInput.value === '0') {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: '입력 오류',
                    text: `머니를 입력해주세요.`,
                    confirmButtonText: '확인'
                });
            }
        });
    }
    
    // 게임머니 회수 폼 제출 이벤트
    const gameMoneyWithdrawForm = document.getElementById('gameMoneyWithdrawForm');
    if (gameMoneyWithdrawForm) {
        gameMoneyWithdrawForm.addEventListener('submit', function(event) {
            const amountInput = document.getElementById('gameWithdrawAmount');
            
            if (!amountInput.value || amountInput.value === '0') {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: '입력 오류',
                    text: `머니를 입력해주세요.`,
                    confirmButtonText: '확인'
                });
            }
        });
    }
});
</script>
