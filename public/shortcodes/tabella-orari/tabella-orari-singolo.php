<?php 

/*
 * Template per tabella orari singolo operatore
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

$user_id = get_post_meta(get_the_ID(), 'user_id', true);
$meta = get_user_meta( $user_id );
$user = get_user_by('id', $user_id);
$sepRiposo = get_option('txt_giorno_riposo') ? get_option('txt_giorno_riposo') : '-';
if(!$user){
	return;
}
$operatore = $this->utility->get_operatore_data($user, $sepRiposo);
?>

<div class="cont-tab-op cont-tab-sing">
	<table class="tabella-op tabella-op-singolo">
		<thead>
			<tr>
				<th>Lunedì</th>
				<th>Martedì</th>
				<th>Mercoledì</th>
				<th>Giovedì</th>
				<th>Venerdì</th>
				<th>Sabato</th>
				<th>Domenica</th>
			</tr>
		</thead>
		<tbody>
		<tr>
		<?php
		$orari = $operatore->orari;
		foreach ($orari as $giorno => $arrayOrario) { ?>
		<td>
		<div class="tab-giorno-mob"><?php echo $giorno ?></div>
		<div class="tab-orario">
			<?php
			foreach ($arrayOrario as $orario ) { ?>
				<div><?php echo $orario ?></div>
			<?php } ?>
		</div>
		</td>
		<?php }
		?>
		</tr>
		</tbody>
	</table>
</div>

