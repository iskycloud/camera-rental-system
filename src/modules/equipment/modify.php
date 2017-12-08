<?php
if (isset($_POST["submit_modify"])) {
    // 수정 버튼 클릭한 경우
    if(modifyEquipment($_POST["sn"], $_POST["is_enabled"], $_POST["type_sn"], $_POST["manufacturer"], $_POST["model"], $_POST["memo"])) {
        // 수정 성공
        alertSuccess("정보 수정 성공.</p><p><a class='btn btn-success' href='?m=equipment' target='_self'>조회 화면으로 가기</a></p>");
    } else {
        // 수정 실패
        alertFail("정보 수정 실패.</p><p><a class='btn btn-fail' href='?m=equipment&p=modify&sn=" . $_POST["sn"] . "' target='_self'>다시시도</a></p>");
    }
} else {
    // 페이지에 처음 들어온 경우
    $result = searchEquipment($_GET["sn"]);
    if (!empty($result)) {
        // The information corresponding to sn exists
        ?>
        <article class="content">
            <div class="content-heading">
                <h2 class="content-title">장비 정보 수정</h2>
            </div>
            <div class="content-body">
                <p>시스템에 등록된 장비 정보를 수정하는 화면입니다.</p>
                <p>[수정] 버튼을 클릭하면 시스템에 해당 장비 정보를 수정합니다.</p>
                <p>[취소] 버튼을 클릭하면 작업을 취소합니다.</p><br>
                <form method="post" action="">
                    <table class="table-record">
                        <tbody>
                        <tr>
                            <th>장비일련번호</th>
                            <td><input type="number" name="sn" value="<?php echo $result->getSN(); ?>" readonly required></td>
                        </tr>
                        <tr>
                            <th>대여가능상태</th>
                            <td>
                                <select name="is_enabled" required>
                                    <option value="" disabled>대여가능상태를 선택하세요</option>
                                    <option value="0" <?php if ($result->getIsEnabled() == FALSE) {echo "selected";} ?>>대여불가</option>
                                    <option value="1" <?php if ($result->getIsEnabled() == TRUE) {echo "selected";} ?>>대여가능</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>종류</th>
                            <td>
                                <select name="type_sn" required>
                                    <option value="" disabled>종류를 선택하세요</option>
                                    <option value="0" <?php if ($result->getTypeSN() == 0) {echo "selected";} ?>>카메라</option>
                                    <option value="1" <?php if ($result->getTypeSN() == 1) {echo "selected";} ?>>렌즈</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>제조사명</th>
                            <td><input type="text" name="manufacturer" value="<?php echo $result->getManufacturer(); ?>" placeholder="제조사명을 입력하세요" maxlength="40" required></td>
                        </tr>
                        <tr>
                            <th>모델명</th>
                            <td><input type="text" name="model" value="<?php echo $result->getModel(); ?>" placeholder="모델명을 입력하세요" maxlength="80" required></td>
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
                                <input class="btn" type="button" value="취소" onclick="javascript:document.location.href='?m=equipment';">
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
        alertFail("Invalid approach.</p><p><a class='btn btn-fail' href='?m=equipment' target='_self'>조회화면으로 가기</a></p>");
    }
}
?>