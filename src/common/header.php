<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Camera Rental System</title>
    <meta name="description" content="Camera Rental System">
    <meta name="viewport" content="width=device-width, initial-scale=0.67">
    <meta name="theme-color" content="#03275A">
    <link rel="stylesheet" href="<?php echo RELATIVE_PATH; ?>/common/css/style.css">
</head>
<body>
<header>
    <nav class="navbar">
<?php if (isset($_SESSION["admin"])) {  /* Admin */ ?>
        <a class="navbar-brand" href="<?php echo RELATIVE_PATH; ?>/" target="_self">Camera Rental System : Admin</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="<?php echo RELATIVE_PATH; ?>/" target="_self">Home</a></li>
            <li class="nav-item <?php if ($module === "member") { echo "active"; } ?>"><a href="?m=member" target="_self">회원관리</a></li>
            <li class="nav-item <?php if ($module === "equipment") { echo "active"; } ?>"><a href="?m=equipment" target="_self">장비관리</a></li>
            <li class="nav-item <?php if ($module === "reservation") { echo "active"; } ?>"><a href="?m=reservation" target="_self">예약관리</a></li>
<?php } else {  /* User */ ?>
            <a class="navbar-brand" href="<?php echo RELATIVE_PATH; ?>/" target="_self">Camera Rental System</a>
        <ul class="navbar-nav">
            <li class="nav-item"><a href="<?php echo RELATIVE_PATH; ?>/" target="_self">Home</a></li>
            <li class="nav-item <?php if ($module === "equipment") { echo "active"; } ?>"><a href="?m=equipment" target="_self">장비조회</a></li>
            <li class="nav-item <?php if ($module === "reservation" and $page === "register") { echo "active"; } ?>"><a href="?m=reservation&p=register" target="_self">예약등록</a></li>
            <li class="nav-item <?php if ($module === "reservation" and $page !== "register") { echo "active"; } ?>"><a href="?m=reservation" target="_self">예약조회</a></li>
<?php } ?>
        </ul>
        <div class="navbar-memberinfo">
            <?php if (isset($_SESSION["member"])) {  /* Logged in */ ?>
                <div class="nav-member">
                    <span>Hello, </span>
                    <span class="nav-member_id"><?php echo $_SESSION["member"]; ?></span>
                </div>
                <div class="nav-logout">
                    <a class="btn" href="?m=logout" target="_self">Logout</a>
                </div>
            <?php } else {  /* Not logged in */ ?>
                <div class="nav-login">
                    <a class="btn" href="?m=login" target="_self">Login</a>
                </div>
            <?php } ?>
        </div>
    </nav>
</header>
