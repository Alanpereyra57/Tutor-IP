<?php
/**
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

$earning_sum = tutor_utils()->get_earning_sum();
$min_withdraw = tutor_utils()->get_option('min_withdraw_amount');

$saved_account = tutor_utils()->get_user_withdraw_method();
$withdraw_method_name = tutor_utils()->avalue_dot('withdraw_method_name', $saved_account);

$user_id = get_current_user_id();
?>

<div class="tutor-dashboard-content-inner">

    <div class="withdraw-page-current-balance">
        <h4><?php _e('Balance actual', 'tutor'); ?></h4>

        <div class="withdraw-balance-row">

			<?php
			$balance_formatted = tutor_utils()->tutor_price($earning_sum->balance);
			if ($earning_sum->balance >= $min_withdraw){
				?>
                <p class="withdraw-balance-col">
					<?php echo sprintf( __('Actualemente tienes %s %s %s listos para ser retirados', 'tutor'), "<strong class='available_balance'>", $balance_formatted, '</strong>' ); ?>
                </p>

				<?php if ($withdraw_method_name) { ?>
                    <p><a class="open-withdraw-form-btn" href="javascript:;"><?php _e( 'Retirar', 'tutor' ); ?></a></p>
					<?php
				}
			}else{
				?>

                <p class="withdraw-balance-col"> <?php echo sprintf( __('You currently have %s %s %s and this is insufficient balance to withdraw',
						'tutor'), "<strong class='available_balance'>", $balance_formatted, '</strong>' ); ?>
                </p>

				<?php
			}
			?>

        </div>

        <div class="current-withdraw-account-wrap">
			<?php
                if ($withdraw_method_name){
                    ?>
                    <p>
                        <?php _e('Tu pago será de', 'tutor'); ?> <strong><?php echo $withdraw_method_name; ?></strong>
                        <?php
                            $my_profile_url = tutor_utils()->get_tutor_dashboard_page_permalink('settings/withdraw-settings');
                            echo sprintf(__( ', Puedes cambiar tu %s preferencia de retiro %s ' , 'tutor'), "<a href='{$my_profile_url}'>", '</a>' );
                        ?>
                    </p>
                    <?php
                }else{
                    ?>
                    <p>
                        <?php
                        $my_profile_url = tutor_utils()->get_tutor_dashboard_page_permalink('my-profile');
                        echo sprintf(__( 'Por favor añade tu %s preferencia de retiro %s para poder retirar' , 'tutor'), "<a href='{$my_profile_url}'>", '</a>' );
                        ?>
                    </p>
                    <?php
                }
			?>
        </div>

    </div>

	<?php
	if ($earning_sum->balance >= $min_withdraw && $withdraw_method_name){
		?>

        <div class="tutor-earning-withdraw-form-wrap" style="display: none;">

            <form id="tutor-earning-withdraw-form" action="" method="post">
				<?php wp_nonce_field( tutor()->nonce_action, tutor()->nonce ); ?>
                <input type="hidden" value="tutor_make_an_withdraw" name="action"/>
				<?php do_action('tutor_withdraw_form_before'); ?>
                <div class="withdraw-form-field-row">
                    <label for="tutor_withdraw_amount"><?php _e('Cantidad:', 'tutor') ?></label>
                    <div class="tutor-row">
                        <div class="tutor-col-4">
                            <div class="withdraw-form-field-amount">
                                <input type="text" name="tutor_withdraw_amount">
                            </div>
                        </div>
                        <div class="tutor-col">
                            <div class="withdraw-form-field-button">
                                <button class="tutor-btn" type="submit" id="tutor-earning-withdraw-btn" name="withdraw-form-submit"><?php _e('Retirar', 'tutor'); ?></button>
                            </div>
                        </div>
                    </div>
                    <i><?php _e('Ingresar el monto a retirar y hacer click en el botón', 'tutor') ?></i>
                </div>

                <div id="tutor-withdraw-form-response"></div>

				<?php do_action('tutor_withdraw_form_after'); ?>
            </form>

        </div>

		<?php
	}
	?>


	<?php
	$withdraw_pending_histories = tutor_utils()->get_withdrawals_history(null, array('status' => array('pending')));
	$withdraw_completed_histories = tutor_utils()->get_withdrawals_history(null, array('status' => array('approved')));
	$withdraw_rejected_histories = tutor_utils()->get_withdrawals_history(null, array('status' => array('rejected')));
	?>

    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Retiros pendientes', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_pending_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Cantidad', 'tutor') ?></th>
                    <th><?php _e('Métodos de retiro', 'tutor') ?></th>
                    <th><?php _e('Fecha', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_pending_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<?php
		}else{
			?>
            <p><?php _e('No hay retiros pendientes', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>

    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Retiros pendientes', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_completed_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Cantidad', 'tutor') ?></th>
                    <th><?php _e('Método de retiro', 'tutor') ?></th>
                    <th><?php _e('Requerido el', 'tutor') ?></th>
                    <th><?php _e('Aprobado el', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_completed_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>

                        <td>
                            <?php
                            if ($withdraw_history->updated_at){
	                            echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->updated_at));
                            }
                            ?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<?php
		}else{
			?>
            <p><?php _e('No hay retiros completados aún', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>


    <div class="withdraw-history-table-wrap">
        <div class="withdraw-history-table-title">
            <h4> <?php _e('Retiros rechazados', 'tutor'); ?></h4>
        </div>

		<?php
		if (tutor_utils()->count($withdraw_rejected_histories->results)){
			?>
            <table class="withdrawals-history">
                <thead>
                <tr>
                    <th><?php _e('Cantidad', 'tutor') ?></th>
                    <th><?php _e('Método de retiro', 'tutor') ?></th>
                    <th><?php _e('Pedido el', 'tutor') ?></th>
                    <th><?php _e('Aprobado el', 'tutor') ?></th>
                </tr>
                </thead>
				<?php
				foreach ($withdraw_rejected_histories->results as $withdraw_history){
					?>
                    <tr>
                        <td><?php echo tutor_utils()->tutor_price($withdraw_history->amount); ?></td>
                        <td>
							<?php
							$method_data = maybe_unserialize($withdraw_history->method_data);
							echo tutor_utils()->avalue_dot('withdraw_method_name', $method_data)
							?>
                        </td>
                        <td>
							<?php
							echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->created_at));
							?>
                        </td>

                        <td>
							<?php
							if ($withdraw_history->updated_at){
								echo date_i18n(get_option('date_format').' '.get_option('time_format'), strtotime($withdraw_history->updated_at));
							}
							?>
                        </td>
                    </tr>
					<?php
				}
				?>
            </table>
			<?php
		}else{
			?>
            <p><?php _e('No hay retiros rechazados', 'tutor'); ?></p>
			<?php
		}
		?>
    </div>


</div>
