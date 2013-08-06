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
                        'connected_type' => 'apps_to_ideas',
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
                            dcat: http://www.w3.org/ns/dcat#
                    typeof="odapps:Application"
                    about = "<?php echo the_permalink(); ?>">
                        <header class="entry-header">
                            
                            <h1 class="entry-title" property="dct:title">
                                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpapps' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                                    <?php the_title(); ?>
                                </a>
                            </h1>
                        </header><!-- .entry-header -->
                    <div class="entry-content" style="float:left" >
                        <div class="entry-content" style="float:left">
                            <p>
                                <strong>Homepage:</strong>
                                <a property="foaf:homepage" typeof="schema:WebPage" content = "<?php echo esc_attr($meta['homepage'][0]); ?>" href="<?php echo esc_attr($meta['homepage'][0]); ?>">Homepage</a>
                            </p>
                            <p>
                                <strong>Download URL:</strong>
                                <a property="dvia:downloadURL" typeof="schema:WebPage" content = "<?php echo esc_attr($meta['download_url'][0]); ?>" href="<?php echo esc_attr($meta['download_url'][0]); ?>">Download URL</a>
                            </p>
                            <p>
                                <strong>License:</strong>
                                    <?php 
                                        switch ($meta['license'][0]) {
                                            case "Apache v2 License":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href= \"http://www.apache.org/licenses/LICENSE-2.0.html\" >" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "GPL v2":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "MIT License":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "Mozilla Public License Version 2.0":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "LGPL v2.1":
                                                echo "<a property=\"odapps:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "BSD (3-Clause) License":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://opensource.org/licenses/BSD-3-Clause\" >" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "Artistic License 2.0e":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://opensource.org/licenses/Artistic-2.0\" >" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "GPL v3":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "LGPL v3":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "Affero GPL":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=\"http://www.gnu.org/licenses/agpl-3.0.txt\" >" . esc_attr($meta['license'][0]) . "</a>" ;
                                                break;
                                            case "Public Domain (Unlicense)":
                                                echo "<a property=\"dvia:hasLicense\" typeof=\"dct:License\" href=" . esc_attr($meta['license'][0]) . ">" . esc_attr($meta['license'][0]) . "</a>" ;
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
                                        }
                                    ?> 
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

                        <div class="entry-content">
                            <strong>Description:</strong>
                            <span property="dct:description"><?php the_content(); ?></span>
                        </div>

                        <div style="float:left"><strong>Creators:</strong>&nbsp;</div>
                            <br style="clear:both" />
                            <div class="entry-content" style="float:left"  rel="dvia:author">
                                <?php foreach((array)$meta['creators'] as $creator) {
                                    $creator = unserialize($creator);
                                    list($name, $lastname, $affiliation, $email, $contact) = array(esc_attr($creator['creator-name']), esc_attr($creator['creator-surname']), esc_attr($creator['creator-affiliation']), esc_attr($creator['creator-email']), esc_attr($creator['contact-point']));
                                ?>
                                <div  content = "<?php echo "http://apps4europe.eu/cocreation_events/" . urlencode($lastname) . urlencode($name); ?>" typeof="foaf:Agent" about = "<?php echo "http://apps4eu.eu/cocreation_events/" . urlencode($lastname) . urlencode($name); ?>">
                                    <span property="contact point"> <?php if ($contact) echo "<strong>Contact Point</strong>" ?> </span>
                                    <br />
                                    <strong>Name: </strong> <span property="foaf:lastname"> <?php echo $lastname . ' ' ; ?> </span>
                                    <span property="foaf:name"> <?php echo $name . "\t" ; ?> </span>
                                    <br />    
                                    <strong>Affiliation: </strong> <span property="foaf:affiliation"> <?php echo $affiliation . ' ' ; ?> </span>
                                    <br />
                                    <strong>E-mail: </strong> <span property="foaf:mbox" content="<?php echo $email; ?>"> <?php echo $email; ?></span>
                                    <br />
                                    </div> 
                                     <br style="clear:both" />  
                                <?php } ?>
                            </div>
                        </div>  
                        <br style="clear:both" />

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

                        <div class="entry-content" style="float:left"><strong>Platform Details:</strong>&nbsp;</div>
                        <br style="clear:both" />
                        <div  class="entry-content" style="float:left" >
                                <strong>Platform: </strong>
                                <span property="dvia:platform">
                                    <?php echo esc_attr($meta['platform-title'][0]); ?>
                                </span> 
                                <br style="clear:both" />   
                                <strong>System: </strong>
                                <span property="dvia:system"> <?php echo esc_attr($meta['platform-system'][0]); ?> </span>
                                <br style="clear:both" />  
                                <strong>Tools: </strong>
                                <span property="dvia:usesTool"> <?php echo esc_attr($meta['tools'][0]); ?> </span>
                                <br style="clear:both" />  
                                <strong>Requirements: </strong>
                                <span property="schema:requirements"> <?php echo esc_attr($meta['requirements'][0]); ?> </span>
                                <br style="clear:both" />
                                <strong>Software version: </strong>
                                <span property="schema:softwareVersion"> <?php echo esc_attr($meta['softwareVersion'][0]); ?> </span>
                                <br style="clear:both" />
                                <strong>Programming Language: </strong>
                                <span property="schema:programmingLanguage"> <?php echo esc_attr($meta['programmingLanguage'][0]); ?> </span>
                                <br style="clear:both" />
                                <strong>Work: </strong>
                                <span property=""> <?php echo esc_attr($meta['ori-deri'][0]); ?> </span>
                                <br style="clear:both" />
                        </div> 
                        <br style="clear:both" />  

                        <div class="entry-content" style="float:left" about = "<?php echo the_permalink(); ?>" >
                            <p>
                                <strong>Keywords:</strong>
                                <?php 
                                    $keywords = explode(",", $meta['keyword'][0]);
                                    foreach((array)$keywords as $keyword) { ?>
                                        <span property="dct:subject">
                                            <?php echo $keyword; ?>
                                        </span>     
                                <?php } ?>
                            </p>
                        </div><!-- .entry-content -->
                        <br style="clear:both" />
                    </div>

                    <?php if ( $connected->have_posts() ) : ?>
                        <div class="entry-content" style="clear:both" rel="oadapps:implements">
                            <h3>Ideas</h3>
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