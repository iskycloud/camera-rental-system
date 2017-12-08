<?php
$result = null;

if (isset($_POST["submit_register"])) {
    header("Location:?m=reservation&p=register");
} else if (isset($_POST["submit_modify_status"]) and !empty($_POST["reservation_sn"])) {
    header("Location:?m=reservation&p=modify_status&sn=" . $_POST["reservation_sn"]);
} else if (isset($_POST["submit_delete"]) and !empty($_POST["reservation_sn"])) {
    header("Location:?m=reservation&p=delete&sn=" . $_POST["reservation_sn"]);
} else {
    if (isset($_SESSION["admin"])) {
        $result = searchAllReservation();
    } else {
        $result = searchAllReservationMember($_SESSION["member"]);
    }
}
?>
<article class="content">
    <div class="content-heading">
        <h2 class="content-title">예약 조회</h2>
    </div>
    <div class="content-body">
        <p>시스템에 등록된 예약 내역을 조회하는 화면입니다.</p>
        <?php if (isset($_SESSION["admin"])) {  /* Admin menu */ ?>
        <p>[등록] 버튼을 클릭하면 예약 등록 화면으로 이동합니다.</p>
        <p>[상태변경] 버튼을 클릭하면 예약 상태 변경 화면으로 이동합니다.</p>
        <p>[선택] 라디오 버튼을 클릭하고 [삭제] 버튼을 클릭하면 예약 삭제 화면으로 이동합니다.</p>
        <?php } else { ?>
        <link rel="stylesheet" href="<?php echo RELATIVE_PATH ?>/common/css/not_admin.css">
        <?php } ?>
        <br>
        <form method="post" action="">
            <table class="table-list">
                <thead>
                <tr>
                    <th>선택</th>
                    <th>예약일련번호</th>
                    <th>상태</th>
                    <th>회원ID</th>
                    <th>장비일련번호</th>
                    <th>희망예약시작일시</th>
                    <th>희망예약종료일시</th>
                    <th>메모</th>
                    <th>등록일시</th>
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
                    echo "<tr><td colspan='9'>해당 항목이 없습니다.</td></tr>";
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="9">
                        <input class="btn" type="submit" name="submit_register" value="등록">
                        <?php if (isset($_SESSION["admin"])) { ?>
                        <input class="btn" type="submit" name="submit_modify_status" value="상태변경">
                        <input class="btn" type="submit" name="submit_delete" value="삭제">
                        <?php } ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</article>