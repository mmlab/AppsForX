<?php
/*
 * Template Name: Apps4X Single Event
 * Description: A page template for the Apps4X template
 */

get_header();

?>
    <div id="primary" class="site-content" >
        <div id="content" role="main"  >
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
							apps4X: http://apps4europe.eu/vocab/apps4X#
							odapps: http://apps4europe.eu/vocab/odapps#
							foaf: http://xmlns.com/foaf/0.1/
							dct: http://purl.org/dc/terms/
							schema: http://schema.org/
							dvia: http://data.eurecom.fr/ontology/dvia#
							lode: http://linkedevents.org/ontology/ "
							
						about = "<?php echo the_permalink() . esc_attr($meta['edition'][0]) ; ?>" typeof="apps4X:CocreationEvent" >

						<header class="entry-header">
							<h1 class="entry-title" property="dct:title" content = "<?php echo the_title(); ?>" >
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php echo the_title() . " " .esc_attr($meta['edition'][0]); ?>
								</a>
							</h1>
						</header>
						<!-- .entry-header -->

						<div class="entry-content" >
							<?php if($meta['logo'][0]): ?>	
								<div style="float:right" margin= "0 25px 25px 0" rel="schema:logo">
									<?php echo wp_get_attachment_image($meta['logo'][0]); ?>  
								</div>
							<?php endif ?>

							<?php if($meta['abbreviated_title'][0]): ?>	
								<div style="float:left">Abbreviated Title: </div> 
									<div property="apps4X:shortTitle" >
										<?php echo esc_attr($meta['abbreviated_title'][0]); ?>
									</div> 
							<?php endif ?>

							<div style="float:left">Location: </div> 
							<div property="lode:atSpace" ><?php echo esc_attr($meta['location'][0]); ?></div>
							
							<div style="float:left">Starts: </div> 
							<div property="schema:startDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_start'][0]); ?>" >
								<?php echo date("F j, Y - H:i", $meta['when_start'][0]) ?>
							</div>

							<?php if($meta['when_end'][0]): ?>
								<div style="float:left">Ends: </div>
								<div property="schema:endDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_end'][0]); ?>" >
									<?php echo date("F j, Y - H:i", $meta['when_end'][0]) ?>
								</div>
							<?php endif ?>

							<?php if($meta['edition'][0]): ?>
	                       		<div style="float:left">Edition: </div> 
		                        <div property="apps4X:edition"><?php echo esc_attr($meta['edition'][0]); ?></div>
	                    	<?php endif ?>

							<div style="float:left">Registration: </div>
							<div><a property="apps4X:registration" href="<?php echo esc_attr($meta['register_url'][0]); ?>">Register for this event</a></div>

							<div style="float:left">Datasets' catalogue: </div>
							<div><a property="schema:url" href="<?php echo esc_attr($meta['datasets_url'][0]); ?>">Catalogue of datasets</a></div>
							
	                        <div style="float:left">Themes: </div> 
	                        <div property="odapps:theme"><?php echo esc_attr($meta['theme'][0]); ?></div>
	                        <br style="clear:both" />

			                <h2>Description: </h2>
			                <div style="float:left" property="dct:description"> <?php the_content(); ?> </div>
	                        <br style="clear:both" />

							<h2>Organizers:</h2>
							<?php foreach((array)$meta['organizer'] as $organizer) { 
								$organizer = unserialize($organizer);
								list($organizer_name, $organizer_website, $coordinator) = array(esc_attr($organizer['organizer-name']), esc_attr($organizer['organizer-website']), esc_attr($organizer['organizer-coordinator']));
									
								if ($coordinator) { ?>
									<div style="clear:both" rel = "apps4X:coordinator"><em>Coordinator:</em>
								<?php } else {?> 
									<div style="clear:both" rel = "apps4X:organizer">
								<?php } ?>

								<span about = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($organizer_name); ?>"  typeof="foaf:Agent">
									<a href="<?php echo $organizer_website; ?>" title="<?php echo $organizer_name; ?>" rel="bookmark" property="foaf:url">
										<span property = "foaf:name"><?php echo $organizer_name; ?> </span>
									</a>
								</span>
							</div>
								<?php } ?>
							<br style="clear:both" />	

							<?php if ($meta['sponsor']): ?>
								<h2>Sponsors:</h2>
								<div rel="apps4X:sponsor">
									<?php foreach((array)$meta['sponsor'] as $sponsor) {
										$sponsor = unserialize($sponsor);
										list($sponsor_name, $sponsor_website) = array(esc_attr($sponsor['sponsor-name']), esc_attr($sponsor['sponsor-website']));
									?>
									<p about = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($sponsor_name); ?>"  typeof="foaf:Agent">
										<a href="<?php echo $sponsor_website; ?>" title="<?php echo $sponsor_name; ?>" rel="bookmark" property="foaf:url">
											<span property="foaf:name"><?php echo $sponsor_name; ?></span>
										</a>
									</p>
									<?php } ?>
								</div>
							<?php endif ?>
							<br style="clear:both" />

							<?php if ($meta['jury']): ?>
								<div rel="apps4X:jury">
									<h2>Jury:</h2>
									<?php foreach((array)$meta['jury'] as $jury) 
										$jury = unserialize($jury);
										list($lastname, $name) = array(esc_attr($jury['agent-surname']), esc_attr($jury['agent-name']));
									?>
										<div about = "<?php echo the_permalink() . urlencode($lastname) ; ?>" rel="apps4X:juryMember">
											<div style="float:left" typeof="foaf:Agent">Jury member: </div>
											<div>
												<span property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
		                                		<span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
		                                	</div> 
		                                	<br style="clear:both" />   
										</div>	
								</div>
								<br style="clear:both" />
							<?php endif ?>
								
								<div rel = "apps4X:award">
									<h2>Awards:</h2>
									<?php foreach((array)$meta['award'] as $award) {
										$award = unserialize($award);
										list($prize, $award_sponsor_name, $award_sponsor_website) = array(esc_attr($award['award-prize']), esc_attr($award['award-sponsor-name']), esc_attr($award['award-sponsor-website']));
										?>
										<div about = "<?php echo the_permalink() . urlencode($prize) ; ?>">
											<span property="apps4X:prize" ><?php echo $prize; ?></span> offered by
											<span rel="apps4X:sponsor" typeof="foaf:Agent"  >

												<a href="<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($award_sponsor_name) ?>" title="<?php echo $award_sponsor_name; ?>" rel="bookmark" property="foaf:url" >
													<span property="foaf:name"><?php echo $award_sponsor_name; ?></span>
												</a>
											</span>
											<br />
										</div>
									<?php } ?>
								</div>
								<br style="clear:both" />

							<!-- <hr /> -->
							<?php if ( $connected->have_posts() ) : ?>
								<h2>Ideas</h2>
								<ul rel="apps4X:submission">
										<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
											<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; ?>
								</ul>
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