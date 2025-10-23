<?php
defined('MOODLE_INTERNAL') || die();
global $OUTPUT, $PAGE, $USER;

$fullname = fullname($USER);
$profileurl = new moodle_url('/user/profile.php', ['id' => $USER->id]);
?>

<?= $OUTPUT->doctype() ?>
<html <?= $OUTPUT->htmlattributes() ?>>
<head>
    <title><?= $OUTPUT->page_title(); ?></title>
    <?= $OUTPUT->standard_head_html() ?>
</head>
<body <?= $OUTPUT->body_attributes() ?>>

<?= $OUTPUT->standard_top_of_body_html() ?>

<!-- Topbar -->
<header class="topbar">
    <button id="menu-toggle" aria-label="Toggle menu">☰</button>
    <div class="logo">KT Digital Campus</div>
    <div class="user-menu">
        <span><?= $fullname ?></span>
        <a href="<?= $profileurl ?>" style="color: white;">Profile</a>
    </div>
</header>

<!-- Page wrapper -->
<div id="dashboard-wrapper">
    <!-- Sidebar -->
<nav id="sidebar" class="expanded">
    <ul>
        <li><a href="<?= new moodle_url('/my/'); ?>"><img class="menu-icon"  src="<?= new moodle_url('/theme/stream/pix/icons/management.svg'); ?>" alt="Панель управления" width="18" height="18"><span class="label">Dashboard</span></a></li>
                <li><a href="<?= new moodle_url('/course/index.php'); ?>"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/book.svg'); ?>" alt="Каталог курсов" width="18" height="18"><span class="label">Course Catalog</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/monitor.svg'); ?>" alt="Управление обучением" width="18" height="18"><span class="label">Learning Management</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/presentation.svg'); ?>" alt="Курсы" width="18" height="18"><span class="label">Courses</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/modul.svg'); ?>" alt="Модули обучения" width="18" height="18"><span class="label">Learning Modules</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/rating.svg'); ?>" alt="Рейтинг" width="18" height="18"><span class="label">Rating</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/users.svg'); ?>" alt="Компетенции" width="18" height="18"><span class="label">Competencies</span></a></li>
        <li><a href="#"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/star.svg'); ?>" alt="Отчёты" width="18" height="18"><span class="label">Reports</span></a></li>
        <li><a href="<?= new moodle_url('/admin/'); ?>"><img class="menu-icon" src="<?= new moodle_url('/theme/stream/pix/icons/mouse.svg'); ?>" alt="Администрирование" width="18" height="18"><span class="label">Administration</span></a></li>
    </ul>
</nav>


    <!-- Main content -->
    <main id="main-content">
        <?= $OUTPUT->main_content() ?>
    </main>
</div>

<?= $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
