<?php 

/*
 * Template della pagina impostazioni dell'editor per la lista degli operatori
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

?>

<div class="wrap wrap-impost-editor-lista-op">
<div class="icon32" id="icon-options-general"><br /></div>
<h1>Custom CSS - Editor</h1>
<br>


<form method="post" action="options.php" class="cont-form-email-programmate">

        <div class="container-editor-custom-css-ar">
            <?php settings_fields('editor_css_ar_page_group'); ?>
            <?php do_settings_sections('custom_css_ar_page') ?>
        </div>

    <?php submit_button() ?>

</form>

</div>

<script type="text/javascript">
<?php include NP_PLUG_PATH . 'admin/js/custom-css-settings.js'; ?>
</script>