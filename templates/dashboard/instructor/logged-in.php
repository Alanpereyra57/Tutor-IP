<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$is_instructor = tutor_utils()->is_instructor();
if ($is_instructor){
	?>

    <div class="tutor-alert-warning tutor-instructor-alert">
        <h2><?php _e("Ya eres un instructor", 'tutor'); ?></h2>

        <p>
			<?php
			echo sprintf(__("Registrado el : %s %s", 'tutor'), date_i18n(get_option('date_format'), $is_instructor), date_i18n(get_option('time_format'),
                $is_instructor) );
			?>
        </p>

        <p>
			<?php
            echo sprintf(__('Status : %s', 'tutor'), tutor_utils()->instructor_status());
            ?>
        </p>

    </div>

<?php }else{
    tutor_load_template('dashboard.instructor.apply_for_instructor');
} ?>
