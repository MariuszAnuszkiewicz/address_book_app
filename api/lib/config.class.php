<?php

declare(strict_types=1);

class Config {

    protected static $settings = [];
    protected static $env;

    public static function get($key) {
        return self::$settings[$key] ?? '';
    }

    public static function set($key, $value) {
        self::$settings[$key] = $value;
    }

    public static function initEnv(): void
    {
        self::$env = (new Env(API.'.env'))->load();
    }
}