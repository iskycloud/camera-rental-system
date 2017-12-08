<?php
function setupDB() {
    $dbh = connectDB();
    if (isset($dbh)) {

        $sqls = array(
            "CREATE TABLE crs_member (
              id         VARCHAR(80) NOT NULL,
              password   VARCHAR(60) NOT NULL,
              name       VARCHAR(40) NOT NULL,
              tel        VARCHAR(11) NOT NULL,
              memo       TEXT        NULL,
              is_admin   BOOLEAN     NOT NULL DEFAULT FALSE,
              PRIMARY KEY (id)
            );",
            "CREATE TABLE crs_equipment_type (
              sn   TINYINT(1) UNSIGNED NOT NULL,
              name VARCHAR(10)         NOT NULL,
              PRIMARY KEY (sn)
            );",
            "CREATE TABLE crs_equipment (
              sn           BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              is_enabled   BOOLEAN             NOT NULL,
              type_sn      TINYINT(1) UNSIGNED NOT NULL,
              manufacturer VARCHAR(40)         NOT NULL,
              model        VARCHAR(80)         NOT NULL,
              memo         TEXT                NULL,
              PRIMARY KEY (sn),
              FOREIGN KEY (type_sn) REFERENCES crs_equipment_type (sn)
                ON UPDATE NO ACTION
                ON DELETE NO ACTION
            );",
            "CREATE TABLE crs_reservation_status (
              sn   TINYINT(1) UNSIGNED NOT NULL,
              name VARCHAR(10)         NOT NULL,
              PRIMARY KEY (sn)
            );",
            "CREATE TABLE crs_reservation (
              sn                BIGINT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
              status_sn         TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
              member_id         VARCHAR(80)         NOT NULL,
              equipment_sn      BIGINT(11) UNSIGNED NOT NULL,
              start_datetime    DATETIME            NOT NULL,
              end_datetime      DATETIME            NOT NULL,
              memo              TEXT                NULL,
              register_datetime DATETIME            NOT NULL DEFAULT CURRENT_TIMESTAMP,
              is_deleted        BOOLEAN             NOT NULL DEFAULT FALSE,
              PRIMARY KEY (sn),
              FOREIGN KEY (member_id) REFERENCES crs_member (id)
                ON UPDATE NO ACTION
                ON DELETE NO ACTION,
              FOREIGN KEY (equipment_sn) REFERENCES crs_equipment (sn)
                ON UPDATE NO ACTION
                ON DELETE NO ACTION,
              FOREIGN KEY (status_sn) REFERENCES crs_reservation_status (sn)
                ON UPDATE NO ACTION
                ON DELETE NO ACTION
            );",
            "INSERT INTO crs_equipment_type (sn, name)
             VALUES (0, '카메라'), (1, '렌즈');",
            "INSERT INTO crs_reservation_status (sn, name)
             VALUES (0, '신청'), (1, '승인'), (2, '반려'), (3, '완료');",
            "INSERT INTO crs_member (id, password, name, tel, memo, is_admin)
             VALUES ('admin', SHA('admin'), 'admin', '01000000000', 'admin', TRUE);"
        );

        try {
            foreach ($sqls as $sql) {
                $dbh->beginTransaction();
                $sth = $dbh->prepare($sql);
                $sth->execute();
                $dbh->commit();
            }

            return true;
        } catch (Exception $e) {
            $dbh->rollback();
            alertFail($e->getMessage());

            return false;
        } finally {
            disconnectDB($dbh);
        }
    }
}

if (isset($_POST["submit_setting"])) {
    if (setupDB()) {
        alertSuccess("DB 초기 설정 완료. (관리자 ID : admin, 비밀번호 : admin)</p><p><a class='btn btn-success' href='" . RELATIVE_PATH . "/' target='_self'>Home으로 이동</a>");
    } else {
        alertFail("DB 초기 설정 실패.</p><p><a class='btn btn-fail' href='?m=setup' target='_self'>다시시도</a>");
    }
} else { ?>
<article class="content">
    <div class="content-heading">
        <h2 class="content-title">DB 초기 설정</h2>
    </div>
    <div class="content-body">
        <form method="post" action="">
            <div class="alert">
                <p>아래 DB 초기 설정 버튼을 클릭하면 DB 초기 설정이 됩니다.</p>
                <p><input class="btn" type="submit" name="submit_setting" value="DB 초기 설정"></p>
            </div>
        </form>
    </div>
</article>
<?php } ?>