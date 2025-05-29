<!-- 하부회원 추가 모달 -->
<div class="modal fade" id="addDownlineModal" tabindex="-1" aria-labelledby="addDownlineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered"> 
        <div class="modal-content">
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
</div>
