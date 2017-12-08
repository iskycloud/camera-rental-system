<?php
$result = null;

if (isset($_POST["submit_register"])) {
    header("Location:?m=equipment&p=register");
} else if (isset($_POST["submit_modify"]) and !empty($_POST["equipment_sn"])) {
    header("Location:?m=equipment&p=modify&sn=" . $_POST["equipment_sn"]);
} else if (isset($_POST["submit_delete"]) and !empty($_POST["equipment_sn"])) {
    header("Location:?m=equipment&p=delete&sn=" . $_POST["equipment_sn"]);
} else {
    $result = searchAllEquipment();
}
?>
<article class="content">
    <div class="content-heading">
        <h2 class="content-title">장비 조회</h2>
    </div>
    <div class="content-body">
        <p>시스템에 등록된 장비 내역을 조회하는 화면입니다.</p>
        <?php if (isset($_SESSION["admin"])) {  /* Admin menu */ ?>
        <p>[등록] 버튼을 클릭하면 장비 등록 화면으로 이동합니다.</p>
        <p>[선택] 라디오 버튼을 클릭하고 [정보수정] 버튼을 클릭하면 장비 정보 수정 화면으로 이동합니다.</p>
        <p>[선택] 라디오 버튼을 클릭하고 [삭제] 버튼을 클릭하면 장비 삭제 화면으로 이동합니다.</p>
        <?php } else { ?>
        <link rel="stylesheet" href="<?php echo RELATIVE_PATH ?>/common/css/not_admin.css">
        <?php } ?>
        <br>
        <form method="post" action="">
            <table class="table-list">
                <thead>
                <tr>
                    <th>선택</th>
                    <th>장비일련번호</th>
                    <th>대여가능상태</th>
                    <th>종류</th>
                    <th>제조사명</th>
                    <th>모델명</th>
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
                    echo "<tr><td colspan='7'>해당 항목이 없습니다.</td></tr>";
                }
                ?>
                </tbody>
                <?php if (isset($_SESSION["admin"])) {  /* Admin menu */ ?>
                <tfoot>
                <tr>
                    <td colspan="7">
                        <input class="btn" type="submit" name="submit_register" value="등록">
                        <input class="btn" type="submit" name="submit_modify" value="정보수정">
                        <input class="btn" type="submit" name="submit_delete" value="삭제">
                    </td>
                </tr>
                </tfoot>
                <?php } ?>
            </table>
        </form>
    </div>
</article>