<?php
$readmore = "Read More";
$share = "Share";
$single_comment = "Comment";
$plural_comment = "Comments"; 
$by_translate = "BY";
$likes = "Likes";
landmark_construction_theme_get_defaults(); 

if ( !empty($landmark_construction_theme_options['translate_share'])) {
  $readmore = $landmark_construction_theme_options['translate_share'];
}
if ( !empty($landmark_construction_theme_options['translate_more'])) {
  $readmore = $landmark_construction_theme_options['translate_more'];
}
if ( !empty($landmark_construction_theme_options['translate_comment'])) {
  $comment = $landmark_construction_theme_options['translate_comment'];
}
if ( !empty($landmark_construction_theme_options['translate_comments'])) {
  $comments = $landmark_construction_theme_options['translate_comments'];
}
if ( !empty($landmark_construction_theme_options['translate_byadmin'])) {
  $byadmin = $landmark_construction_theme_options['translate_byadmin'];
}
if ( !empty($landmark_construction_theme_options['translate_likes'])) {
  $likes = $landmark_construction_theme_options['translate_likes'];
}

$blogid = get_option( 'page_for_posts' );
$sidebar_single_style = get_post_meta( $blogid, "_sidebar_style", true);
$content_class = "col-sm-8 col-md-8 blog-wrapper blog-style1 col-md-offset-2"; 
if ( $sidebar_single_style != "no_sidebar" && $sidebar_single_style != "" ) {
    $sidebar_single_column = get_post_meta( $blogid, "_sidebar_column", true);
    if ( $sidebar_single_column == "sidebar_4") {
      $content_class ="col-sm-8 col-md-8 blog-wrapper blog-style1";
      $sidebar_class ="col-sm-4 col-md-4";
    }
    else {
      $content_class ="col-sm-9 col-md-9 blog-wrapper blog-style1";
      $sidebar_class ="col-sm-3 col-md-3";      
    }
}
?>
<div class="<?php echo esc_attr($content_class); ?>">
    <div class="bt-blog-posts">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <!-- Loop Start -->
            <article <?php post_class('post-item'); ?>>
            <?php 
            $format = get_post_format();
            if( !in_array($format, array('quote', 'link'))) { ?>               
             <div class="bt_thumbnail">
          <?php             
              $format = get_post_format();
              switch ($format) {
                case 'audio':
                  if (has_post_thumbnail()) { the_post_thumbnail('landmark_construction_theme-blog_widget10'); }
                  ?>
                  <div class="bt_audio"><?php landmark_construction_theme_audio();?></div>
                  <?php
                  break;
                case 'video':
                  if (has_post_thumbnail()) { the_post_thumbnail('landmark_construction_theme-blog_widget10'); }
                  ?>
                <div id="prettyVideo-<?php the_ID();?>" class="bt_video hide"><?php landmark_construction_theme_video(); ?></div>
                <div class="bt-video-icon"><a class="prettyPhoto" data-rel="prettyPhoto" href="#prettyVideo-<?php the_ID();?>"><i class="fa fa-play"></i></a></div>                 
                  <?php
                  break;
                case 'gallery':
                  landmark_construction_theme_gallery('landmark_construction_theme-blog_widget10');
                  break;
                default:
                  if (has_post_thumbnail()) { 
                  ?>
                  <?php
                    the_post_thumbnail('landmark_construction_theme-blog_widget10'); 
                  }
                  ?>
                  <?php
                  break;
              }
            ?>
                  <div class="blog-over-thumb">
                    <div class="blog-icon-box"><i class="fa fa-comment"></i> <?php comments_number( '0', '1', '%' ); ?></div>
                    <?php if( function_exists('zilla_likes') ) { ?><div class="blog-icon-box"><?php zilla_likes(); ?></div><?php } ?>
                    <div class="blog-icon-box blog-widget-share"><i class="fa fa-share"></i> <?php echo esc_html($share); ?>
                    <?php landmark_construction_theme_share_widget(); ?>
                    </div>
                  </div>              
            </div>
            <div class="bt_content">
              <h3 class="blog-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
              <div class="blog-subtitle">
                <?php echo esc_html($by_translate); echo ' '; echo the_author_posts_link(); ?>
                <span class="bt_blog_title_sep"> | </span>
                <?php the_time('F j, Y'); ?>
              </div>                                   
              <div class="blog-content">
                <?php
                  the_content('...');
                ?>
              </div>
            </div>
            <div class="clearfix"></div>               
            <?php }
            else {
                switch ($format) {
                    case 'quote':
                      ?>
                      <div class="bt-blog-quote">
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_content(); ?></a>
                      <span class="bt-quote-title">&mdash; <?php the_title(); ?></span>
                      </div>
                      <?php
                      break;
                    case 'link':
                      ?>
                      <div class="bt-blog-link">
                      <a href="<?php echo esc_url( landmark_construction_theme_get_link_url() ); ?>" target="_blank" class="bt-linkout"><?php the_title();?></a>
                      <a href="<?php the_permalink(); ?>"><?php echo get_the_content(); ?></a>
                      </div>
                      <?php
                      break;

                    default:
 
                      break;
                  }                  
            }
            ?>
            </article>
            
            <?php endwhile; else: ?>
            <p><?php echo esc_html_e('Sorry, no posts matched your criteria.', 'landmark-construction-theme');?></p>
            <?php endif; ?>
    </div>
    <div class="pagination-container">
        <div class="index-pagination">
            <?php   
              landmark_construction_theme_pagination(); 
            ?>
        </div>
    </div>
</div>
<?php 
if ( $sidebar_single_style != "no_sidebar" && $sidebar_single_style != "" ) {
      $the_query = new WP_Query( 'page_id='.$sidebar_single_style.'&post_type=sidebars' );
      while ( $the_query->have_posts() ) :
        $the_query->the_post();
      ?><div class="<?php echo esc_attr($sidebar_class); ?>">  
      <?php the_content(); ?>
      </div>
      <?php 
      endwhile;
      wp_reset_postdata();
}
?>