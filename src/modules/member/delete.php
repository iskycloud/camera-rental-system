<?php
if (isset($_POST["submit_delete"])) {
    // 삭제 버튼 클릭한 경우
    if(deleteMember($_POST["id"])) {
        // 삭제 성공
        alertSuccess("삭제 성공.</p><p><a class='btn btn-success' href='?m=member' target='_self'>조회 화면으로 가기</a></p>");
    } else {
        // 삭제 실패
        alertFail("삭제 실패.</p><p><a class='btn btn-fail' href='?m=member&p=delete&id=" . $_POST["id"] . "' target='_self'>다시시도</a></p>");
    }
} else {
    // 페이지에 처음 들어온 경우
    $result = searchMember($_GET["id"]);
    if (!empty($result)) {
        // The information corresponding to id exists
        ?>
        <article class="content">
            <div class="content-heading">
                <h2 class="content-title">회원 삭제</h2>
            </div>
            <div class="content-body">
                <p>시스템에 등록된 회원을 삭제하는 화면입니다.</p>
                <p>[삭제] 버튼을 클릭하면 시스템에서 해당 회원 정보를 삭제합니다.</p>
                <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
                <form method="post" action="">
                    <table class="table-record">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <td><input type="text" name="id" value="<?php echo $result->getID(); ?>" readonly required></td>
                        </tr>
                        <tr>
                            <th>이름</th>
                            <td><input type="text" name="name" value="<?php echo $result->getName(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>전화번호</th>
                            <td><input type="number" name="tel" value="<?php echo $result->getTel(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>메모</th>
                            <td><input type="text" name="memo" value="<?php echo $result->getMemo(); ?>" disabled></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                <input class="btn" type="submit" name="submit_delete" value="삭제">
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