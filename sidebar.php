<?php
/**
 * The left sidebar.
 * 
 * @package FlitchBasicWP5
 */

if (is_active_sidebar('sidebar-left')) {
?> 
    <div id="sidebar-left" class="col-md-3">
        <?php dynamic_sidebar('sidebar-left'); ?> 
    </div>
<?php
}