<?php

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir.'/formslib.php');

$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/cadastro/index.php'));
$PAGE->set_title(get_string('pluginname', 'local_cadastro'));
$PAGE->set_heading(get_string('pluginname', 'local_cadastro'));

require_login();
$context = context_system::instance();
require_capability('moodle/site:config', $context);

class formsCsv extends moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('header', 'uploadheader', get_string('upload_title', 'local_cadastro'));

        $mform->addElement('filepicker', 'csvfile', get_string('file_to_upload', 'local_cadastro'), null,
            ['accepted_types' => ['.csv']]
        );
        $mform->addRule('csvfile', null, 'required');

        $this->add_action_buttons(false, get_string('submit_button', 'local_cadastro'));
    }
}

echo $OUTPUT->header();

$form = new formsCsv();

if ($form->is_cancelled()) {
   
    redirect($CFG->wwwroot);

} else if ($fromform = $form->get_data()) {
   
    $content = $form->get_file_content('csvfile');
    $lines = str_getcsv($content, "\n");
    echo $OUTPUT->heading(get_string('file_content_title', 'local_cadastro'));
    
    echo '<table class="table table-striped">';
    echo '<thead><tr>';
    echo '<th>' . get_string('header_username', 'local_cadastro') . '</th>';
    echo '<th>' . get_string('header_curso', 'local_cadastro') . '</th>';
    echo '<th>' . get_string('header_grupo', 'local_cadastro') . '</th>';
    echo '</tr></thead>';
    echo '<tbody>';

    $is_header_row = true;
    foreach ($lines as $line) {

        if (empty(trim($line))) {
            continue; 
        }

        $data = str_getcsv($line, ','); 

        if (count($data) >= 3) {
            $username = htmlspecialchars(trim($data[0]));
            $cursoNomeBreve = htmlspecialchars(trim($data[1]));
            $nomeGrupo = htmlspecialchars(trim($data[2]));

            echo '<tr>';
            echo '<td>' . $username . '</td>';
            echo '<td>' . $cursoNomeBreve . '</td>';
            echo '<td>' . $nomeGrupo . '</td>';
            echo '</tr>';
        }
    }

    echo '</tbody>';
    echo '</table>';
    
    echo $OUTPUT->continue_button(new moodle_url('/local/cadastro/index.php'));

} else {
    $form->display();
}

echo $OUTPUT->footer();