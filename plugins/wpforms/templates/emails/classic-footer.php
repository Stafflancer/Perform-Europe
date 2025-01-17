<?php
/**
 * Classic footer template.
 *
 * This template can be overridden by copying it to yourtheme/wpforms/emails/classic-footer.php.
 *
 * @since 1.8.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

									</td>
								</tr>
								<tr>
									<td align="center" valign="top" class="footer">
										<?php
										/* translators: %1$s - link to the site. */
										printf( esc_html__( 'Sent from %1$s', 'wpforms-lite' ), '<a href="' . esc_url( home_url() ) . '">' . esc_html( wp_specialchars_decode( get_bloginfo( 'name' ) ) ) . '</a>' );
										?>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. --></td>
	</tr>
</table>
</body>
</html>
