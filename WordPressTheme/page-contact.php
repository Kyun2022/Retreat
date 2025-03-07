<?php
/*
Template Name: お問い合わせ
*/
?>
<?php get_header(); ?>
<main>
  <?php get_template_part('parts/hero'); ?>

  <?php get_template_part('parts/breadcrumb'); ?>

  <div class="sub-contact under-contact">
    <figure class="sub-contact__decoration"><img
        src="<?php echo esc_url(get_theme_file_uri()); ?>/assets/images/common/birds.webp" alt="鳥の群れが飛んでいる様子">
    </figure>
    <div class="sub-contact__inner inner">
      <div class="sub-contact__content">
        <div class="sub-contact__content-error js-errorMessage">
          <p class="sub-contact__content-errorText">※必須項目が入力されていません。<br
              class="sub-contact__content-errorText--md-show">入力してください。</p>
        </div>
        <div class="sub-contact__form contactForm">
          <?php echo do_shortcode(' [contact-form-7 id="4b840cf" title="お問い合わせフォーム"]'); ?>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>