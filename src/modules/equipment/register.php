<?php
if (isset($_POST["submit_register"])) {
    // 등록버튼 클릭한 경우
    if(registerEquipment($_POST["is_enabled"], $_POST["type_sn"], $_POST["manufacturer"], $_POST["model"], $_POST["memo"])) {
        // 등록 성공
        alertSuccess("등록 성공.</p><p><a class='btn btn-success' href='?m=equipment' target='_self'>조회 화면으로 가기</a>");
    } else {
        // 등록 실패
        alertFail("등록 실패.</p><p><a class='btn btn-fail' href='?m=equipment&p=register' target='_self'>다시시도</a>");
    }
} else {
// 페이지에 처음 들어온 경우
    ?>
    <article class="content">
        <div class="content-heading">
            <h2 class="content-title">장비 등록</h2>
        </div>
        <div class="content-body">
            <p>시스템에 장비를 등록하는 화면입니다.</p>
            <p>[등록] 버튼을 클릭하면 시스템에 해당 장비 정보를 등록합니다.</p>
            <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
            <form method="post" action="">
                <table class="table-record">
                    <tbody>
                    <tr>
                        <th>대여가능상태</th>
                        <td>
                            <select name="is_enabled" required>
                                <option value="" selected disabled>대여가능상태를 선택하세요</option>
                                <option value="0">대여불가</option>
                                <option value="1">대여가능</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>종류</th>
                        <td>
                            <select name="type_sn" required>
                                <option value="" selected disabled>종류를 선택하세요</option>
                                <option value="0">카메라</option>
                                <option value="1">렌즈</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>제조사명</th>
                        <td><input type="text" name="manufacturer" placeholder="제조사명을 입력하세요" maxlength="40" required></td>
                    </tr>
                    <tr>
                        <th>모델명</th>
                        <td><input type="text" name="model" placeholder="모델명을 입력하세요" maxlength="80" required></td>
                    </tr>
                    <tr>
                        <th>메모</th>
                        <td><input type="text" name="memo" placeholder="메모를 입력하세요"></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2">
                            <input class="btn" type="submit" name="submit_register" value="등록">
                            <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=equipment';">
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </article>
<?php } ?>