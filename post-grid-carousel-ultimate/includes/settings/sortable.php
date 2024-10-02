<?php  
$post_type            = ! empty( $post_type ) ? $post_type : 'post';
$g_sort               = ! empty( $g_sort    ) ? $g_sort    : 'category';
$terms                = get_object_taxonomies( (object) array( 'post_type' => $post_type, 'hide_empty' => false ) );
?>
<div id="tab-5" class="adl-tab-content">
    <div class="cmb2-wrap form-table">

        <table class="cmb2-metabox">
                
            <tr>
                <th><label for="gc[g_sort]"><?php esc_html_e('Select Sortable Grid Type', PGCU_TEXTDOMAIN); ?></label></th>
                <td>
                    <select id="gc[g_sort]" name="gc[g_sort]" class='pgcu_post_type_depend'>
                        <?php 
                        if( $terms ) {
                            foreach( $terms as $term ) {
                        ?>
                        <option value="<?php echo esc_attr( $term ); ?>" <?php selected( $g_sort, $term ); ?>><?php echo $term; ?></option>
                        <?php } } ?>
                    </select>
                </td>
            </tr>

            <tr>
                <th><label for="gc[sortable_menu_text_color]"><?php esc_html_e('Sortable Menu Text Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[sortable_menu_text_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $sortable_menu_text_color ) ? $sortable_menu_text_color : '#4F515A' ); ?>" />
                    
                </td>
                
            </tr>
            
            <tr>
                <th><label for="gc[sortable_menu_active_back_color]"><?php esc_html_e('Sortable Menu Active Background Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[sortable_menu_active_back_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $sortable_menu_active_back_color ) ? $sortable_menu_active_back_color : '#030213' ); ?>" />
                    
                </td>
                
            </tr>

            <tr>
                <th><label for="gc[sortable_menu_active__text_color]"><?php esc_html_e('Sortable Menu Active Text Color', PGCU_TEXTDOMAIN); ?></label></th>
                <td><input type="text" name="gc[sortable_menu_active__text_color]" class="cpa-color-picker" value="<?php echo esc_attr( ! empty( $sortable_menu_active__text_color ) ? $sortable_menu_active__text_color : '#ffffff' ); ?>" />
                    
                </td>
                
            </tr>
        </table>
    </div>
</div>