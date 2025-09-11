<?php

namespace App\Helpers;

class LanguageHelper
{
    /**
     * Get available languages
     */
    public static function getAvailableLanguages()
    {
        return [
            'vi' => [
                'name' => 'Việt Nam',
                'flag' => '🇻🇳',
                'code' => 'VI'
            ],
            'en' => [
                'name' => 'English',
                'flag' => '🇺🇸',
                'code' => 'EN'
            ],
            'ja' => [
                'name' => '日本語',
                'flag' => '🇯🇵',
                'code' => 'JA'
            ],
            'zh' => [
                'name' => '中文',
                'flag' => '🇨🇳',
                'code' => 'ZH'
            ],
            'bn' => [
                'name' => 'বাংলা',
                'flag' => '🇧🇩',
                'code' => 'BN'
            ]
        ];
    }

    /**
     * Get current language info
     */
    public static function getCurrentLanguage()
    {
        $locale = app()->getLocale();
        $languages = self::getAvailableLanguages();
        
        return $languages[$locale] ?? $languages['vi'];
    }

    /**
     * Get language name by locale
     */
    public static function getLanguageName($locale)
    {
        $languages = self::getAvailableLanguages();
        return $languages[$locale]['name'] ?? 'Unknown';
    }

    /**
     * Check if locale is supported
     */
    public static function isSupported($locale)
    {
        return array_key_exists($locale, self::getAvailableLanguages());
    }

    /**
     * Get translation for admin or user
     */
    public static function getTranslation($key, $type = 'user', $locale = null, $replace = [])
    {
        $locale = $locale ?: app()->getLocale();
        
        // Determine the path based on type using namespace
        if ($type === 'admin') {
            $translation = __("admin::auth.{$key}", $replace);
            
            // If translation not found, try user as fallback
            if ($translation === "admin::auth.{$key}") {
                $translation = __("user::auth.{$key}", $replace);
            }
            
            // If still not found, try the old auth path as final fallback
            if ($translation === "user::auth.{$key}") {
                $translation = __("auth.{$key}", $replace);
            }
        } else {
            $translation = __("user::auth.{$key}", $replace);
            
            // If translation not found, try admin as fallback
            if ($translation === "user::auth.{$key}") {
                $translation = __("admin::auth.{$key}", $replace);
            }
            
            // If still not found, try the old auth path as final fallback
            if ($translation === "admin::auth.{$key}") {
                $translation = __("auth.{$key}", $replace);
            }
        }
        
        return $translation;
    }

    /**
     * Get translation from specific file (e.g., home, auth, etc.)
     */
    public static function getTranslationFromFile($file, $key, $type = 'user', $locale = null, $replace = [])
    {
        $locale = $locale ?: app()->getLocale();
        
        // Determine the path based on type using namespace
        if ($type === 'admin') {
            $translation = __("admin::{$file}.{$key}", $replace);
            
            // If translation not found, try user as fallback
            if ($translation === "admin::{$file}.{$key}") {
                $translation = __("user::{$file}.{$key}", $replace);
            }
            
            // If still not found, try the old path as final fallback
            if ($translation === "user::{$file}.{$key}") {
                $translation = __("{$file}.{$key}", $replace);
            }
        } else {
            $translation = __("user::{$file}.{$key}", $replace);
            
            // If translation not found, try admin as fallback
            if ($translation === "user::{$file}.{$key}") {
                $translation = __("admin::{$file}.{$key}", $replace);
            }
            
            // If still not found, try the old path as final fallback
            if ($translation === "admin::{$file}.{$key}") {
                $translation = __("{$file}.{$key}", $replace);
            }
        }
        
        return $translation;
    }

    /**
     * Get admin translation
     */
    public static function getAdminTranslation($key, $locale = null, $replace = [])
    {
        return self::getTranslationFromFile('auth', $key, 'admin', $locale, $replace);
    }

    /**
     * Get admin CMS translation
     */
    public static function getAdminCmsTranslation($key, $locale = null, $replace = [])
    {
        return self::getTranslationFromFile('cms', $key, 'admin', $locale, $replace);
    }

    /**
     * Get user translation
     */
    public static function getUserTranslation($key, $locale = null, $replace = [])
    {
        return self::getTranslation($key, 'user', $locale, $replace);
    }

    /**
     * Get home translation for user
     */
    public static function getHomeTranslation($key, $locale = null, $replace = [])
    {
        return self::getTranslationFromFile('home', $key, 'user', $locale, $replace);
    }

    /**
     * Get home translation for admin
     */
    public static function getAdminHomeTranslation($key, $locale = null, $replace = [])
    {
        return self::getTranslationFromFile('home', $key, 'admin', $locale, $replace);
    }

    /**
     * Check if admin translation exists
     */
    public static function hasAdminTranslation($key, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = __("admin.{$key}");
        return $translation !== "admin.{$key}";
    }

    /**
     * Check if user translation exists
     */
    public static function hasUserTranslation($key, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        $translation = __("user.{$key}");
        return $translation !== "user.{$key}";
    }
}
