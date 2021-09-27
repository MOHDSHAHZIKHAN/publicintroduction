<?php

/**
 * Posts Layout 1 Widget
 *
 * This will show posts in a row based on the number of columns
 */


if( ! class_exists('Purea_Fashion_Posts_Layout_1_Widget')) :

class Purea_Fashion_Posts_Layout_1_Widget extends WP_Widget {

	var $defaults;
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'purea_fashion_posts_layout_1_widget', // Base ID
			esc_html__( 'Purea Fashion: Posts Layout 1 Widget', 'purea-fashion' ), // Name
			array( 'description' => esc_html__( 'This will show posts in a row based on the number of columns. ', 'purea-fashion'), ) // Args
		);		     
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		extract( wp_parse_args( $instance, $this->defaults ) ); 

		$no_of_posts = ( ! empty( $instance['no_of_posts'] ) ) ? absint( $instance['no_of_posts'] ) : 4;
		$no_of_columns = ! empty( $instance['no_of_columns'] ) ? absint($instance['no_of_columns']) : 4;
		$section_title = ! empty( $instance['section_title'] ) ? esc_html( $instance['section_title'] ) : '';
		$category = ! empty( $instance['category'] ) ? esc_html( $instance['category'] ) : "-1";
		$section_title_top = ( ! empty( $instance['section_title_top'] ) ) ? intval( $instance['section_title_top'] ) : 100;
		$spacing_top = ( ! empty( $instance['spacing_top'] ) ) ? intval( $instance['spacing_top'] ) : 20;
		$spacing_bottom = ( ! empty( $instance['spacing_bottom'] ) ) ? intval( $instance['spacing_bottom'] ) : 20;
		$cb_border_bottom = isset ( $instance['cb_border_bottom'] )  ? (bool)$instance['cb_border_bottom'] : false;
		$cb_excerpt = isset ( $instance['cb_excerpt'] )  ? (bool)$instance['cb_excerpt'] : false;
		$no_excerpt_words = ! empty( $instance['no_excerpt_words'] ) ? absint($instance['no_excerpt_words']) : 30;
		$cb_meta_author = isset ( $instance['cb_meta_author'] )  ? (bool)$instance['cb_meta_author'] : false;
		$cb_meta_date = isset ( $instance['cb_meta_date'] )  ? (bool)$instance['cb_meta_date'] : false;
		$cb_meta_min_read = isset ( $instance['cb_meta_min_read'] )  ? (bool)$instance['cb_meta_min_read'] : false;
		
		?>


		<div class="pf-posts-layout-1-wrapper" style="margin-top:<?php echo $spacing_top; ?>px;margin-bottom:<?php echo $spacing_bottom; ?>px; ">
			<?php 
				if(!empty($section_title) ) { 
					?>
						<div class="section-heading" style="margin-top:<?php echo $section_title_top; ?>px;">
							<h2 class="section-title">
								<?php echo $section_title; ?>
							</h2>
						</div>
					<?php 
				} 
			?>
			<div class="pf-posts-layout-1-lists-wrapper">
				<div class="layout-1-content">
					<?php
						
						if("-1"==$category) :
							$query = new WP_Query( array(
								'posts_per_page' 			=> $no_of_posts,
								'post_type'					=> 'post',
								'post_status'				=> 'publish',
								'ignore_sticky_posts'       => 1,
							) );
						else:
							$query = new WP_Query( array(
								'posts_per_page' 			=> $no_of_posts,
								'post_type'					=> 'post',
								'post_status'				=> 'publish',
								'category__in'				=> $category,
								'ignore_sticky_posts'       => 1,
							) );
						endif;

						if($query-> have_posts()) : $postCount = 0;
							while( $query-> have_posts() ) : $postCount++; $query->the_post(); ?>
								<div class="col-divide-<?php echo $no_of_columns ?>">
									<div id="post-<?php the_ID(); ?>" class="pf-layout-1-category-post category-post">
										<div class="pf-layout-1-category-post-content">
											<div class="pf-section-layout-1-area-box">
												<div class="layout-1-post-image">
													<?php
														if(has_post_thumbnail()) :
															?>
																<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
																	<?php 
																		if(4==$no_of_columns):
																			the_post_thumbnail('purea-fashion-posts-thumb');
																		else:
																			the_post_thumbnail('medium-large');
																		endif;
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
																<?php
																	if( true==$cb_meta_date ) :
																		?>
																			<span class="date"><?php the_time(get_option('date_format')) ?></span>
																		<?php
																	endif;
																?>
																<?php
																	if( true==$cb_meta_min_read ) :
																		?>
																			<span class="minutes-read"><?php echo purea_fashion_estimated_reading_time($query->the_ID()); ?></span>
																		<?php
																	endif;
																?>
					                                        </div>
					                                        <div class="title">
					                                            <h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					                                        </div>
					                                        <?php
					                                        	if( true==$cb_excerpt ) :
						                                        	?> 
								                                        <div class="excerpt">
								                                        	<?php 
								                                        		if(has_excerpt()) :
								                                        			echo wp_trim_words( get_the_excerpt(), $no_excerpt_words, '...' );
								                                        		else:
								                                        			echo wp_trim_words( get_the_content(), $no_excerpt_words, '...' );
								                                        		endif;
								                                        	?>
								                                        </div>
								                                    <?php
								                                endif;
						                                    ?>
						                                    <?php
						                                    	if( true==$cb_meta_author ) :
						                                    		?>
						                                    			<div class="meta-author">
								                                        	<span class="by"><?php esc_html_e('By: ','purea-fashion') ?></span><span class="author"><a class="author-post-url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php the_author() ?></a></span>
								                                        </div>
						                                    		<?php
						                                    	endif;
						                                    ?>
					                                    </div>
				                                    </div>
				                                </div>
											</div>
				                        </div>
									</div>
								</div>
							<?php endwhile;
						endif;
						wp_reset_postdata();
					?>
				</div>
				<div class="view-more">
					<?php
						if("-1"!=$category) :
							$category_link = get_category_link( $category );
							?><a href="<?php echo esc_url( $category_link ); ?>"><?php esc_html_e('+ View More','purea-fashion'); ?></a><?php
						endif;
					?>
				</div>
			</div>
		</div>
		<?php
			if( true==$cb_border_bottom ) :
				?>
					<p style="border-bottom: 1px solid #d0d0d0;"></p>
					<div class="clear"></div>
				<?php
			endif;
    }
	
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
	    $no_of_posts = ( ! empty( $instance['no_of_posts'] ) ) ? absint( $instance['no_of_posts'] ) : 4;
		$no_of_columns = ! empty( $instance['no_of_columns'] ) ? absint($instance['no_of_columns']) : 4;
		$section_title = ! empty( $instance['section_title'] ) ? esc_html( $instance['section_title'] ) : '';
		$category = ! empty( $instance['category'] ) ? esc_html( $instance['category'] ) : 'category';
		$section_title_top = ( ! empty( $instance['section_title_top'] ) ) ? intval( $instance['section_title_top'] ) : 100;
		$spacing_top = ( ! empty( $instance['spacing_top'] ) ) ? intval( $instance['spacing_top'] ) : 20;
		$spacing_bottom = ( ! empty( $instance['spacing_bottom'] ) ) ? intval( $instance['spacing_bottom'] ) : 20;
		$cb_border_bottom = isset ( $instance['cb_border_bottom'] )  ? (bool)$instance['cb_border_bottom'] : false;
		$cb_excerpt = isset ( $instance['cb_excerpt'] )  ? (bool)$instance['cb_excerpt'] : false;
		$no_excerpt_words = ! empty( $instance['no_excerpt_words'] ) ? absint($instance['no_excerpt_words']) : 30;
		$cb_meta_author = isset ( $instance['cb_meta_author'] )  ? (bool)$instance['cb_meta_author'] : false;
		$cb_meta_date = isset ( $instance['cb_meta_date'] )  ? (bool)$instance['cb_meta_date'] : false;
		$cb_meta_min_read = isset ( $instance['cb_meta_min_read'] )  ? (bool)$instance['cb_meta_min_read'] : false;
		
       
	    ?>     	  	    	
		    <p>
		        <label for="<?php echo esc_attr($this->get_field_id('section_title')); ?>"><?php esc_html_e('Title:','purea-fashion'); ?></label>
		        <input class="widefat" id="<?php echo esc_attr($this->get_field_id('section_title')); ?>" name="<?php echo esc_attr($this->get_field_name('section_title')); ?>" type="text" value="<?php echo esc_attr($section_title); ?>" />
		    </p>
		    <p>
				<label for="<?php echo esc_attr($this->get_field_id( 'no_of_posts' )); ?>"><?php esc_html_e( 'Number of posts:', 'purea-fashion' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_of_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('no_of_posts')); ?>" type="text" value="<?php echo absint( $no_of_posts ); ?>">
			</p>
			<h3><?php esc_html_e('Choose Columns:','purea-fashion'); ?></h3>
			<p>
				<label>
                    <input type="radio" value="2" name="<?php echo $this->get_field_name( 'no_of_columns' ); ?>" <?php checked( $no_of_columns, '2' ); ?> id="<?php echo $this->get_field_id( 'no_of_columns' ); ?>" />
                    <?php esc_attr_e( '2 Columns', 'purea-fashion' ); ?>
                </label>
                <label>
                    <input type="radio" value="3" name="<?php echo $this->get_field_name( 'no_of_columns' ); ?>" <?php checked( $no_of_columns, '3' ); ?> id="<?php echo $this->get_field_id( 'no_of_columns' ); ?>" />
                    <?php esc_attr_e( '3 Columns', 'purea-fashion' ); ?>
                </label>
                <label>
                    <input type="radio" value="4" name="<?php echo $this->get_field_name( 'no_of_columns' ); ?>" <?php checked( $no_of_columns, '4' ); ?> id="<?php echo $this->get_field_id( 'no_of_columns' ); ?>" />
                    <?php esc_attr_e( '4 Columns', 'purea-fashion' ); ?>
                </label>
			</p>
			<h3><?php esc_html_e('Choose Post Category:','purea-fashion'); ?></h3>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Category', 'purea-fashion' ); ?>:</label>
				<?php wp_dropdown_categories( array( 'show_option_none' =>esc_html__('-- Select -- ','purea-fashion'),'name' => esc_attr($this->get_field_name( 'category' )), 'selected' => esc_attr($category) ) ); ?>
			</p>

			<h3><?php esc_html_e('Choose Excerpt:','purea-fashion'); ?></h3>
			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_excerpt')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_excerpt')); ?>" value="<?php echo esc_attr('excerpt','purea-fashion'); ?>" <?php checked( true, $cb_excerpt ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_excerpt' )); ?>"><?php esc_html_e('Show Excerpt','purea-fashion') ?></label><br>
			</p>
			 <p>
				<label for="<?php echo esc_attr($this->get_field_id( 'no_excerpt_words' )); ?>"><?php esc_html_e( 'Number of Excerpt Words:', 'purea-fashion' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('no_excerpt_words')); ?>" name="<?php echo esc_attr($this->get_field_name('no_excerpt_words')); ?>" type="text" value="<?php echo absint( $no_excerpt_words ); ?>">
			</p>

			<h3><?php esc_html_e('Choose Meta:','purea-fashion'); ?></h3>
			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_meta_author')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_meta_author')); ?>" value="<?php echo esc_attr('author','purea-fashion'); ?>" <?php checked( true, $cb_meta_author ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_meta_author' )); ?>"><?php esc_html_e('Show Author','purea-fashion') ?></label><br>
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_meta_date')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_meta_date')); ?>" value="<?php echo esc_attr('date','purea-fashion'); ?>" <?php checked( true, $cb_meta_date ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_meta_date' )); ?>"><?php esc_html_e('Show Date','purea-fashion') ?></label><br>
			</p>
			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_meta_min_read')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_meta_min_read')); ?>" value="<?php echo esc_attr('minread','purea-fashion'); ?>" <?php checked( true, $cb_meta_min_read ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_meta_min_read' )); ?>"><?php esc_html_e('Show Reading Time','purea-fashion') ?></label><br>
			</p>

			<h3><?php esc_html_e('Adjust Title Position:','purea-fashion'); ?></h3>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'section_title_top' )); ?>"><?php esc_html_e( 'Margin Top (px):', 'purea-fashion' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('section_title_top')); ?>" name="<?php echo esc_attr($this->get_field_name('section_title_top')); ?>" type="text" value="<?php echo intval( $section_title_top ); ?>">
			</p>

			<h3><?php esc_html_e('Adjust Section Spacing Position:','purea-fashion'); ?></h3>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'spacing_top' )); ?>"><?php esc_html_e( 'Margin Top (px):', 'purea-fashion' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('spacing_top')); ?>" name="<?php echo esc_attr($this->get_field_name('spacing_top')); ?>" type="text" value="<?php echo intval( $spacing_top ); ?>">
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'spacing_bottom' )); ?>"><?php esc_html_e( 'Margin Bottom (px):', 'purea-fashion' ); ?></label> 
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('spacing_bottom')); ?>" name="<?php echo esc_attr($this->get_field_name('spacing_bottom')); ?>" type="text" value="<?php echo intval( $spacing_bottom ); ?>">
			</p>

			<p>
				<input type="checkbox" id="<?php echo esc_attr($this->get_field_id('cb_border_bottom')); ?>" name="<?php echo esc_attr($this->get_field_name('cb_border_bottom')); ?>" value="<?php echo esc_attr('borderbottom','purea-fashion'); ?>" <?php checked( true, $cb_border_bottom ); ?>>
				<label for="<?php echo esc_attr($this->get_field_id( 'cb_border_bottom' )); ?>"><?php esc_html_e('Show Border Bottom Line','purea-fashion') ?></label><br>
			</p>	

    	<?php
         
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;	
		$instance['no_of_posts'] = absint( $new_instance['no_of_posts'] );
		$instance['no_of_columns'] = absint( $new_instance['no_of_columns'] );
		$instance['section_title'] = sanitize_text_field( $new_instance['section_title'] );
		$instance['category' ] = sanitize_text_field($new_instance[ 'category' ]);
		$instance['section_title_top'] = intval( $new_instance['section_title_top'] );
		$instance['spacing_top'] = intval( $new_instance['spacing_top'] );
		$instance['spacing_bottom'] = intval( $new_instance['spacing_bottom'] );
		$instance['cb_border_bottom'] = isset ( $new_instance['cb_border_bottom'] ) ? (bool)$new_instance['cb_border_bottom'] : false;
		$instance['cb_excerpt'] = isset ( $new_instance['cb_excerpt'] ) ? (bool)$new_instance['cb_excerpt'] : false;
		$instance['no_excerpt_words'] = absint( $new_instance['no_excerpt_words'] );
		$instance['cb_meta_author'] = isset ( $new_instance['cb_meta_author'] ) ? (bool)$new_instance['cb_meta_author'] : false;
		$instance['cb_meta_date'] = isset ( $new_instance['cb_meta_date'] ) ? (bool)$new_instance['cb_meta_date'] : false;
		$instance['cb_meta_min_read'] = isset ( $new_instance['cb_meta_min_read'] ) ? (bool)$new_instance['cb_meta_min_read'] : false;


    	return $instance;
	}

}
endif;

if( ! function_exists('purea_fashion_register_posts_layout_1_widget')) :
// register widget
function purea_fashion_register_posts_layout_1_widget() {
    register_widget( 'Purea_Fashion_Posts_Layout_1_Widget' );
}
endif;

add_action( 'widgets_init', 'purea_fashion_register_posts_layout_1_widget' );
