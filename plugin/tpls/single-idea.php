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
                            dvia: http://data.eurecom.fr/ontology/dvia#
                        typeof="odapps:AppConcept"
                        about = "<?php echo the_permalink(); ?>">
                    <meta property="dct:language" content="<?php echo esc_attr($meta['language'][0]); ?>" />
                    <header class="entry-header">
                        <h1 class="entry-title" property="dct:title">
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                                <?php the_title(); ?>
                            </a>
                        </h1>
                    </header><!-- .entry-header -->

                    <div class="entry-content" style="float:left" about = "<?php echo the_permalink(); ?>" >
                        <p>
                            <strong>Keywords:</strong>
                            <?php 
                                $keywords = explode(",", $meta['summary'][0]);
                                foreach((array)$keywords as $keyword) { ?>
                                    <span property="dct:subject">
                                        <?php echo $keyword; ?>
                                    </span>     
                            <?php } ?>
                        </p>
                    </div><!-- .entry-content -->
                    <br style="clear:both" />

                    <div class="entry-content" style="float:left">
                        <p>
                            <strong>Themes:</strong>
                            <span property="odapps:thene"><?php echo esc_attr($meta['theme'][0]); ?></span>
                        </p>
                    </div>
                    <br style="clear:both" />

                    <div class="entry-content" style="float:left">
                        <p>
                            <strong>Language:</strong>
                            <span property="dct:language"><?php echo esc_attr($meta['language'][0]); ?></span>
                        </p>
                    </div>
                    <br style="clear:both" />

                    <div class="entry-content" style="float:left">
                        <strong>Description: </strong>
                        <span property="dct:description"> <?php the_content(); ?> </span>
                    </div><!-- .entry-content -->
                    <br style="clear:both" />

                    <div class="entry-content" style="clear:both" >
                        <p>
                        <div style="float:left"><strong>Conceivers:</strong>&nbsp;</div>
                        <br style="clear:both" />
                        <div style="float:left"  rel="apps4X:instigator">
                            <?php foreach((array)$meta['conceivers'] as $conceiver) {
                                $conceiver = unserialize($conceiver);
                                list($name, $lastname, $affiliation, $email, $contact) = array(esc_attr($conceiver['conceiver-name']), esc_attr($conceiver['conceiver-surname']), esc_attr($conceiver['conceiver-affiliation']), esc_attr($conceiver['conceiver-email']), esc_attr($conceiver['contact-point']));
                            ?>
                            <div  content = "<?php echo the_permalink() . $lastname . $name; ?>" typeof="foaf:Agent" about = "<?php echo the_permalink() . $lastname . $name; ?>">
                                <span property="contact point"> <?php if ($contact) echo "<strong>Contact Point</strong>" ?> </span>
                                <br />
                                <strong>Name: </strong> <span property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
                                <span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
                                <br />    
                                <strong>Affiliation: </strong> <span property="foaf:affiliation"> <?php echo $affiliation . ' ' ; ?> </span>
                                <br />
                                <strong>E-mail: </strong> <span property="foaf:email"> <?php echo $email; echo $contact ?></span>
                                <br />
                                </div> 
                                 <br style="clear:both" />  
                            <?php } ?>
                        </div>
                        <br style="clear:both" />
                        </p>
                        <p>
                            <strong>Homepage:</strong>
                            <a rel="foaf:homepage" href="<?php echo esc_attr($meta['homepage'][0]); ?>">Visit homepage</a>
                        </p>
                    </div>
                    <hr />

                    <div style="float:left"><strong>Datasets:</strong>&nbsp;</div>
                        <br style="clear:both" />
                        <div class="entry-content" style="float:left"  rel="dvia:consumes">
                            <?php foreach((array)$meta['datasets'] as $dataset) {
                                $dataset = unserialize($dataset);
                                list($dataset_url, $dataset_description) = array(esc_attr($dataset['dataset-url']), esc_attr($dataset['dataset-description']));
                            ?>
                                <div  class="entry-content" content = "<?php echo $dataset_url; ?>" typeof="dvia:Dataset" about = "<?php echo $dataset_url; ?>">
                                    <strong>Dataset URL: </strong> 
                                    <span> <?php echo $dataset_url . ' ' ; ?> </span>
                                    <br/>
                                    <strong>Dataset description: </strong> 
                                    <span property="dvia:description"> <?php echo $dataset_description . "\t" ; ?> </span>
                                </div> 
                                <br style="clear:both" />  
                            <?php } ?>
                        </div>
                        <br style="clear:both" /> 

                    <?php if ( $connected->have_posts() ) : ?>
                        <div class="entry-content" style="clear:both" rel="odapps:implemented">
                            <h3>Applications</h3>
                            <ul>
                                <?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
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