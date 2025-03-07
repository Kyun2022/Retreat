<?php get_header(); ?>
<main>

  <?php get_template_part('parts/hero'); ?>

  <?php get_template_part('parts/breadcrumb'); ?>

  <div class="sub-campaign under-campaign">
    <figure class="sub-campaign__decoration">
      <img src="<?php echo esc_url(get_theme_file_uri()); ?>/assets/images/common/bird.webp" alt="鳥の群れが飛んでいる様子">
    </figure>
    <div class="sub-campaign__inner inner">
      <div class="sub-campaign__tab tab">
        <div class="sub-campaign__tab tab">
          <?php
          $current_term_id = get_queried_object()->term_id;
          $terms = get_terms(array(
            // 表示するタクソノミースラッグを記述
            'taxonomy' => 'campaign_category',
            // 表示するタームの数を指定
            'number'  => 3
          ));

          // カスタム投稿一覧ページへのURL
          $campaign_category_class = (is_post_type_archive()) ? 'current-cat' : '';
          $campaign_category_link = sprintf(
            //カスタム投稿一覧ページへのaタグに付与するクラスを指定できる
            '<p class="tab__text js-campaignContent-target %s"><a href="%s" alt="%s">ALL</a></p>',
            $campaign_category_class,
            // カスタム投稿一覧ページのスラッグを指定
            esc_url(home_url('campaign')),
            esc_attr(__('View all posts', 'textdomain'))
          );
          echo sprintf(esc_html__('%s', 'textdomain'), $campaign_category_link);

          // タームのリンク
          if ($terms) {
            foreach ($terms as $term) {
              // カレントクラスに付与するクラスを指定できる
              $term_class = ($current_term_id === $term->term_id) ? 'current-cat' : '';
              $term_link = sprintf(
                // 各タームに付与するクラスを指定できる
                '<p class="tab__text js-campaignContent-target %s"><a href="%s" alt="%s">%s</a></p>',
                $term_class,
                esc_url(get_term_link($term->term_id)),
                esc_attr(sprintf(__('View all posts in %s', 'textdomain'), $term->name)),
                esc_html($term->name)
              );
              echo sprintf(esc_html__('%s', 'textdomain'), $term_link);
            }
          }
          ?>
        </div>
      </div>

      <div class="sub-campaign__menu">
        <div class="sub-campaign__items slider">
          <?php if (have_posts()) :
            $post_count = 0; // カウンターを初期化
            while (have_posts()) : the_post();
              $post_count++; // ポストごとにカウントを加算
          ?>
              <article class="slider__item" id="campaign<?php echo $post_count; ?>">
                <figure class="slider__image">
                  <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('full'); ?>
                  <?php else : ?>
                    <img src="<?php echo esc_url(get_theme_file_uri()); ?>/assets/images/common/noimage.webp"
                      alt="noimage画像" />
                  <?php endif; ?>
                </figure>
                <div class="slider__body slider__body--layout">
                  <!-- 指定したカテゴリー(ターム)のみ表示 -->
                  <?php
                  $taxonomy_terms = get_the_terms($post->ID, 'campaign_category');
                  foreach ($taxonomy_terms as $taxonomy_term) {
                    if (!in_array($taxonomy_term->slug, array('license', 'experience', 'fan')))
                      continue;
                    echo '<p class="slider__label ' . $taxonomy_term->slug . '">' . $taxonomy_term->name . '</p>';
                  }
                  ?>
                  <h3 class="slider__title slider__title--layout">
                    <!-- タイトル20文字制限 -->
                    <?php echo wp_trim_words(get_the_title(), 20, '...'); ?>
                  </h3>
                  <div class="slider__meta slider__meta--layout">
                    <?php $price_groups = get_field('campaign_price_group'); ?>
                    <h4 class="slider__sub-title">
                      <?php esc_html($price_groups['campaign-money-text']); ?>
                    </h4>
                    <div class="slider__price-unit slider__price-unit--layout">
                      <?php if ($price_groups['campaign-old-price']) : ?>
                        <p class="slider__old-price slider__old-price--layout">
                          &#165;<?php echo number_format($price_groups['campaign-old-price']); ?>
                        </p>
                      <?php endif; ?>
                      <p class="slider__new-price">
                        &#165;<?php echo number_format($price_groups['campaign-new-price']); ?>
                      </p>
                    </div>
                    <div class="slider__detail slider__detail--md-none">
                      <?php $main_groups = get_field('campaign_main_group'); ?>
                      <p class="slider__text text">
                        <?php echo nl2br(esc_html($main_groups['campaign-main-text'])); ?>
                      </p>
                      <div class="slider__box">
                        <p class="slider__date"><?php echo esc_html($main_groups['campaign-period']); ?></p>
                        <p class="slider__sub-text"><?php echo esc_html($main_groups['campaign-info']); ?></p>
                        <div class="slider__button-block">
                          <button class="button"
                            onclick="location.href='<?php echo esc_url(home_url('contact')); ?>'">contact</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </article>
            <?php endwhile; ?>
        </div>
      <?php else : ?>
        <!-- ここに投稿がない場合の記述 -->
        <p>記事が投稿されていません</p>
      <?php endif; ?>
      </div>

      <div class="sub-campaign__pageNation pageNation">
        <ul class="pageNation__items wp-pagenavi">
          <?php wp_pagenavi(); ?>
        </ul>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>