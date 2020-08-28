<?php
$to = 'meharabdullah899@gmail.com';
if ( mail( $to, 'Test mail', "It is just a test mail.") ) {
	echo "Mail sent successfully!<br>\n";
} else {
	echo "Mail sending failed :(<br>\n";
}
?>
