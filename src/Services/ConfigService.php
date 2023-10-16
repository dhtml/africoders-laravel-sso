<?php
namespace Africoders\SSO\Services;

class ConfigService {
    public static function getGlobalConfig() {
        static $configData;
        if($configData) {return $configData;}
        $configData = require __DIR__ . '/../../../../../config.php'; // Adjust the path as needed
        return $configData;
    }

    public static function getConfig($name) {
        $globalConfig = self::getGlobalConfig();
        $moduleconfig = $globalConfig["africoders-laravel-sso"] ?? [];
        return $moduleconfig[$name] ?? "";
    }
}