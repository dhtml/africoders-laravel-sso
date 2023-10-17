<?php

namespace Africoders\SSO\Services;

class ConfigService
{
    public static function getConfig($name)
    {
        $globalConfig = self::getGlobalConfig();
        $moduleconfig = $globalConfig["africoders-laravel-sso"] ?? [];
        return $moduleconfig[$name] ?? "";
    }

    public static function getGlobalConfig()
    {
        static $configData;
        if ($configData) {
            return $configData;
        }
        $configData = require __DIR__ . '/../../../../../config.php'; // Adjust the path as needed
        return $configData;
    }

    public static function getLogoutUrl() {
      $host=$_SERVER["HTTP_HOST"];
      if(strstr($host,".com")) {
          $configName = "logout_Url_prod";
      } else {
          $configName = "logout_Url_dev";
      }
      return self::getConfig($configName);
    }

}