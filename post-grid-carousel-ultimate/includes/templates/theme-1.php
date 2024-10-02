
<div class="pgcu-post pgcu-post--rounded-border <?php echo ( 'carousel' == $layout ) ? 'swiper-slide' : ''; ?>">
    <div class="pgcu-post__content">

        <?php if( ! empty( $pgcu_img ) ) { ?>
            <div class="pgcu-post__img">
                <a href="<?php echo get_the_permalink(); ?>">
                    <img src="<?php echo esc_url( $pgcu_img ); ?>" alt="<?php echo get_the_title(); ?>">
                </a>
            </div>
        <?php } ?>

        <div class="pgcu-post__details">

            <?php if( 'yes' == $display_title ) { ?>
                <h2 class="pgcu-post__title">
                    <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a> 
                </h2>
            <?php } ?>

            <ul class="pgcu-post__meta pgcu-post__meta--dots">

                <?php if( 'yes' == $display_date ) { ?>
                    <li><a><?php echo get_the_date(); ?></a></li>
                <?php } ?>
                
                <?php if( 'yes' == $display_term && ! empty( $get_terms ) ) { ?>
                    <li class="pgcu-post__meta__categories">
                        <a><?php echo esc_html( $get_terms[0]->name ); ?></a>

                        <?php if( 1 < count( $get_terms ) ) { ?>
                        <a><?php echo esc_html( $get_terms[1]->name ); ?></a>
                        <?php } ?>
                        
                        <?php if( 2 < count( $get_terms ) ) { ?>
                            <div class="pgcu-post__meta__categories-more">
                                <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/></svg></span>
                                <div>

                                <?php foreach( array_slice( $get_terms, 2 ) as $term ) { ?>
                                    <a><?php echo esc_html( $term->name ); ?></a>
                                <?php } ?>
                                
                                </div>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>    

            </ul>

            <?php if( 'yes' == $display_content ) { ?>
                <p class="pgcu-post__excerpt">
                <?php echo wp_trim_words( get_the_content(), $content_word_limit );?>
                </p>
            <?php } ?>

            <?php if( 'yes' == $display_read_more ) { ?>

                <a href="<?php echo get_the_permalink(); ?>" class="pgcu-read-more <?php echo ( 'link' == $read_more_type ) ? 'pgcu-post__readmore' : 'pgcu-button pgcu-button--rounded'; ?>">
                    <?php echo $read_more_text; ?>
                    <?php if( 'link' == $read_more_type ) { ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>
                    <?php } ?>
                </a>
            <?php } ?>

        </div><!-- ends: .pgcu-post__details -->
    </div><!-- ends: .pgcu-post__content -->
</div><!-- ends: .pgcu-post -->
