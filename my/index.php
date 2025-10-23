<?php
require_once(__DIR__ . '/../config.php');
require_login();

$PAGE->set_pagelayout('mydashboard');
$PAGE->set_url(new moodle_url('/my/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title("Dashboard");
$PAGE->set_heading("KT Digital Campus");

global $DB, $USER, $CFG;

// Получение курсов пользователя
$courses = enrol_get_users_courses($USER->id, true, 'id');
$coursecount = count($courses);

// Получение модулей
$modulecount = 0;
foreach ($courses as $course) {
    $modinfo = get_fast_modinfo($course->id);
    $modulecount += count($modinfo->get_cms());
}

// Кол-во сертификатов (если плагин установлен)
$certificatecount = 0;
if (file_exists($CFG->dirroot.'/mod/customcert/locallib.php')) {
    require_once($CFG->dirroot.'/mod/customcert/locallib.php');
    $certificatecount = $DB->count_records('customcert_issues', ['userid' => $USER->id]);
}

echo $OUTPUT->header();
?>

    <!-- ======== START: User Info Block ======== -->
    <div class="user-block">
        <div class="user-info">
            <div class="user-avatar">
                <?php echo $OUTPUT->user_picture($USER, ['size' => 80, 'class' => 'user-avatar-img']); ?>
            </div>
            <div class="user-name">
                <h2><?php echo fullname($USER); ?></h2>
            </div>
        </div>
        <div class="user-stats">
            <div class="stat-box">
                <div class="stat-value"><?php echo $coursecount; ?></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo $modulecount; ?></div>
                <div class="stat-label">Modules</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?php echo $certificatecount; ?></div>
                <div class="stat-label">Certificates</div>
            </div>
        </div>
    </div>
    <!-- ======== END: User Info Block ======== -->

    <!-- ======== START: Learning results Block ======== -->

    <div class="learning-results-card">
        <h3>Learning Results</h3>
        <div class="learning-circles">
            <div class="circle-wrap big">
                <div class="circle-progress" style="--value:100; --color:#0091DC">
                    <span>100%</span>
                </div>
                <div class="label">Overall</div>
            </div>

            <div class="circle-wrap">
                <div class="circle-progress" style="--value:40; --color:#F4C542">
                    <span>40%</span>
                </div>
                <div class="label">Tests</div>
            </div>

            <div class="circle-wrap">
                <div class="circle-progress" style="--value:75; --color:#4CAF50">
                    <span>75%</span>
                </div>
                <div class="label">Modules</div>
            </div>

            <div class="circle-wrap">
                <div class="circle-progress" style="--value:60; --color:#F06262">
                    <span>60%</span>
                </div>
                <div class="label">Success</div>
            </div>
        </div>
    </div>

    <!-- ======== END: Learning results Block ======== -->

    <!-- TODO: Следующие блоки добавим позже -->
    <!-- Personal Plan -->
    <!-- Testing and Surveys -->
    <!-- Recently Visited Courses -->

<?php
echo $OUTPUT->footer();
