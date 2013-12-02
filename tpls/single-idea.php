<?php
/*
 * Template Name: Apps4X Single Event
 * Description: A page template for the Apps4X template
 */

get_header();

?>
	<div id="primary" class="site-content">
		<div id="content" role="main" xmlns:dc="http://purl.org/dc/terms/">
			<?php if (have_posts()) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						$meta = get_post_meta( get_the_ID() );
						$connected = new WP_Query( array(
							'connected_type' => 'ideas_to_apps',
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
							dvia: http://data.eurecom.fr/ontology/dvia#"
						about = "<?php echo the_permalink(); ?>" typeof="odapps:AppConcept">
						
						<meta property="dct:language" content="<?php echo esc_attr($meta['language'][0]); ?>" />
						
						<header class="entry-header">
							<h1 class="entry-title" property="dct:title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h1>
						</header><!-- .entry-header -->

						<div class="entry-content" about = "<?php echo the_permalink(); ?>" >
							<div class="entry-block general-info">
								<?php if ($meta['summary'][0]): ?>
								<div class="info-block keywords">
									<span class="description">Keywords:&#160;</span>
									<?php 
										$keywords = explode(",", $meta['summary'][0]);
										foreach((array)$keywords as $keyword) { ?>
									<span class="value keyword" property="dct:subject">
										<?php echo $keyword; ?>
									</span>	 
									<?php } ?>
								</div>
								<?php endif ?>

								<?php if ($meta['theme'][0]): ?>
								<div class="info-block themes">
									<span class="description">Themes:&#160;</span>
									<span class="value" property="odapps:theme"><?php echo esc_attr($meta['theme'][0]); ?></span>
								</div>
								<?php endif ?>


								<?php if ($meta['language'][0]): ?>
								<div class="info-block language">
									<span class="description">Language:&#160;</span>
									<span class="value" property="dct:language"><?php echo esc_attr($meta['language'][0]); ?></span>
								</div>
								<?php endif ?>


								<div class="info-block description">
									<span class="value" property="dct:description"> <?php the_content(); ?> </span>
								<div>


								<?php if ($meta['homepage'][0]): ?>
								<div class="info-block homepage">
									<span class="description">Homepage:&#160;</div>
									<span class="value">
										<a rel="foaf:homepage" href="<?php echo esc_attr($meta['homepage'][0]); ?>">Visit homepage</a>
									</span>
								</div>
								<?php endif ?>

							</div>

							<?php if ($meta['conceivers'][0]): ?>
							<div class="entry-block instigators">
								<h2>Instigators:</h2>
								<div class="value" rel="apps4X:instigator">
									<?php foreach((array)$meta['conceivers'] as $conceiver) {
										$conceiver = unserialize($conceiver);
										list($name, $lastname, $affiliation, $email, $contact) = array(esc_attr($conceiver['conceiver-name']), esc_attr($conceiver['conceiver-surname']), esc_attr($conceiver['conceiver-affiliation']), esc_attr($conceiver['conceiver-email']), esc_attr($conceiver['contact-point']));
									?>
									<div class="instigator" content = "<?php echo the_permalink() . $lastname . $name; ?>" typeof="foaf:Agent" about = "<?php echo the_permalink() . $lastname . $name; ?>">
										<!-- TODO CSS -->
										<span property="contact point"> <?php if ($contact) echo "<strong>Contact Point</strong>" ?> </span>
										<br />
										<div style="float:left">Name: </div> 
										<div> 
											<span> property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
											<span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
										</div>	
										<div style="float:left">Affiliation: </div> 
										<div property="foaf:affiliation"> <?php echo $affiliation . ' ' ; ?> </div>

										<div style="float:left">E-mail: </div> 
										<div property="foaf:email"> <?php echo $email; echo $contact ?></div>
									</div> 
									<?php } ?>
								</div>
							</div>
							<?php endif ?>

							<?php if ($meta['datasets'][0]): ?>
							<div class="entry-block datasets">
								<h2>Datasets:</h2>
								<div class="value">
								<?php foreach((array)$meta['datasets'] as $dataset) {
									 $dataset = unserialize($dataset);
									list($dataset_url, $dataset_description) = array(esc_attr($dataset['dataset-url']), esc_attr($dataset['dataset-description']));
									?>
									<div class="dataset">
										<span class="url description" content = "<?php echo $dataset_url; ?>" typeof="dvia:Dataset" about = "<?php echo $dataset_url; ?>">
											Dataset URL:&#160;
										</span> 
										<span class="url value"> <?php echo $dataset_url . ' ' ; ?> </span>
										<span class="desc description" >Dataset description:&#160;</span> 
										<span class="desc value" property="dvia:description"> <?php echo $dataset_description . "\t" ; ?> </span>
									</div>
								<?php } ?>
								</div>
							</div>
							<?php endif ?>

							<?php if ( $connected->have_posts() ) : ?>
							<div class="entry-block apps">
								<h2>Applications</h2>
								<ul rel="odapps:implemented">
									<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
										<li class="app"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
								</ul>
							</div>
							<?php endif; ?>
						</div><!-- .entry-content -->
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
get_sidebar();
get_footer();
?>