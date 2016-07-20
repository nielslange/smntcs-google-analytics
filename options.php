<div class="wrap">

    <h2>Google Analytics</h2>

    <form method="post" action="options.php">

        <?php wp_nonce_field('update-options'); ?>
        <?php settings_fields('google_analytics'); ?>

        <p>
			<strong><?php _e('Google Analytics tracking code:', 'smntcs-google-analytics'); ?></strong>
        </p>
        <p>
			<textarea rows="10" cols="100" name="google_analytics_tracking_code" placeholder="<?php _e('Please place your Google Analytics tracking code here', 'smntcs-google-analytics')?>"><?php echo get_option('google_analytics_tracking_code'); ?></textarea>
        </p>
        <p class="submit">
            <input type="hidden" name="action" value="update" />
            <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'smntcs-google-analytics'); ?>" />
        </p>

    </form>

</div>
