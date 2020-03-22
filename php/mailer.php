<?php
function mailer() {
    /*
     * Set the settings for php.ini and sendmail.ini by watching this video (read description)
     * https://www.youtube.com/watch?v=9W644cyDyNM
     * if you are getting an error about unauthorized username and password, view this video
     * https://www.youtube.com/watch?v=L5uCc8Hab-I
     *
     * How to set up delayed mail sending using Cron and batch files
     * Windows Task scheduler:
     * https://www.youtube.com/watch?v=C4PdPqEOo6A
     * Max or linux cron:
     * https://www.youtube.com/watch?v=ZsxQenUjt5U
     */

    $to = "ianshepard99@gmail.com";

    $subject = "An Automated message";

    $msg = "Hi Ian, this is an automated message sent from code!";

    // use wordwrap() so that the lines are no longer than 70 characters
    $msg = wordwrap($msg, 70);

    return mail($to, $subject, $msg);
}