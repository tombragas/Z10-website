<?php

/* SVB - 2014
 * Script to call via wget in a cronjob to include the Reminder_cron.php from our Calendar Reminder.
 * this is necessary, because our chroot has no "sendmail" so the mail() function in PHP doesn't work 
 * when we just do "php Reminder_cron.php". We have to call it from a running webserver.
 * oh yeah, netcup sucks.
 */
exec( 'php ../wiki.z10.info/extensions/Z10CalendarReminder/Reminder_cron.php' );

?>
