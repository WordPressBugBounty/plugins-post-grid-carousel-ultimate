<?php  
$autoplay                =   ! empty( $autoplay ) ? $autoplay : 'yes';
$pause_hover             =   ! empty( $pause_hover ) ? $pause_hover : 'no';
$repeat_post             =   ! empty( $repeat_post ) ? $repeat_post : 'yes';
$navigation              =   ! empty( $navigation  ) ? $navigation  : 'yes';
$navigation_position     =   ! empty( $navigation_position  ) ? $navigation_position  : 'middle';
?>
<div id="tab-3" class="adl-tab-content">

    <div class="cmb2-wrap form-table">
        <table class="cmb2-metabox">

            <tr>
                <th><label for="gc[post_column]"><?php esc_html_e('Post Column', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" name="gc[post_column]" value="<?php echo esc_attr( ! empty( $post_column ) ? $post_column : '3' ); ?>"/>
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[post_column_laptop]"><?php esc_html_e('Post Column on Laptop', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" name="gc[post_column_laptop]" value="<?php echo esc_attr( ! empty( $post_column_laptop ) ? $post_column_laptop : '3' ); ?>"/>
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[post_column_tablet]"><?php esc_html_e('Post column on Tablet', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" name="gc[post_column_tablet]" id="gc[post_column_tablet]" value="<?php echo esc_attr( ! empty( $post_column_tablet ) ? $post_column_tablet : '2' ); ?>" />
                </td>
            </tr>
            <tr>
                <th><label for="gc[post_column_mobile]"><?php esc_html_e('Post column on Mobile', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <input type='number' class="cmb2-text-medium" name="gc[post_column_mobile]" id="gc[post_column_mobile]" value="<?php echo esc_attr( ! empty( $post_column_mobile ) ? $post_column_mobile : '1' ); ?>" />
                    
                </td>
            </tr>  

            <tr>
                <th><label for="gc[autoplay]"><?php esc_html_e('Autoplay', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[autoplay]" id="gc[autoplay1]" value="yes" <?php checked( 'yes', $autoplay, true ); ?>> 
                            <label for="gc[autoplay1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[autoplay]" id="gc[autoplay2]" value="no" <?php checked( 'no', $autoplay, true ); ?>> 
                            <label for="gc[autoplay2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>    
            </tr>

            <tr>
                <th><label for="gc[pause_hover]"><?php esc_html_e('Pause on Hover', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[pause_hover]" id="gc[pause_hover1]" value="yes" <?php checked( 'yes', $pause_hover, true ); ?>> 
                            <label for="gc[pause_hover1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[pause_hover]" id="gc[pause_hover2]" value="no" <?php checked( 'no', $pause_hover, true ); ?>> 
                            <label for="gc[pause_hover2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>    
            </tr>

            <tr>
                <th><label for="gc[repeat_post]"><?php esc_html_e('Repeat Post', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[repeat_post]" id="gc[repeat_post1]" value="yes" <?php checked( 'yes', $repeat_post, true ); ?>> 
                            <label for="gc[repeat_post1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[repeat_post]" id="gc[repeat_post2]" value="no" <?php checked( 'no', $repeat_post, true ); ?>> 
                            <label for="gc[repeat_post2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>    
            </tr>

            <tr>
                <th><label for="gc[c_autoplay_speed]"><?php esc_html_e('Slide Speed', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="number" class="cmb2-text-medium" id="gc[c_autoplay_speed]" name="gc[c_autoplay_speed]" value="<?php echo esc_attr( ! empty( $c_autoplay_speed ) ? $c_autoplay_speed : '2000' ); ?>"/><span class="description">(Millisecond)</span>
                    
                </td>
                
            </tr>

            <tr>
                <th><label for="gc[c_autoplay_time]"><?php esc_html_e('Slide Timeout', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="number" class="cmb2-text-medium" id="gc[c_autoplay_time]" name="gc[c_autoplay_time]" value="<?php echo esc_attr( ! empty( $c_autoplay_time ) ? $c_autoplay_time : '2000' ); ?>"/><span class="description">(Millisecond)</span>
                    
                </td>
                
            </tr>    

            <tr>
                <th><label for="gc[navigation]"><?php esc_html_e('Navigation', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <ul class="cmb2-radio-list cmb2-list cmb2-radio-switch">
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch1" name="gc[navigation]" id="gc[navigation1]" value="yes" <?php checked( 'yes', $navigation, true ); ?>> 
                            <label for="gc[navigation1]"><?php esc_html_e('Yes', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                        <li>
                            <input type="radio" class="cmb2-option cmb2-radio-switch2" name="gc[navigation]" id="gc[navigation2]" value="no" <?php checked( 'no', $navigation, true ); ?>> 
                            <label for="gc[navigation2]"><?php esc_html_e('No', PGCU_TEXTDOMAIN); ?></label>
                        </li>
                    </ul>
                </td>    
            </tr>

            <tr>
                <th><label for="gc[navigation_position]"><?php esc_html_e('Navigation Position', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select class='pgcu_post_type_depend' id="gc[navigation_position]" name="gc[navigation_position]">
                        <option value="top-left" <?php selected( $navigation_position, 'top-left' ); ?>>Top Left</option>
                        <option value="top-right" <?php selected( $navigation_position, 'top-right' ); ?>>Top Right</option>
                        <option value="middle" <?php selected( $navigation_position, 'middle' ); ?>>Middle</option>
                        <option value="bottom-left" <?php selected( $navigation_position, 'bottom-left' ); ?>>Bottom Left</option>
                        <option value="bottom-right" <?php selected( $navigation_position, 'bottom-right' ); ?>>Bottom Right</option>
                    </select>
                </td>
            </tr>

            <tr>
                <th><label for="gc[navigation_arrow_color]"><?php esc_html_e('Navigation Arrow Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_arrow_color]" id="gc[navigation_arrow_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_arrow_color ) ? $navigation_arrow_color : '#030517' ); ?>" />
                    
                </td> 
            </tr>

            <tr>
                <th><label for="gc[navigation_arrow_hover_color]"><?php esc_html_e('Navigation Arrow Hover Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_arrow_hover_color]" id="gc[navigation_arrow_hover_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_arrow_hover_color ) ? $navigation_arrow_hover_color : '#fff' ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[navigation_back_color]"><?php esc_html_e('Navigation Background Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_back_color]" id="gc[navigation_back_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_back_color ) ? $navigation_back_color : '#f5f5f5' ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[navigation_back_hover_color]"><?php esc_html_e('Navigation Background Hover Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_back_hover_color]" id="gc[navigation_back_hover_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_back_hover_color ) ? $navigation_back_hover_color : '#F31C1C' ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[navigation_border_color]"><?php esc_html_e('Navigation Border Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_border_color]" id="gc[navigation_border_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_border_color ) ? $navigation_border_color : '#f5f5f5' ); ?>" />
                    
                </td>
            </tr>

            <tr>
                <th><label for="gc[navigation_border_hover_color]"><?php esc_html_e('Navigation Border  Hover Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[navigation_border_hover_color]" id="gc[navigation_border_hover_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $navigation_border_hover_color ) ? $navigation_border_hover_color : '#F31C1C' ); ?>" />
                    
                </td>
            </tr>

        </table>
    </div>
    
</div>