<?php
/**
 * Template for displaying course benefits
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */



do_action('tutor_course/single/before/benefits');


$course_benefits = tutor_course_benefits();
if ( empty($course_benefits)){
	return;
}

if (is_array($course_benefits) && count($course_benefits)){
	?>

	<div class="tutor-single-course-segment tutor-course-benefits-wrap">

		<div class="course-benefits-title">
			<h4 class="tutor-segment-title"><?php _e('Que voy a aprender', 'tutor'); ?></h4>
		</div>

		<div class="">
			<ul class="tutor-course-benefits-items tutor-custom-list-style">
				<?php
				foreach ($course_benefits as $benefit){
					echo "<li>{$benefit}</li>";
				}
				?>
			</ul>
		</div>
	</div>

<?php } ?>

<?php do_action('tutor_course/single/after/benefits'); ?>
