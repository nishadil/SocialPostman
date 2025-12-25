<?php

namespace Nishadil\SocialPostman\Core;

class Logger
{
    protected static string $file = __DIR__ . '/../../logs/socialpostman.log';

    protected static function write(string $level, string $message, array $context = []): void
    {
        if (!file_exists(dirname(self::$file))) {
            mkdir(dirname(self::$file), 0777, true);
        }

        $line = sprintf(
            "[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            $level,
            $message,
            json_encode($context)
        );

        file_put_contents(self::$file, $line, FILE_APPEND);
    }

    public static function info(string $message, array $context = []): void
    {
        self::write('INFO', $message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::write('ERROR', $message, $context);
    }
}
