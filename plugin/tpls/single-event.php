<?php
/*
 * Template Name: Apps4X Single Event
 * Description: A page template for the Apps4X template
 */

get_header();

?>
    <div id="primary" class="site-content">
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
							apps4eu: http://apps4eu.eu/voc#
							odapps: http://apps4eu.eu/odapps/voc#
							foaf: http://xmlns.com/foaf/0.1/
							dct: http://purl.org/dc/terms/
							schema: http://schema.org/
							dvia: http://data.eurecom.fr/ontology/dvia#
							typeof="apps4eu:CocreationEvent" 
						about = "<?php echo the_permalink(); ?>" >
						<header class="entry-header">
							<h1 class="entry-title" property="dct:title" content = <?php echo the_title(); ?> >
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php echo the_title() . " " .esc_attr($meta['edition'][0]); ?>
								</a>
							</h1>
						</header><!-- .entry-header -->

						<div style="float:left; margin: 0 25px 25px 0" rel="schema:logo">
							<?php echo wp_get_attachment_image($meta['logo'][0]); ?>  
						</div>
						<div class="entry-content" style="float:left" >
							<p>
								<strong>Abbreviated Title:</strong>
								<span property="apps4eu:shortTitle" ><?php echo esc_attr($meta['abbreviated_title'][0]); ?></span> 
							</p>
							<p>
								<strong>Location:</strong>
								<span property="dct:spatial" typeof="dct:Location"><?php echo esc_attr($meta['location'][0]); ?></span>
							</p>
							<p>
								<strong>Starts:</strong>
								<meta property="schema:startDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_start'][0]); ?>" typeof="schema:Date" />
								<?php echo date("F j, Y - H:i", $meta['when_start'][0]) ?>
								<br />
								<strong>Ends:</strong>
								<meta property="schema:endDate" content="<?php echo date('Y-m-d\TH:i:s', $meta['when_end'][0]); ?>" typceof="schema:Date"/>
								<?php echo date("F j, Y - H:i", $meta['when_end'][0]) ?>
							</p>
	<!--                        <p>-->
	<!--                            <strong>Edition:</strong>-->
	<!--                            <span property="apps4eu:edition">--><?php //echo esc_attr($meta['edition'][0]); ?><!--</span>-->
	<!--                        </p>-->
							<p>
								<strong>Registration:</strong>
								<a property="apps4eu:registration" href="<?php echo esc_attr($meta['register_url'][0]); ?>">Register for this event</a>
							</p>
						</div>
                        <br style="clear:both" />

                        <div class="entry-content" style="float:left">
	                        <p>
	                            <strong>Themes:</strong>
	                            <span property="odapps:thene"><?php echo esc_attr($meta['theme'][0]); ?></span>
	                        </p>
	                    </div>
	                    <br style="clear:both" />

                        <div class="entry-content" style="float:left">
		                    <strong>Description: </strong>
		                    <span property="dct:description"> <?php the_content(); ?> </span>
		                </div>
                        <br style="clear:both" />

                        <div class="entry-content" style="float:left">

								<div style="float:left"><strong>Organizer:</strong></div>
								<div class="entry-content" style="clear:both" rel = "apps4eu:organizer">
									<?php foreach((array)$meta['organizer'] as $organizer) {
										$organizer = unserialize($organizer);
										list($organizer_name, $organizer_website) = array(esc_attr($organizer['organizer-name']), esc_attr($organizer['organizer-website']));
									?>
									<div about = "<?php echo "http://apps4eu.eu/cocreation_events/" . urlencode($organizer_name); ?>">
										<a href="<?php echo $organizer_website; ?>" title="<?php echo $organizer_name; ?>" rel="bookmark" property="foaf:url" typeof="foaf:Agent">
											<span property = "foaf:name"><?php echo $organizer_name; ?> </span>
										</a><br style="clear:both" />
									</div>
									<?php } ?>
								</div>

								<div style="float:left"><strong>Sponsors:</strong>&nbsp;</div>
								<div style="float:left" style="clear:both" rel="apps4eu:sponsored">
									<?php foreach((array)$meta['sponsor'] as $sponsor) {
										$sponsor = unserialize($sponsor);
										list($sponsor_name, $sponsor_website) = array(esc_attr($sponsor['sponsor-name']), esc_attr($sponsor['sponsor-website']));
									?>
									<div about = "<?php echo the_permalink() . urlencode($sponsor_name); ?>">
										<a href="<?php echo $sponsor_website; ?>" title="<?php echo $sponsor_name; ?>" rel="bookmark" property="foaf:url" typeof="foaf:Agent">
											<span property="foaf:name"><?php echo $sponsor_name; ?></span>
										</a>
									</div>
									<?php } ?>
									<br style="clear:both" />
								</div>
							<br style="clear:both" />	
							<div rel="apps4eu:jury" >
								<div style="float:left" ><strong>Jury:</strong>&nbsp;</div><br/>
								<div style="float:left"  rel="apps4eu:juryMember" >
									<?php foreach((array)$meta['jury'] as $jury) {
										$jury = unserialize($jury);
										list($lastname, $name) = array(esc_attr($jury['agent-surname']), esc_attr($jury['agent-name']));
									?>
										<div about = "<?php echo the_permalink() . urlencode($lastname) ; ?>">
											<strong>Jury member: </strong> 
											<br/>
											<span property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
                                			<span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
                                			<br />    
										</div>	
									<?php } ?>
								</div>
								<br style="clear:both" />
							</div>
								<div style="float:left"><strong>Awards:</strong>&nbsp;</div>
								<div style="float:left" rel = "apps4eu:awardOffered">
									<?php foreach((array)$meta['award'] as $award) {
										$award = unserialize($award);
										list($prize, $award_sponsor_name, $award_sponsor_website) = array(esc_attr($award['award-prize']), esc_attr($award['award-sponsor-name']), esc_attr($award['award-sponsor-website']));
										?>
										<div about = "<?php echo the_permalink() . urlencode($prize) ; ?>">
											<span property="apps4eu:prize" ><?php echo $prize; ?></span> offered by
											<span rel="apps4eu:sponsor" typeof="foaf:Agent" >
												<a href="<?php echo $award_sponsor_website; ?>" title="<?php echo $award_sponsor_name; ?>" rel="bookmark" property="foaf:url" about = "<?php echo "http://apps4eu.eu/cocreation_event/" . $award_sponsor_name ?> ">
													<span property="foaf:name"><?php echo $award_sponsor_name; ?></span>
												</a>
											</span>
											<br />
										</div>
									<?php } ?>
								</div>
								<br style="clear:both" />
						</div>
						<!-- <hr /> -->
						<?php if ( $connected->have_posts() ) : ?>
							<div class="entry-content">
								<h3>Ideas</h3>
								<ul>
									<span rel="apps4eu:submission">
										<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
											<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
										<?php endwhile; ?>
									</span>
								</ul>
							</div>
						<?php endif; ?>

					</article><!-- #post -->
            <?php endwhile; // end of the loop. ?>
            <?php else: ?>
                <h2>Not Found</h2>
            <?php endif; ?>
            <?php comments_template( '', true ); ?>
        </div><!-- #content -->
    </div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>