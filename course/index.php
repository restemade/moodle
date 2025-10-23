<?php
require_once(__DIR__ . '/../config.php');
require_login();

global $DB, $CFG;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/course/index.php'));
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_title('Платформа для обучения');
$PAGE->set_heading('Платформа для обучения');

// Подключаем CSS
$PAGE->requires->css(new moodle_url('/theme/stream/style/course-catalog.css'));

// --- Заглушечные фильтры ---
$roles = [
    'all' => 'Все должности',
    'manager' => 'Менеджер',
    'employee' => 'Сотрудник'
];

$competencygroups = [
    'all' => 'Все группы компетенций',
    'communication' => 'Коммуникация',
    'techskills' => 'Технические навыки'
];

$competencies = [
    'all' => 'Все доступные компетенции',
    'teamwork' => 'Командная работа',
    'leadership' => 'Лидерство'
];

$functionalcards = [
    'all' => 'Все функциональные карты БП',
    'hr' => 'HR',
    'sales' => 'Продажи'
];

$trainingformats = [
    'all' => 'Все формы обучения',
    'online' => 'Онлайн',
    'offline' => 'Оффлайн'
];

// --- Получаем параметры ---
$search = optional_param('search', '', PARAM_TEXT);
$role = optional_param('role', 'all', PARAM_ALPHA);
$group = optional_param('group', 'all', PARAM_ALPHA);
$competency = optional_param('competency', 'all', PARAM_ALPHA);
$card = optional_param('card', 'all', PARAM_ALPHA);
$format = optional_param('format', 'all', PARAM_ALPHA);

echo $OUTPUT->header();
?>

<div class="course-catalog-page">

    <!-- 🔥 ЗАГОЛОВОК ВЛЕВО -->
    <div class="page-header">
        <h1>Платформа для обучения</h1>
        <p class="page-subtitle">Личный кабинет | Каталог курсов</p>
    </div>

    <!-- 🔥 ФИЛЬТРЫ: БЕЗ ЛЕЙБЛОВ -->
    <div class="filters-container">
        <form method="get">
            <div class="filters-grid">
                <!-- ПЕРВЫЙ РЯД: 4 блока -->
                <div class="filter-block">
                    <select name="role">
                        <?php foreach ($roles as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $role == $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-block">
                    <select name="group">
                        <?php foreach ($competencygroups as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $group == $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-block">
                    <select name="competency">
                        <?php foreach ($competencies as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $competency == $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-block">
                    <select name="card">
                        <?php foreach ($functionalcards as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $card == $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- ВТОРОЙ РЯД: 2 блока -->
                <div class="filter-block second-row">
                    <select name="format">
                        <?php foreach ($trainingformats as $v => $l): ?>
                            <option value="<?= $v ?>" <?= $format == $v ? 'selected' : '' ?>><?= $l ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- 🔥 ПОИСК С ЛУПОЙ СЛЕВА -->
                <div class="search-block second-row">
                    <div class="search-input-wrapper">
                        <img src="<?= $CFG->wwwroot ?>/theme/stream/pix/icons/search.svg" alt="Поиск" class="search-icon">
                        <input type="text" name="search" placeholder="Поиск по названию..." value="<?= s($search) ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Курсы -->
    <div class="courses-section">
        <h2>Учебные курсы</h2>

        <div class="courses-grid">
            <?php
            // Получаем реальные курсы
            $courses = $DB->get_records_sql("
                SELECT id, fullname, summary, visible
                FROM {course}
                WHERE id > 1 AND visible = 1
                ORDER BY sortorder ASC
            ");

            $fs = get_file_storage();
            $found = false;

            foreach ($courses as $course) {
                $context = context_course::instance($course->id);
                $courseimage = '';

                // Получаем изображение курса
                $files = $fs->get_area_files($context->id, 'course', 'overviewfiles', 0, 'filename', false);
                if (!empty($files)) {
                    $file = reset($files);
                    $courseimage = file_encode_url(
                        "$CFG->wwwroot/pluginfile.php",
                        '/' . $file->get_contextid() . '/' . $file->get_component() . '/' .
                        $file->get_filearea() . $file->get_filepath() . $file->get_filename(),
                        false
                    );
                } else {
                    $courseimage = $CFG->wwwroot . '/theme/stream/pix/default_course.jpg';
                }

                // Имитация метаданных
                $courseformat = rand(0, 1) ? 'Онлайн' : 'Оффлайн';
                $courseduration = rand(10, 50);
                $modules = rand(3, 8);

                // Фильтрация по названию (поиск)
                if ($search && stripos($course->fullname, $search) === false) continue;

                // Фильтрация по формату
                if ($format !== 'all' && $courseformat !== ucfirst($format)) continue;

                $found = true;
                $url = new moodle_url('/course/view.php', ['id' => $course->id]);
                ?>

                <div class="course-card" style="background-image: url('<?= $courseimage ?>');">
                    <div class="course-overlay">
                        <h3 class="course-title"><?= format_string($course->fullname) ?></h3>
                        <p><strong>Формат обучения:</strong> <?= $courseformat ?></p>
                        <p><strong>Продолжительность (часы):</strong> <?= $courseduration ?></p>
                        <p><strong>Количество модулей:</strong> <?= $modules ?></p>
                        <div class="course-buttons">
                            <a href="<?= $url ?>" class="btn btn-light">Детали курса</a>
                            <a href="<?= $url ?>" class="btn btn-blue">Перейти</a>
                        </div>
                    </div>
                </div>

            <?php }

            if (!$found) {
                echo "<p class='no-courses'>Курсы не найдены по заданным критериям.</p>";
            }
            ?>
        </div>
    </div>

</div>

<?php echo $OUTPUT->footer(); ?>