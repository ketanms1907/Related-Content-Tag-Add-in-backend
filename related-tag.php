function related_content_tag($atts){ 
  
		ob_start();
		global $item;
		$tagitem = $atts['tagname'];

		$sap_terms = get_terms( 'my_tags', array('name__like' => $tagitem) ); 
		foreach($sap_terms as $sap_term){
			$all_terms[] = $sap_term->slug;
		}
		$sap_args = array(
		'post_type'=> array('post','prelease','pcoverage'),
		'posts_per_page'=> 4,
		'post_status'    => 'publish',
		'order'=>'DESC',
		'orderby'=> 'date',
		'tax_query' => array(
				array(
					'taxonomy' => 'my_tags',
					'field' => 'slug',
					'terms' => $all_terms
				)
			),
		
		);
		$rel_saparg = new WP_Query($sap_args);
 ?>
		<div class="sap-related-content">
	 <div class="relhead-title">Related Content</div>
		<?php  if( $rel_saparg->have_posts() ) :
			while ($rel_saparg->have_posts()) : $rel_saparg->the_post(); ?>
	   <div class="related-box"> 
		 
		  <div class="related-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
		  <div class="related-text"><?php echo get_the_custom_excerpt(100) ?></div>
		  <div class="related-readmore"><a href="<?php the_permalink();?>">Read More</a></div>
	   </div>
	 <?php endwhile;
		endif; wp_reset_postdata();?>
	</div>  
		<?php 
 
 return ob_get_clean();  
}
add_shortcode( 'related_content_tag_name', 'related_content_tag' );
