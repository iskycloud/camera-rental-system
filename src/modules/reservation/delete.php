<?php
if (isset($_POST["submit_delete"])) {
    // 삭제 버튼 클릭한 경우
    if(deleteReservation($_POST["sn"])) {
        // 삭제 성공
        alertSuccess("정보 삭제 성공.</p><p><a class='btn btn-success' href='?m=reservation' target='_self'>조회 화면으로 가기</a></p>");
    } else {
        // 삭제 실패
        alertFail("정보 삭제 실패.</p><p><a class='btn btn-fail' href='?m=reservation&p=delete&sn=" . $_POST["sn"] . "' target='_self'>다시시도</a></p>");
    }
} else {
    // 페이지에 처음 들어온 경우
    $result = searchReservation($_GET["sn"]);
    if (!empty($result)) {
        // The information corresponding to sn exists
        ?>
        <article class="content">
            <div class="content-heading">
                <h2 class="content-title">예약 정보 삭제</h2>
            </div>
            <div class="content-body">
                <p>시스템에 등록된 예약 정보를 삭제하는 화면입니다.</p>
                <p>[삭제] 버튼을 클릭하면 시스템에 해당 예약 정보를 삭제합니다.</p>
                <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
                <form method="post" action="">
                    <table class="table-record">
                        <tbody>
                        <tr>
                            <th>예약일련번호</th>
                            <td><input type="number" name="sn" value="<?php echo $result->getSN(); ?>" readonly required></td>
                        </tr>
                        <tr>
                            <th>예약상태</th>
                            <td>
                                <select name="status_sn" disabled>
                                    <option value="" disabled>예약상태를 선택하세요</option>
                                    <option value="0" <?php if ($result->getStatusSN() == 0) {echo "selected";} ?>>신청</option>
                                    <option value="1" <?php if ($result->getStatusSN() == 1) {echo "selected";} ?>>승인</option>
                                    <option value="2" <?php if ($result->getStatusSN() == 2) {echo "selected";} ?>>반려</option>
                                    <option value="3" <?php if ($result->getStatusSN() == 3) {echo "selected";} ?>>완료</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>회원ID</th>
                            <td><input type="text" value="<?php echo $result->getMemberID(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>장비일련번호</th>
                            <td><input type="number" value="<?php echo $result->getEquipementSN(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>희망예약시작일시</th>
                            <td><input type="text" value="<?php echo $result->getStartDatetime(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>희망예약종료일시</th>
                            <td><input type="text" value="<?php echo $result->getEndDatetime(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>메모</th>
                            <td><input type="text" value="<?php echo $result->getMemo(); ?>" disabled></td>
                        </tr>
                        <tr>
                            <th>등록일시</th>
                            <td><input type="text" value="<?php echo $result->getRegisterDatetime(); ?>" disabled></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="2">
                                <input class="btn" type="submit" name="submit_delete" value="삭제">
                                <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=reservation';">
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </article>
        <?php
    } else {
        // The information corresponding to sn not exists. In other words, Invalid approach.
        alertFail("Invalid approach.</p><p><a class='btn btn-fail' href='?m=reservation' target='_self'>조회화면으로 가기</a></p>");
    }
}
?>