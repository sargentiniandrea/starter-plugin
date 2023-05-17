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
<h1>Box operatori - EDITOR</h1>
<br>


<form method="post" action="options.php" class="cont-form-email-programmate">

    <div class="container-generale-editor">

        <div class="container-editor-template">
            <?php settings_fields('editor_lista_op_page_group'); ?>
            <?php do_settings_sections('editor_lista_op_page') ?>
        </div>

        <div class="container-preview-template">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">Live preview</th>
                        <td>
                            <div class="container-preview">
                                <div class="container-style-preview"></div>
                                <div class="container-lista-op"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <?php submit_button() ?>

</form>

</div>

<script type="text/javascript">
<?php include NP_PLUG_PATH . 'admin/js/lista-op-settings.js'; ?>
</script>