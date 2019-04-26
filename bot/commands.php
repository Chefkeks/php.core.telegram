<?php
// Init command.
$command = NULL;

// Check message text for a leading slash.
if (substr($update['message']['text'], 0, 1) == '/') {
    // Get command name.
    if(defined('BOT_NAME')) {
        $com = strtolower(str_replace('/', '', str_replace(BOT_NAME, '', explode(' ', $update['message']['text'])[0])));
        $altcom = strtolower(str_replace('/' . basename(ROOT_PATH), '', str_replace(BOT_NAME, '', explode(' ', $update['message']['text'])[0])));
    } else {
        debug_log('BOT_NAME is missing! Please define it!', '!');
        $com = 'start';
        $altcom = 'start';
    }

    // Set command paths.
    $command = ROOT_PATH . '/commands/' . basename($com) . '.php';
    $altcommand = ROOT_PATH . '/commands/' . basename($altcom) . '.php';
    $startcommand = ROOT_PATH . '/commands/start.php';

    // Write to log.
    debug_log('Command-File: ' . $command);
    debug_log('Alternative Command-File: ' . $altcommand);
    debug_log('Start Command-File: ' . $startcommand);

    // Check if command file exits.
    if (is_file($command)) {
        // Dynamically include command file and exit.
        include_once($command);
        exit();
    } else if (is_file($altcommand)) {
        // Dynamically include command file and exit.
        include_once($altcommand);
        exit();
    } else if ($com == basename(ROOT_PATH)) {
        // Include start file and exit.
        include_once($startcommand);
        exit();
    } else {
        sendMessage($update['message']['chat']['id'], '<b>' . getTranslation('not_supported') . '</b>');
        exit();
    }
}