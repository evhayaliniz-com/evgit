<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    /**
     * Anasayfa cache'lerini temizle
     */
    public static function clearHomeCache()
    {
        Cache::forget('home_categories');
        Cache::forget('home_popular_services');
        Cache::forget('home_latest_ideas');
        Cache::forget('home_featured_companies');
    }

    /**
     * Kategori cache'lerini temizle
     */
    public static function clearCategoryCache()
    {
        Cache::forget('home_categories');
        // Diğer kategori cache'leri buraya eklenebilir
    }

    /**
     * Servis cache'lerini temizle
     */
    public static function clearServiceCache()
    {
        Cache::forget('home_popular_services');
        // Diğer servis cache'leri buraya eklenebilir
    }

    /**
     * Fikir cache'lerini temizle
     */
    public static function clearIdeaCache()
    {
        Cache::forget('home_latest_ideas');
        // Diğer fikir cache'leri buraya eklenebilir
    }

    /**
     * Firma cache'lerini temizle
     */
    public static function clearCompanyCache()
    {
        Cache::forget('home_featured_companies');
        // Diğer firma cache'leri buraya eklenebilir
    }

    /**
     * Tüm cache'leri temizle
     */
    public static function clearAllCache()
    {
        self::clearHomeCache();
        self::clearCategoryCache();
        self::clearServiceCache();
        self::clearIdeaCache();
        self::clearCompanyCache();
    }
}
