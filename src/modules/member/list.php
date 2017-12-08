<?php
$result = null;

if (isset($_POST["submit_register"])) {
    header("Location:?m=member&p=register");
} else if (isset($_POST["submit_modify"]) and !empty($_POST["member_id"])) {
    header("Location:?m=member&p=modify&id=" . $_POST["member_id"]);
} else if (isset($_POST["submit_delete"]) and !empty($_POST["member_id"])) {
    header("Location:?m=member&p=delete&id=" . $_POST["member_id"]);
} else {
    $result = searchAllMember();
}
?>
<article class="content">
    <div class="content-heading">
        <h2 class="content-title">회원 조회</h2>
    </div>
    <div class="content-body">
        <p>시스템에 등록된 회원 내역을 조회하는 화면입니다.</p>
        <p>[등록] 버튼을 클릭하면 회원 등록 화면으로 이동합니다.</p>
        <p>[정보수정] 버튼을 클릭하면 회원 정보 수정 화면으로 이동합니다.</p>
        <p>[선택] 라디오 버튼을 클릭하고 [삭제] 버튼을 클릭하면 회원 삭제 화면으로 이동합니다.</p><br>
        <form method="post" action="">
            <table class="table-list">
                <thead>
                <tr>
                    <th>선택</th>
                    <th>ID</th>
                    <th>이름</th>
                    <th>연락처</th>
                    <th>메모</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!empty($result)) {
                    // result exists
                    if (count($result) > 0) {
                        for ($idx = 0; $idx < count($result); $idx++) {
                            // Outputs result to rows of table on Document
                            echo $result[$idx]->outputAsTableRow();
                        }
                    }
                } else {
                    // result not exists
                    echo "<tr><td colspan='5'>해당 항목이 없습니다.</td></tr>";
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="5">
                        <input class="btn" type="submit" name="submit_register" value="등록">
                        <input class="btn" type="submit" name="submit_modify" value="정보수정">
                        <input class="btn" type="submit" name="submit_delete" value="삭제">
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</article>