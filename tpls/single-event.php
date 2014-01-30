<?php
/*
 * Template Name: Apps4X Single Event
 * Description: A page template for the Apps4X template
 */

get_header();

?>
    <div id="primary" class="site-content" >
        <div id="content" role="main" >
            <?php if (have_posts()) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    $meta = get_post_meta( get_the_ID() );
                    $connected = new WP_Query( array(
                        'connected_type' => 'events_to_ideas',
                        'connected_items' => $post,
                        'nopaging' => true,
                    ) );
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>
                        prefix="
							apps4X: http://semweb.mmlab.be/ns/apps4X#
							odapps: http://semweb.mmlab.be/ns/odapps#
							foaf: http://xmlns.com/foaf/0.1/
							dct: http://purl.org/dc/terms/
							schema: http://schema.org/
							dvia: http://data.eurecom.fr/ontology/dvia#
							lode: http://linkedevents.org/ontology/ "
							
						about = "<?php echo the_permalink() . esc_attr($meta['edition'][0]) ; ?>" 
						typeof="apps4X:CocreationEvent" >

						<header class="entry-header">
							<h1 class="entry-title" property="dct:title" content = "<?php echo the_title(); ?>" >
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php echo the_title() . " " .esc_attr($meta['edition'][0]); ?>
								</a>
							</h1>
						</header>
						<!-- .entry-header -->

						<div class="entry-content" >
							<div class="entry-block general-info">
								<?php if($meta['logo'][0]): ?>	
									<div class="info-block image" rel="schema:logo">
										<?php echo wp_get_attachment_image($meta['logo'][0]); ?>  
									</div>
								<?php endif ?>

								<?php if($meta['abbreviated_title'][0]): ?>	
									<div class="info-block titleabbr">
										<span class="description">Abbreviated Title: </span> 
										<span class="value"  property="apps4X:shortTitle" >
											<?php echo esc_attr($meta['abbreviated_title'][0]); ?>
										</span>
									</div> 
								<?php endif ?>

								<?php if($meta['location'][0]): ?>
									<div class="info-block location">
										<span class="description">Location: </span> 
										<span class="value" property="lode:atSpace" ><?php echo esc_attr($meta['location'][0]); ?></span>
									</div>
								<?php endif ?>

								<?php if($meta['location'][0] && $meta['edition'][0]): ?> - <?php endif ?>

								<?php if($meta['edition'][0]): ?>
									<div class="info-block edition">
										<span class="description">Edition: </span> 
			                        	<span class="value" property="apps4X:edition">
			                        		<?php echo esc_attr($meta['edition'][0]); ?>
			                        	</span>
			                        </div>
		                    	<?php endif ?>

		                    	<?php if($meta['when_start'][0]): ?>
									<div style="float:left">Starts: </div> 
									<div property="schema:startDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_start'][0]); ?>" >
										<?php echo date("F j, Y - H:i", $meta['when_start'][0]) ?>
									</div>
								<?php endif ?>

		                    	<?php if($meta['when_end'][0]): ?>
									<div class="info-block endtime">
										<span class="description">Ends: </span>
										<span class="value" property="schema:endDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_end'][0]); ?>" >
											<?php echo date("F j, Y - H:i", $meta['when_end'][0]) ?>
										</span>
									</div>
								<?php endif ?>
							</div>

							<div class="entry-block description">
								<div class="value" property="dct:description">
									<?php the_content(); ?>
								</div>
							</div>

							<div class="entry-block general-info">
								<?php if($meta['register_url'][0]): ?>
									<div class="info-block registration">
										<span class="description">Registration: </span>
										<span class="value">
											<a property="apps4X:registration" href="<?php echo esc_attr($meta['register_url'][0]); ?>">Register for this event</a>
										</span>
									</div>
								<?php endif ?>

								<?php if($meta['datasets_url'][0]): ?>
									<div class="info-block datasets">
										<span class="description">Datasets' catalogue: </span>
										<span class="value">
											<a property="schema:url" href="<?php echo esc_attr($meta['datasets_url'][0]); ?>">Catalogue of datasets</a>
										</span>
									</div>
								<?php endif ?>
							
		                        <?php if($meta['theme'][0]): ?>
									<div class="info-block themes">
										<span class="description">Themes: </span> 
	                        			<span class="value" property="odapps:theme">
	                        				<?php echo esc_attr($meta['theme'][0]); ?>
	                        			</span>
	                        		</div>
								<?php endif ?>
							</div>

	                        <?php if($meta['organizer'][0]): ?>
								<div class="entry-block organizers">	
									<h2>Organizers:</h2>
									<div class="value">
										<?php foreach((array)$meta['organizer'] as $organizer) { 
											$organizer = unserialize($organizer);
											list($organizer_name, $organizer_website, $coordinator) = array(esc_attr($organizer['organizer-name']), esc_attr($organizer['organizer-website']), esc_attr($organizer['organizer-coordinator']));
											if ($coordinator) { ?>
												<div class="coordinator" rel = "apps4X:coordinator">
													<span class="coordinator-desc">Coordinator:&#160;</span>
													<?php if($organizer['logo']): ?>	
														<div class="image" rel="schema:logo">
															<?php echo wp_get_attachment_image($organizer['logo']); ?>  
														</div>
													<?php endif ?>
												</div>
											<?php } else {?> 
												<div class="organizer" rel = "apps4X:organizer">
													<span class="organizer" about = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($organizer_name); ?>"  typeof="foaf:Agent">
														<a href="<?php echo $organizer_website; ?>" title="<?php echo $organizer_name; ?>" rel="bookmark" property="foaf:url">
															<span property = "foaf:name"><?php echo $organizer_name; ?> </span>
														</a>
													</span>
												</div>
											<?php } ?>
										<?php } ?>
									</div>
								</div>
							<?php endif ?>

							<?php if ($meta['sponsor']): ?>
								<div class="entry-block sponsors">
									<h2>Sponsors:</h2>
									<div class="value" rel="apps4X:sponsor">
										<?php foreach((array)$meta['sponsor'] as $sponsor) {
											$sponsor = unserialize($sponsor);
											list($sponsor_name, $sponsor_website) = array(esc_attr($sponsor['sponsor-name']), esc_attr($sponsor['sponsor-website']));
										?>
										<?php if($sponsor['sponsor-logo']): ?>
											<div class="image" about = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($sponsor_name); ?>"  typeof="foaf:Agent">
												<a href="<?php echo $sponsor_website; ?>" title="<?php echo $sponsor_name; ?>" rel="bookmark" property="foaf:url">
													<span property="foaf:name"><?php echo $sponsor_name; ?></span>
												</a>
											</div>
										<?php endif ?>
										<?php } ?>
									</div>
								</div>
							<?php endif ?>

							<?php if ($meta['jury']): ?>
								<div class="entry-block jury">
									<h2>Jury:</h2>
									<div class="value">
										<div class="jury" rel="apps4X:jury">
											<div class="value"></div>
											<div class="jurymembers">
												<?php foreach((array)$meta['jury'] as $jury) {
													$jury = unserialize($jury);
														list($lastname, $name) = array(esc_attr($jury['agent-surname']), esc_attr($jury['agent-name']));
												?>
													<div class="jurymember" about = "<?php echo the_permalink() . urlencode($lastname) ; ?>" rel="apps4X:juryMember">
														<span class="jurymember-desc" typeof="foaf:Agent">Jury member: </span>
														<div class="jurymember-name">
															<span property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
										               		<span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
										               	</div>    
													</div>	
												<?php } ?>
											</div>	
										</div>
									</div>
								</div>
							<?php endif ?>

							<?php if ($meta['award']): ?>
								<div class="entry-block awards" >
									<h2>Awards:</h2>
									<div class="value" rel = "apps4X:award">
										<?php foreach((array)$meta['award'] as $award) {
											$award = unserialize($award);
											list($prize, $award_sponsor_name, $award_sponsor_website) = array(esc_attr($award['award-prize']), esc_attr($award['award-sponsor-name']), esc_attr($award['award-sponsor-website']));
										?>
											<div class="award" about = "<?php echo the_permalink() . urlencode($prize) ; ?>">
												<span class="prize" property="apps4X:prize" ><?php echo $prize; ?></span> offered by
												<span class="sponsor" rel="apps4X:sponsor" typeof="foaf:Agent"  >
													<a href="<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($award_sponsor_name) ?>" title="<?php echo $award_sponsor_name; ?>" rel="bookmark" property="foaf:url" >
														<span property="foaf:name"><?php echo $award_sponsor_name; ?></span>
													</a>
												</span>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php endif ?>
										<!-- <hr /> -->
							<?php if ( $connected->have_posts() ) : ?>
								<div class="entry-block apps" >
									<h2>Ideas</h2>
									<ul class="value" rel="apps4X:submission">
										<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
											<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</article>
					<!-- #post -->
            	<?php endwhile; // end of the loop. ?>
            <?php else: ?>
                <h2>Not Found</h2>
            <?php endif; ?>
            <?php comments_template( '', true ); ?>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php
//get_sidebar();
get_footer();
?>