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
                'name' => 'Tiếng Việt',
                'flag' => '🇻🇳',
                'code' => 'VI'
            ],
            'en' => [
                'name' => 'English',
                'flag' => '🇺🇸',
                'code' => 'EN'
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
}
