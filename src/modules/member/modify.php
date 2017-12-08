<?php
if (isset($_POST["submit_modify"])) {
    // 수정 버튼 클릭한 경우
    if(modifyMember($_POST["id"], $_POST["password"], $_POST["name"], $_POST["tel"], $_POST["memo"])) {
        // 수정 성공
        alertSuccess("정보 수정 성공.</p><p><a class='btn btn-success' href='?m=member' target='_self'>조회 화면으로 가기</a></p>");
    } else {
        // 수정 실패
        alertFail("정보 수정 실패.</p><p><a class='btn btn-fail' href='?m=member&p=modify&id=" . $_POST["id"] . "' target='_self'>다시시도</a></p>");
    }
} else {
    // 페이지에 처음 들어온 경우
    $result = searchMember($_GET["id"]);
    if (!empty($result)) {
        // The information corresponding to id exists
        ?>
        <article class="content">
            <div class="content-heading">
                <h2 class="content-title">회원 정보 수정</h2>
            </div>
            <div class="content-body">
                <p>시스템에 등록된 회원 정보를 수정하는 화면입니다.</p>
                <p>[수정] 버튼을 클릭하면 시스템에 해당 회원 정보를 수정합니다.</p>
                <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
                <form method="post" action="">
                    <table class="table-record">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td><input type="text" name="id" value="<?php echo $result->getID(); ?>" readonly required></td>
                        </tr>
                        <tr>
                            <th>비밀번호</th>
                            <td><input type="password" name="password" value="" placeholder="비밀번호를 입력하세요" maxlength="60" required></td>
                        </tr>
                        <tr>
                            <th>이름</th>
                            <td><input type="text" name="name" value="<?php echo $result->getName(); ?>" placeholder="이름을 입력하세요" maxlength="40" required></td>
                        </tr>
                        <tr>
                            <th>전화번호</th>
                            <td><input type="number" name="tel" value="<?php echo $result->getTel(); ?>" placeholder="전화번호를 입력하세요(예: 01012345678)" maxlength="11" required></td>
                        </tr>
                        <tr>
                            <th>메모</th>
                            <td><input type="text" name="memo" value="<?php echo $result->getMemo(); ?>" placeholder="메모를 입력하세요"></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                <input class="btn" type="submit" name="submit_modify" value="수정">
                                <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=member';">
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </article>
        <?php
    } else {
        // The information corresponding to id not exists. In other words, Invalid approach.
        alertFail("Invalid approach.</p><p><a class='btn btn-fail' href='?m=member' target='_self'>조회화면으로 가기</a></p>");
    }
}
?>