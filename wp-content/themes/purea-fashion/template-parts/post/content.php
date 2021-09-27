<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package purea-fashion
 */
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    	<div class="pf-layout-1-category-post category-post">
			<div class="pf-layout-1-category-post-content">
				<div class="pf-section-layout-1-area-box">
					<div class="layout-1-post-image">
						<?php
							if(has_post_thumbnail()) :
								?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
										<?php 
											the_post_thumbnail('medium');
										?>
									</a>
								<?php
							else:
								$post_img_url = get_template_directory_uri().'/img/no-image.jpg';
								?>
									<img src="<?php echo $post_img_url; ?>" alt="<?php esc_attr_e('post-image','purea-fashion'); ?>" />
								<?php
							endif;
						?>
					</div>
					<div class="pf-layout-1-area-content">
						<div class="content-wrapper">
							<div class="content">
								<div class="meta">
									<span class="date"><?php the_time(get_option('date_format')) ?></span>
									<span class="minutes-read"><?php echo purea_fashion_estimated_reading_time(get_the_ID()); ?></span>
									<span class="author"><a class="author-post-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php the_author() ?></a></span>
                                </div>
                                <div class="title">
                                    <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                </div>
                                <div class="excerpt">
                                	<?php 
                                		if(has_excerpt()) :
                                			the_excerpt();
                                		endif;
                                	?>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
		</div>
    </article>