<?php

require_once('../../config.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/cadastro/index.php'));
$PAGE->set_pagelayout('standard');

$PAGE->set_title(get_string('pluginname', 'local_cadastro'));
$PAGE->set_heading(get_string('pluginname', 'local_cadastro'));


echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_cadastro/msg_cadastro', []);

echo $OUTPUT->footer();