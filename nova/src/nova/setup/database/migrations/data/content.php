<?php

$headers	= include 'content/headers.php';
$titles		= include 'content/titles.php';
$messages	= include 'content/messages.php';
$emails		= include 'content/emails.php';

return array_merge($headers, $titles, $messages, $emails);