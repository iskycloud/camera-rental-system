<?php
if (isset($_POST["submit_register"])) {
    // 등록버튼 클릭한 경우
    $member_id = null;
    if (isset($_SESSION["admin"])) {
        $member_id = $_POST["member_id"];
    }
    else {
        $member_id = $_SESSION["member"];
    }
    if(registerReservation($member_id, $_POST["equipment_sn"], $_POST["start_datetime"], $_POST["end_datetime"], $_POST["memo"])) {
        // 등록 성공
        alertSuccess("등록 성공.</p><p><a class='btn btn-success' href='?m=reservation' target='_self'>조회 화면으로 가기</a>");
    } else {
        // 등록 실패
        alertFail("등록 실패.</p><p><a class='btn btn-fail' href='?m=reservation&p=register' target='_self'>다시시도</a>");
    }
} else {
// 페이지에 처음 들어온 경우
    ?>
    <article class="content">
        <div class="content-heading">
            <h2 class="content-title">예약 등록</h2>
        </div>
        <div class="content-body">
            <p>시스템에 예약를 등록하는 화면입니다.</p>
            <p>[등록] 버튼을 클릭하면 시스템에 해당 예약 정보를 등록합니다.</p>
            <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
            <form method="post" action="">
                <table class="table-record">
                    <tbody>
                    <tr>
                        <th>회원ID</th>
                        <td><input type="text" name="member_id" value="<?php if (!isset($_SESSION["admin"])) { echo $_SESSION["member"]."\" readonly"; } else { echo "\""; } ?> placeholder="회원ID를 입력하세요" maxlength="80" required></td>
                    </tr>
                    <tr>
                        <th>장비일련번호</th>
                        <td><input type="number" name="equipment_sn" placeholder="장비일련번호를 입력하세요" maxlength="11" required></td>
                    </tr>
                    <tr>
                        <th>희망예약시작일시</th>
                        <td><input type="datetime-local" name="start_datetime" placeholder="희망예약시작일시를 입력하세요" maxlength="40" required></td>
                    </tr>
                    <tr>
                        <th>희망예약종료일시</th>
                        <td><input type="datetime-local" name="end_datetime" placeholder="희망예약종료일시를 입력하세요" maxlength="80" required></td>
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
                            <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=reservation';">
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </form>
        </div>
    </article>
<?php } ?>