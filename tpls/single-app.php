<?php
/*
 * Template Name: Apps4X Single App
 * Description: A page template for the Apps4X template
 */

get_header();

?>
	<div id="primary" class="site-content">
		<div id="content" role="main">
			<?php if (have_posts()) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<!-- egw pros8esa to akrivws parakatw php komati-->
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
							dvia: http://data.eurecom.fr/ontology/dvia#
							dcat: http://www.w3.org/ns/dcat#"
						about = "<?php echo the_permalink(); ?>" 
						typeof="odapps:Application">

						<header class="entry-header">
							<h1 class="entry-title" property="dct:title">
								<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
									<?php the_title(); ?>
								</a>
							</h1>
						</header><!-- .entry-header -->
						
						<div class="entry-content" >
							<div class="entry-block general-info">

								<?php if ($meta['homepage'][0]): ?>
								<div class="info-block homepage">
									<span class="description">Homepage:&#160;</span>
									<span class="value">
										<a property="foaf:homepage" typeof="schema:WebPage" content = "<?php echo esc_attr($meta['homepage'][0]); ?>" href="<?php echo esc_attr($meta['homepage'][0]); ?>">Homepage</a>
									</span>
								</div>
								<?php endif ?>

								<?php if ($meta['download_url'][0]): ?>
								<div class="info-block downloadurl">
									<span class="description">Download URL:&#160;</span>
									<span class="value">
										<a property="dvia:downloadURL" typeof="schema:WebPage" content = "<?php echo esc_attr($meta['download_url'][0]); ?>" href="<?php echo esc_attr($meta['download_url'][0]); ?>">Download URL</a>
									</span>
								</div>
								<?php endif ?>

								<?php if ($meta['download_url'][0]): ?>
								<div class="info-block demo">
									<span class="description">Demo:&#160;</span>
									<span class="value">
										<a property="apps4X:demo" typeof="schema:WebPage" content = "<?php echo esc_attr($meta['download_url'][0]); ?>" href="<?php echo esc_attr($meta['download_url'][0]); ?>">Download URL</a>
									</span>
								</div>
								<?php endif ?>

								<?php if ($meta['license'][0]): ?>
								<div class="info-block license">
									<span class="description">License:&#160;</span>
									<span class="value">
									<?php 
									switch ($meta['license'][0]) {
										case "Apache v2 License":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href= \"http://www.apache.org/licenses/LICENSE-2.0.html\" >" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "GPL v2":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "MIT License":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "Mozilla Public License Version 2.0":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "LGPL v2.1":
											echo "<a property=\"odapps:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "BSD (3-Clause) License":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://opensource.org/licenses/BSD-3-Clause\" >" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "Artistic License 2.0e":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://opensource.org/licenses/Artistic-2.0\" >" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "GPL v3":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "LGPL v3":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "Affero GPL":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://www.gnu.org/licenses/agpl-3.0.txt\" >" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "Public Domain (Unlicense)":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"" . esc_attr($meta['license'][0]) . "\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "No License":
											echo esc_attr($meta['license'][0]) ;
											break;
										case "Eclipse Public License v1.0":
											echo "<a rel=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://www.eclipse.org/legal/epl-v10.html\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
										case "BSD 2-Clause license":
											echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://opensource.org/licenses/BSD-2-Clause\">" . esc_attr($meta['license'][0]) . "</a>" ;
											break;
									} ?>
									</span>
								</div>
								<?php endif ?> 
							

								<?php if ($meta['language'][0]): ?>
								<div class="info-block language">
									<span class="description">Language:&#160;</span>
									<span class="value" property="dct:language"><?php echo esc_attr($meta['language'][0]); ?></span>
								</div>
								<?php endif ?>

								<?php if ($meta['keyword'][0]): ?>
								<div class="info-block keywords" about = "<?php echo the_permalink(); ?>" >
									<span class="description">Keywords:</span>
									<?php 
										$keywords = explode(",", $meta['keyword'][0]);
										foreach((array)$keywords as $keyword) {
									?>
									<span class="value keyword" property="dct:subject">
										<?php echo $keyword . ", "; ?>
									</span>	 
									<?php } ?>
								</div>
								<?php endif ?>
							
							</div><!-- .general-info -->
							
							<div class="entry-block description">
								<span class="value" property="dct:description"><?php the_content(); ?></span>
							</div>

							<?php if ($meta['creators'][0]): ?>
							<div class="entry-block creators">
								<h2>Creators:</h2>
								<div class="value" rel="dvia:author">
									<?php foreach((array)$meta['creators'] as $creator) {
										$creator = unserialize($creator);
										list($name, $lastname, $affiliation, $email, $contact) = array(esc_attr($creator['creator-name']), esc_attr($creator['creator-surname']), esc_attr($creator['creator-affiliation']), esc_attr($creator['creator-email']), esc_attr($creator['contact-point']));
									?>
									<!-- TODO CSS -->
									<div  content = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($lastname) . urlencode($name); ?>" typeof="foaf:Agent" about = "<?php echo "http://apps4eu.eu/cocreation_events/" . urlencode($lastname) . urlencode($name); ?>">
										<div style="float:left" property="contact point"></div> <div><?php if ($contact) echo "<strong>Contact Point</strong>" ?> </div>
										<div style="float:left">Name: </div> <div property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </div>
										<div property="foaf:name"> <?php echo $name . "\t" ; ?> </div>   
										<div style="float:left">Affiliation: </div> <div property="foaf:affiliation"> <?php echo $affiliation . ' ' ; ?> </div>
										<div style="float:left">E-mail: </div> <div property="foaf:mbox" content="<?php echo $email; ?>"> <?php echo $email; ?></div>
										<br style="clear:both" />
									</div>  
									<?php } ?>
								</div>
							</div>
							<?php endif ?>

							<?php if ($meta['datasets'][0]): ?>
							<div class="entry-block datasets">
								<h2>Datasets:</h2>
								<div class="value" rel="dvia:consumes">
									<?php foreach((array)$meta['datasets'] as $dataset) {
										$dataset = unserialize($dataset);
										list($dataset_url, $dataset_description) = array(esc_attr($dataset['dataset-url']), esc_attr($dataset['dataset-description']));
									?>
									<div class="dataset" content = "<?php echo $dataset_url; ?>" typeof="dvia:Dataset" about = "<?php echo $dataset_url; ?>">
										<span class="url description">Dataset URL:&#160;</span> 
										<span class="url value">> <?php echo $dataset_url . ' ' ; ?> </span>
										<br/>
										<span class="desc description">Dataset description: </span> 
										<span class="desc value" property="dvia:description"> <?php echo $dataset_description . "\t" ; ?> </span>
									</div> 
									<?php } ?>
								</div>
							</div>
							<?php endif ?>

							<div class="entry-block platform">
								<h2>Platform Details:</h2>
								<div class="value">
									<?php if ($meta['platform-title'][0]): ?>
									<div class="platform">
										<span class="description">Platform:&#160;</span>
										<span class="value" property="dvia:platform">
											<?php echo esc_attr($meta['platform-title'][0]); ?>
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['platform-system'][0]): ?>
									<div class="system">
										<span class="description">System:&#160;</span>
										<span class="value" property="dvia:system"> 
											<?php echo esc_attr($meta['platform-system'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['tools'][0]): ?>
									<div class="tools">
										<span class="description">Tools:&#160;</span>
										<span class="value" property="dvia:usesTool"> 
											<?php echo esc_attr($meta['tools'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['requirements'][0]): ?>
									<div class="requirements">
										<span class="description">Requirements:&#160;</span>
										<span class="value" property="schema:requirements"> 
											<?php echo esc_attr($meta['requirements'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['softwareVersion'][0]): ?>
									<div class="version">
										<span class="description">Software version:&#160;</span>
										<span class="value" property="schema:softwareVersion"> 
											<?php echo esc_attr($meta['softwareVersion'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['programmingLanguage'][0]): ?>
									<div class="language">
										<span class="description">Programming Language:&#160;</span>
										<span class="value" property="schema:programmingLanguage"> 
											<?php echo esc_attr($meta['programmingLanguage'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
									
									<?php if ($meta['ori-deri'][0]): ?>
									<div class="work">
										<span class="description">Work:&#160;</span>
										<span class="value" property=""> 
											<?php echo esc_attr($meta['ori-deri'][0]); ?> 
										</span>
									</div>
									<?php endif ?>
								</div>
							</div>

											

							<?php if ( $connected->have_posts() ) : ?>
							<div class="entry-block ideas">
								<div rel="oadapps:implements">
									<h2>Ideas</h2>
									<ul>
									<?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
										<li class="idea"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
									<?php endwhile; ?>
									</ul>
								</div>
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
get_sidebar();
get_footer();
?>