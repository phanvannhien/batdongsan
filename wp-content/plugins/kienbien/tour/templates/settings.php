<div class="wrap">
    <h2>Setting for Tour</h2>
    <form method="post" action="options.php"> 
        <?php @settings_fields('tour-setting-group'); ?>
        <?php @do_settings_fields('tour-setting-group'); ?>

        <?php do_settings_sections('tour_settings_fields'); ?>

        <?php @submit_button(); ?>
    </form>
</div>