<?php

require __DIR__ . '/../../bootstrap/app.php';
require __DIR__ . '/../actions/discode_action.php';

$discodeAction = new DiscodeAction();
$discodeAction->sendMessage('Hello, Discord! from php test');

