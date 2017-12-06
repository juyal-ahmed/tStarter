<?php
/**
 *
 * The search form markup
 *
 * @author Juyal Ahmed<tojibon@gmail.com>
 * @version: 1.0.0
 * https://themeredesign.com
 */

$search_text = '';
if (!empty($_REQUEST['s'])) {
    $search_text = $_REQUEST['s'];
}
?>
<form method="get" class="search-form" action="<?php echo home_url(); ?>/">
    <div class="form-group has-feedback">
        <label class="control-label sr-only" for="s">Search</label>
        <input type="text" name="s" value="<?php echo $search_text; ?>" title="Search for:"
               class="form-control search-field" id="s">
        <span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="false"></span>
    </div>
</form>

