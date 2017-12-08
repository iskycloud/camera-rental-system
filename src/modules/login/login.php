<?php
if (isset($_SESSION["member"])) {
    alertFail("이미 로그인되었습니다.</p><p><a class='btn btn-fail' href='".RELATIVE_PATH."/' target='_self'>Home으로 이동</a>");
}
else if (isset($_POST["submit_login"])) {
    if (empty($_POST["input_id"]) or empty($_POST["input_password"])) {
        alertFail("아이디나 비밀번호를 입력하세요.</p><p><a class='btn btn-fail' href='?m=login' target='_self'>로그인</a>");
    } else {
        if (!empty($member = login($_POST["input_id"], $_POST["input_password"]))) {
            $_SESSION["member"] = $member->getID();
            if ($member->IsAdmin()) {
                $_SESSION["admin"] = TRUE;
            }
            alertSuccess("로그인에 성공하였습니다.</p><p><a class='btn btn-success' href='".RELATIVE_PATH."/' target='_self'>Home으로 이동</a>");
        }
        else {
            alertFail("로그인에 실패하였습니다.</p><p><a class='btn btn-fail' href='?m=login' target='_self'>로그인</a>");
        }
    }
}
else { ?>
<link rel="stylesheet" href="<?php echo RELATIVE_PATH; ?>/modules/login/login.css">
<div class="content">
    <div class="content-body">
        <p>ID와 비밀번호를 입력하고, [Login] 버튼을 클릭하면 로그인이 됩니다.</p><br>
        <form id="login" method="post" action="">
            <table>
                <tbody>
                <tr>
                    <th>ID</th>
                    <td>
                        <input type="text" name="input_id" placeholder="ID" maxlength="80" pattern="[a-zA-Z0-9]+" title="영어와 숫자만 입력하세요">
                    </td>
                </tr>
                <tr>
                    <th>비밀번호</th>
                    <td>
                        <input type="password" name="input_password" maxlength="60" placeholder="Password">
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2">
                        <input class="btn" type="submit" name="submit_login" value="Login">
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>
</div>
<?php } ?>