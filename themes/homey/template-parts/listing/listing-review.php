<?php
global $post, $homey_prefix, $homey_local;

$num_of_review = homey_option('num_of_review');

$args = array(
    'post_type' =>  'homey_review',
    'meta_key' => 'reservation_listing_id',
	//'meta_value' => get_the_ID(),
	'posts_per_page' => $num_of_review,
    'post_status' =>  'publish'
);

$review_query = new WP_Query($args);

$total_review = $review_query->found_posts;

$total_pages = $review_query->max_num_pages;

if($total_review > 1) {
	$review_label = $homey_local['rating_reviews_label'];
} else {
	$review_label = $homey_local['rating_review_label'];
}

?>
<div id="reviews-section" class="reviews-section">
	<ul id="homey_reviews" class="list-unstyled">
		
		<?php 
		if($review_query->have_posts()) {
		while($review_query->have_posts()): $review_query->the_post(); 
				$review_author = homey_get_author('70', '70', 'img-circle');
				$homey_rating = get_post_meta(get_the_ID(), 'homey_rating', true);
			?>
      <div class="col-md-4 col-sm-12">
		<li id="review-<?php the_ID();?>" class="review-block">
			<div class="media">
				<div class="media-left">
					<a class="media-object">
						<?php echo ''.$review_author['photo']; ?>
					</a>
				</div>
				<div class="media-body media-middle">
					<div class="msg-user-info">
						<div class="msg-user-left">
							<div>
								<strong><?php echo esc_attr($review_author['name']); ?></strong> 
								<span class="rating">
									<?php echo homey_get_review_stars($homey_rating, true, true, false); ?>
								</span>
								
							</div>
							<div class="message-date">
								
									<i class="fa fa-calendar"></i> <?php esc_attr( the_time( get_option( 'date_format' ) ));?>
									<i class="fa fa-clock-o"></i> <?php esc_attr( the_time( get_option( 'time_format' ) ));?>
								
							</div>
						</div>
					</div>
					<?php
                      the_content();
                    ?>
				</div>
			</div>
		</li>
        </div>
		<?php endwhile; wp_reset_postdata(); ?>
		<?php } ?>
	</ul>

	<?php 
	if($total_review > $num_of_review && 1==2) { ?>
	<nav class="pagination-wrap" aria-label="Page navigation">
		<ul class="pagination">
			<li>
				<button class="btn btn-primary-outlined" disabled id="review_prev">
					<span aria-hidden="true">&lt;</span>
				</button>
			</li>
			<li>
				<button class="btn btn-primary-outlined" id="review_next">
					<span aria-hidden="true">&gt;</span>
				</button>
			</li>
		</ul>
	</nav>
	<?php } ?>
</div><!-- reviews-section -->