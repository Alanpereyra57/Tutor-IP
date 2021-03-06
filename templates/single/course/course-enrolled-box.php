<?php
/**
 * Template for displaying course content
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.4
 */

if ( ! defined( 'ABSPATH' ) )
    exit;

global $wp_query;

?>

<div class="border-30px tutor-price-preview-box">
  <div class="tutor-price-box-thumbnail">
    <?php
    if(tutor_utils()->has_video_in_single()){
      tutor_course_video();
    } else{
      get_tutor_course_thumbnail();
    }
    ?>
  </div>

  <?php $count_completed_lesson = tutor_course_completing_progress_bar(); ?>

  <?php tutor_course_material_includes_html(); ?>
  <?php tutor_course_topics(); ?>

  <?php tutor_course_target_reviews_html(); ?>
  <?php tutor_course_target_review_form_html(); ?>

  <div class="tutor-lead-info-btn-group">
    <?php do_action('tutor_course/single/actions_btn_group/before'); ?>

    <?php
    if ( $wp_query->query['post_type'] !== 'lesson') {
      $lesson_url = tutor_utils()->get_course_first_lesson();
      $completed_lessons = tutor_utils()->get_completed_lesson_count_by_course();
      if ( $lesson_url ) { ?>
        <a href="<?php echo $lesson_url; ?>" class="tutor-button tutor-success">
          <?php
          if($completed_lessons){
            _e( 'Ir a la última lección', 'tutor' );
          }else{
            _e( 'Empezar curso', 'tutor' );
          }
          ?>
        </a>
      <?php }
    }
    ?>
    <?php tutor_course_mark_complete_html(); ?>

    <?php do_action('tutor_course/single/actions_btn_group/after'); ?>
  </div>

  <div class="tutor-single-course-segment  tutor-course-enrolled-wrap">
    <p>
      <i class="tutor-icon-purchase"></i>
      <?php
      $enrolled = tutor_utils()->is_enrolled();

      echo sprintf(__('Ya has empezado el curso el... %s.', 'tutor'),  "<span>". date_i18n(get_option('date_format'), strtotime($enrolled->post_date)
      )."</span>"  );
      ?>
    </p>
    <?php do_action('tutor_enrolled_box_after') ?>

  </div>

</div> <!-- tutor-price-preview-box -->
