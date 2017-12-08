<?php
/* TODO CHANGE : the value of RELATIVE_PATH */
/* If the path of index.php is root/camera-rental-system/src/index.php, then "/camera-rental-system/src" should be inputted. */
define("RELATIVE_PATH", "/camera-rental-system/src");
define("ABSOLUTE_PATH", $_SERVER['DOCUMENT_ROOT'].RELATIVE_PATH);

$module = $_GET['m'];
$page = $_GET['p'];

session_start();  /* Session starts */

require_once (ABSOLUTE_PATH."/common/classes/all.php");
require_once (ABSOLUTE_PATH."/common/config.php");
require_once (ABSOLUTE_PATH."/common/function.php");

include_once (ABSOLUTE_PATH."/common/header.php"); ?>
<div id="body-content">
<?php
if ($module === "setup") {
    include_once (ABSOLUTE_PATH."/modules/setup.php");
} else if ($module === "login") {
    include_once (ABSOLUTE_PATH."/modules/login/login.php");
} else if ($module === "logout") {
    include_once (ABSOLUTE_PATH."/modules/login/logout.php");
} else if ($module === "member") {
    if (isset($_SESSION["admin"])) {
        $pages = array("register", "modify", "delete");

        if (in_array($page, $pages)) {
            include_once (ABSOLUTE_PATH."/modules/".$module."/".$page.".php");
        } else {
            include_once (ABSOLUTE_PATH."/modules/".$module."/list.php");
        }
    } else {
        alertFail("관리자만 접속할 수 있는 페이지입니다.</p><p><a class='btn btn-fail' href='?m=home' target='_self'>Home으로 이동</a>");
    }
} else if ($module === "equipment") {
    if (isset($_SESSION["member"])) {
        $pages = array("register", "modify", "delete");

        if (in_array($page, $pages)) {
            if (isset($_SESSION["admin"])) {
                include_once (ABSOLUTE_PATH."/modules/".$module."/".$page.".php");
            } else {
                alertFail("관리자만 접속할 수 있는 페이지입니다.</p><p><a class='btn btn-fail' href='?m=home' target='_self'>Home으로 이동</a>");
            }
        } else {
            include_once (ABSOLUTE_PATH."/modules/".$module."/list.php");
        }
    } else {
        alertFail("로그인한 사용자만 이용할 수 있습니다.</p><p><a class='btn btn-fail' href='?m=login' target='_self'>로그인</a>");
    }
} else if ($module === "reservation") {
    if (isset($_SESSION["member"])) {
        $admin_pages = array("modify_status", "delete");

        if ($page === "register") {
            include_once (ABSOLUTE_PATH."/modules/".$module."/".$page.".php");
        }
        else if (in_array($page, $admin_pages)) {
            if (isset($_SESSION["admin"])) {
                include_once (ABSOLUTE_PATH."/modules/".$module."/".$page.".php");
            } else {
                alertFail("관리자만 접속할 수 있는 페이지입니다.</p><p><a class='btn btn-fail' href='?m=home' target='_self'>Home으로 이동</a>");
            }
        } else {
            include_once (ABSOLUTE_PATH."/modules/".$module."/list.php");
        }
    } else {
        alertFail("로그인한 사용자만 이용할 수 있습니다.</p><p><a class='btn btn-fail' href='?m=login' target='_self'>로그인</a>");
    }
} else {
    include_once (ABSOLUTE_PATH."/modules/home.php");
} ?>
</div>
<?php
include_once (ABSOLUTE_PATH."/common/footer.php");