<?php
if (isset($_POST["submit_register"])) {
    // 등록버튼 클릭한 경우
    if(registerMember($_POST["id"], $_POST["password"], $_POST["name"], $_POST["tel"], $_POST["memo"])) {
        // 등록 성공
        alertSuccess("등록 성공.</p><p><a class='btn btn-success' href='?m=member' target='_self'>조회 화면으로 가기</a>");
    } else {
        // 등록 실패
        alertFail("등록 실패.</p><p><a class='btn btn-fail' href='?m=member&p=register' target='_self'>다시시도</a>");
    }
} else {
// 페이지에 처음 들어온 경우
    ?>
    <article class="content">
        <div class="content-heading">
            <h2 class="content-title">회원 등록</h2>
        </div>
        <div class="content-body">
            <p>시스템에 회원을 등록하는 화면입니다.</p>
            <p>[등록] 버튼을 클릭하면 시스템에 해당 회원 정보를 등록합니다.</p>
            <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
            <form method="post" action="">
                <table class="table-record">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td><input type="text" name="id" placeholder="ID를 입력하세요" maxlength="80" pattern="[a-zA-Z0-9]+" title="영어와 숫자만 입력하세요" required></td>
                    </tr>
                    <tr>
                        <th>비밀번호</th>
                        <td><input type="password" name="password" placeholder="비밀번호를 입력하세요" maxlength="60" required></td>
                    </tr>
                    <tr>
                        <th>이름</th>
                        <td><input type="text" name="name" placeholder="이름을 입력하세요" maxlength="40" required></td>
                    </tr>
                    <tr>
                        <th>전화번호</th>
                        <td><input type="number" name="tel" placeholder="전화번호를 입력하세요(예: 01012345678)" maxlength="11" required></td>
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
                            <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=member';">
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </article>
<?php } ?>