<?php
$post_type            = ! empty( $post_type ) ? $post_type : 'post';
$term_from            = ! empty( $term_from ) ? $term_from : 'category';
$display_term         = ! empty( $display_term ) ? $display_term : 'yes';
$display_header_title        = ! empty( $display_header_title ) ? $display_header_title : 'no';
$display_title        = ! empty( $display_title ) ? $display_title : 'yes';
$display_content      = ! empty( $display_content ) ? $display_content : 'yes';
$display_read_more    = ! empty( $display_read_more ) ? $display_read_more : 'yes';
$read_more_type       = ! empty( $read_more_type ) ? $read_more_type : 'link';
$display_author       = ! empty( $display_author ) ? $display_author : 'yes';
$display_date         = ! empty( $display_date   ) ? $display_date   : 'yes';
$post_from 		      = ! empty( $post_from ) ? $post_from : 'latest';
?>
<!-- General settings -->
<div id="tab-2" class="adl-tab-content" style="display: none;">
    <div class="cmb2-wrap form-table">

        <table class='cmb2-metabox'>
            <tr>
                <th><label for="gc[post_type]"><?php esc_html_e('Post type', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select id="pgcu_post_type" name="gc[post_type]">
                        <?php
                        $custom_posts = get_post_types(array(
                            'public'=>true,
                            ));
                        $exclude    = array( 'adl-shortcode','attachment', 'revision', 'nav_menu_item' );

                            foreach ( $exclude as $ex ) {
                                unset( $custom_posts[ $ex ] );
                            }

                        if( ! empty( $custom_posts ) ) {
                            foreach( $custom_posts as $value ){
                                $done = get_object_taxonomies( (object) array( 'post_type' => 'names', 'hide_empty' => true ) );
                                ?>

                                <option value="<?php echo esc_attr( $value );?>" <?php if(!empty($post_type) && $post_type ==$value){ echo "selected";}?> ><?php echo $value;?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>

                </td>

            </tr>

            <tr>
                <th><label for="sel5"><?php esc_html_e('Layout', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select  name="gc[layout]" id="sel5">
                        <option value="carousel">Carousel</option>
                        <option value="grid" <?php if(!empty($layout) && $layout == "grid"){ echo "selected";}?>>Grid</option>
                        <option value="isotope" <?php if(!empty($layout) && $layout == "isotope"){ echo "selected";}?>>Sortable Grid</option>
                        <option disabled>Masonry (Pro)</option>
                    </select>

                </td>
            </tr>

            <tr>
                <th><label for="gc[theme]"><?php esc_html_e('Select Theme', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select id="gc[theme]" name="gc[theme]">
                        <option value="theme-1">Theme-1</option>
                        <option value="theme-2" <?php if(!empty($theme) && $theme == "theme-2"){ echo "selected"; } ?>>Theme-2</option>
                        <option value="theme-3" <?php if(!empty($theme) && $theme == "theme-3"){ echo "selected"; } ?>>Theme-3</option>
                        <option value="theme-4" <?php if(!empty($theme) && $theme == "theme-4"){ echo "selected"; } ?>>Theme-4</option>
                        <option disabled>Theme-5(Pro)</option>
                        <option disabled>Theme-6(Pro)</option>
                        <option disabled>Theme-7(Pro)</option>
                        <option disabled>Theme-8(Pro)</option>
                        <option disabled>Theme-9(Pro)</option>
                        <option disabled>Theme-10(Pro)</option>
                        <option disabled>Theme-11(Pro)</option>
                        <option disabled>Theme-12(Pro)</option>
                        <option disabled>Theme-13(Pro)</option>
                        <option disabled>Theme-14(Pro)</option>
                        <option disabled>Theme-15(Pro)</option>
                        <option disabled>Theme-16(Pro)</option>
                        <option disabled>Theme-17(Pro)</option>
                        <option disabled>Theme-18(Pro)</option>
                        <option disabled>Theme-19(Pro)</option>
                        <option disabled>Theme-20(Pro)</option>
                        <option disabled>Theme-21(Pro)</option>
                    </select>
                </td>
            </tr>

            <tr>
                <th><label for="gc[total_posts]"><?php esc_html_e('Total Posts', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" id="gc[total_posts]" name="gc[total_posts]" value="<?php if(empty($total_posts)) {echo '12';
                    }else{ echo $total_posts;}?>"/>

                </td>
            </tr>

            <tr>            
                <th><label for="gc[post_from]"><?php esc_html_e('Display Post From', PGCU_TEXTDOMAIN); ?></label>
                </th>
                <td>
                    <select id="gc[post_from]" name="gc[post_from]">
                        <option value="latest" <?php checked( 'latest', $post_from, true ); ?>>Latest Posts</option>
                        <option value="older" <?php checked( 'older', $post_from, true ); ?>>Older Posts</option>
                        <option disabled>Feature Posts (Pro)</option>
                        <option disabled>Populer Posts (Pro)</option>
                        <option disabled>Random Posts (Pro)</option>
                        <option disabled>Posts by Category (Pro)</option>
                        <option disabled>Posts by Id (Pro)</option>
                        <option disabled>Posts by Tag (Pro)</option>
                        <option disabled>Posts by Year (Pro)</option>
                        <option disabled>Posts by Month (Pro)</option>
                    </select>
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[display_header_title]"><?php esc_html_e('Display Header Title', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_header_title]" id="gc[display_header_title1]" value="yes" <?php checked( 'yes', $display_header_title, true ); ?>>
                            <label for="gc[display_header_title1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_header_title]" id="gc[display_header_title2]" value="no" <?php checked( 'no', $display_header_title, true ); ?>>
                            <label for="gc[display_header_title2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr class='pgcu_header_title'>
                <th><label for="gc[header_title]"><?php esc_html_e('Header Title', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='text' class="cmb2-text-medium" id="gc[header_title]" name="gc[header_title]" value="<?php echo ! empty( $header_title ) ? $header_title : ''; ?>"/>

                </td>
            </tr>

            <tr>
                <th><label for="gc[display_title]"><?php esc_html_e('Display Title', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_title]" id="gc[display_title1]" value="yes" <?php checked( 'yes', $display_title, true ); ?>>
                            <label for="gc[display_title1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_title]" id="gc[display_title2]" value="no" <?php checked( 'no', $display_title, true ); ?>>
                            <label for="gc[display_title2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th><label for="gc[display_content]"><?php esc_html_e('Display Content', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_content]" id="gc[display_content1]" value="yes" <?php checked( 'yes', $display_content, true ); ?>>
                            <label for="gc[display_content1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_content]" id="gc[display_content2]" value="no" <?php checked( 'no', $display_content, true ); ?>>
                            <label for="gc[display_content2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th><label for="gc[content_word_limit]"><?php esc_html_e('Content Word Limit', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" id="gc[content_word_limit]" name="gc[content_word_limit]" value="<?php  echo esc_attr( ! empty( $content_word_limit ) ? $content_word_limit : '16' ); ?>"/>
                </td>
            </tr>

            <tr>
                <th><label for="gc[display_read_more]"><?php esc_html_e('Display Read more', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_read_more]" id="gc[display_read_more1]" value="yes" <?php checked( 'yes', $display_read_more, true ); ?>>
                            <label for="gc[display_read_more1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_read_more]" id="gc[display_read_more2]" value="no" <?php checked( 'no', $display_read_more, true ); ?>>
                            <label for="gc[display_read_more2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr class="gc-read-more-type-section">
                <th><label for="gc[read_more_type]"><?php esc_html_e('Read More Type', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select class='pgcu_read_more_depend' id="gc[read_more_type]" name="gc[read_more_type]">
                        <option value="link" <?php selected( $read_more_type, 'link' ); ?>>Link Type</option>
                        <option value="button" <?php selected( $read_more_type, 'button' ); ?>>Button Type</option>
                    </select>
                </td>

            </tr>

            <tr>
                <th><label for="gc[display_author]"><?php esc_html_e('Display Author Name', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_author]" id="gc[display_author1]" value="yes" <?php checked( 'yes', $display_author, true ); ?>>
                            <label for="gc[display_author1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_author]" id="gc[display_author2]" value="no" <?php checked( 'no', $display_author, true ); ?>>
                            <label for="gc[display_author2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th><label for="gc[display_date]"><?php esc_html_e('Display Date', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_date]" id="gc[display_date1]" value="yes" <?php checked( 'yes', $display_date, true ); ?>>
                            <label for="gc[display_date1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_date]" id="gc[display_date2]" value="no" <?php checked( 'no', $display_date, true ); ?>>
                            <label for="gc[display_date2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th><label for="gc[display_term]"><?php esc_html_e('Display Term', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[display_term]" id="gc[display_term1]" value="yes" <?php checked( 'yes', $display_term, true ); ?>>
                            <label for="gc[display_term1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[display_term]" id="gc[display_term2]" value="no" <?php checked( 'no', $display_term, true ); ?>>
                            <label for="gc[display_term2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>
            </tr>

            <tr>
                <th><label for="gc[term_from]"><?php esc_html_e('Term From', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select class='pgcu_post_type_depend' id="gc[term_from]" name="gc[term_from]">
                        <?php
                        $terms = get_object_taxonomies( (object) array( 'post_type' => $post_type, 'hide_empty' => false ) );
                        if( $terms ) {
                            foreach( $terms as $term ) {
                        ?>
                        <option value="<?php echo esc_attr( $term ); ?>" <?php selected( $term_from, $term ); ?>><?php echo $term; ?></option>
                       <?php } } ?>
                    </select>

                </td>

            </tr>

            <tr>
                <th><label for="gc[image_resize_crop]"><?php esc_html_e('Enable Image Resizing & Cropping', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[image_resize_crop]" id="gc[image_resize_crop1]" value="yes" <?php if(empty($image_resize_crop) || 'no' !== $image_resize_crop) { echo 'checked'; } ?>>
                            <label for="gc[image_resize_crop1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[image_resize_crop]" id="gc[image_resize_crop2]" value="no" <?php if (!empty($image_resize_crop)) { checked('no', $image_resize_crop); } ?>>
                            <label for="gc[image_resize_crop2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>

                    <p class="description">If the product images are not in the same size, this feature is helpful. It automatically resizes and crops. Note: your image must be higher than/equal to the cropping size set below. Otherwise, you may need to enable image upscaling feature from the settings below.</p>
                </td>

            </tr>

            <tr>
                <th><label for="gc[image_width]"><?php esc_html_e('Image Width', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" id="gc[image_width]" name="gc[image_width]" value="<?php if(empty($image_width)) {echo '300';
                    }else{ echo $image_width;}?>"/>
                    <p class="description"><?php esc_html_e('Image cropping width.', PGCU_TEXTDOMAIN); ?></p>
                </td>
            </tr>

            <tr>
                <th><label for="gc[image_hight]"><?php esc_html_e('Image Height', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" id="gc[image_hight]" name="gc[image_hight]" value="<?php if(empty($image_hight)) {echo '200';
                    }else{ echo esc_attr( $image_hight ) ; } ?>"/>
                    <p class="description"><?php esc_html_e('Image cropping height.', PGCU_TEXTDOMAIN); ?></p>
                </td>
            </tr>

        </table>

    </div>

</div>