<script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<script>
    var autocomplete;
    function initialize() {
        autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
            types: ['(cities)']
        });

    }
</script>
<body onload="initialize()">
<div class="wrap"><h2><?php _e('Settings Wp Showtime Plugin', 'wp-showtime') ?></h2>

    <p><?php _e('Place <kbd>[showtime]</kbd> in your post or page body.', 'wp-showtime') ?></p>

    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="autocomplete"><?php _e('Enter the default city', 'wp-showtime') ?></label></th>
                <td id="locationField">
                    <input type="text" id="autocomplete"
                           onFocus="geolocate()" size="50" name="showtime_city"
                           value="<?php echo get_option('showtime_city'); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="lang"><?php _e('Language', 'wp-showtime') ?></label></th>
                <td>
                    <select name="showtime_lang" id="lang">
                        <option <?php if (get_option('showtime_lang') == 'ru'): echo 'selected'; endif ?>
                            value="ru">Русский
                        </option>
                        <option
                            <?php if (get_option('showtime_lang') == 'en'): echo 'selected'; endif ?>
                            value="en">Английский
                        </option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Entry form city', 'wp-showtime') ?></th>
                <td><label for="showform"><input type="checkbox" id="showform"
                           name="showtime_showform" <?php if (get_option('showtime_showform') == 1): echo "checked"; endif ?>
                           value="1"> <?php _e('Show any entry form of the city on the page with showtimes.', 'wp-showtime') ?></label></td>
            </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="Submit" class='button button-primary' value="<?php _e('Save Changes', 'wp-showtime') ?>">
        </p>
        <input type="hidden" name="action" value="update"> <input type="hidden" name="page_options"
                                                                  value="showtime_city,showtime_lang,showtime_showform">
    </form>
</div>

</body>
