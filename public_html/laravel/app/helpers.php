<?php

if (!function_exists('get_provinces')) {
    function get_provinces()
    {
        return \Illuminate\Support\Facades\Cache::remember('all_provinces', 86400, function () {
            return \App\Models\Province::all();
        });
    }
}

if (!function_exists('get_districts')) {
    function get_districts($city)
    {
        return \App\Models\District::where('city_id', $city)->get();
    }
}

if (!function_exists('get_categories')) {
    function get_categories($isService = false)
    {
        if (!$isService) {
            return \Illuminate\Support\Facades\Cache::remember('root_categories_active', 3600, function () {
                return \App\Models\Category::whereNull('parent_id')->where('status', 1)->get();
            });
        } else {
            // ✅ Sadece aktif ve süresi dolmamış paketlerin kategorilerini al
            $activeCategoryIds = auth()->user()->company->purchasedPackages
                ->where('end_date', '>=', now())
                ->pluck('category_id')
                ->toArray();

            return \App\Models\Category::whereIn('id', $activeCategoryIds)
                ->whereNull('parent_id')->where('status', 1)->get();
        }
    }
}

if (!function_exists('get_sub_categories')) {
    function get_sub_categories($category)
    {
        return \App\Models\Category::where('parent_id', $category)->where('status', 1)->get();
    }
}

if (!function_exists('auth_info')) {
    function auth_info($id = null)
    {
        $user = !$id ? auth()->user() : \App\Models\User::where('id', $id)->first();

        if (!$user) {
            return null;
        }

        // Kullanıcı tipi user ise informations tablosunu döndür
        if ($user->user_type === 'user') {
            return $user->informations ?? (object)[
                'name' => $user->name,
                'avatar' => $user->avatar,
                'slug' => null
            ];
        }

        // Kullanıcı tipi company ise company tablosunu döndür
        if ($user->user_type === 'company') {
            return $user->company ?? (object)[
                'name' => $user->name,
                'avatar' => $user->avatar,
                'slug' => null
            ];
        }

        return null;
    }
}



if (!function_exists('get_file_extension')) {
    function get_file_extension($filePath)
    {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }
}

if (!function_exists('change_timezone')) {
    function change_timezone($time, $format = null)
    {

        return !$format ? \Carbon\Carbon::parse($time)->tz('Europe/Istanbul')->format('d.m.Y H:i:s')
            : \Carbon\Carbon::parse($time)->tz('Europe/Istanbul')->format($format);
    }
}


if (!function_exists('analytic_percentage_change')) {
    function analytic_percentage_change($oldValue, $newValue)
    {
        if ($oldValue == 0 && $newValue > 0) {
            return 100; // Sıfırdan artış durumunda

        } elseif ($oldValue == 0) {
            return 0; // Sıfıra bölünme hatası durumunda
        }

        $degisim = (($newValue - $oldValue) / $oldValue) * 100;
        return round($degisim); // Tam sayı olarak döndür
    }
}


if (!function_exists('format_decimal_input')) {
    function format_decimal_input($input)
    {
        if ($input) {
            // Sadece rakam ve virgül dışındakileri temizle
            $input = preg_replace('/[^\d,]/', '', $input);

            // Virgülden ayır
            $parts = explode(',', $input);
            $intPart = $parts[0] ?? '0';
            $decimalPart = isset($parts[1]) ? substr($parts[1], 0, 2) : '';

            // Arka plan değeri: noktalı sistem (10.50 gibi)
            $rawNumber = $decimalPart !== '' ? $intPart . '.' . $decimalPart : $intPart;

            // Görsel için binlik ayırmalı virgüllü format (örn: 1.234,56)
            $groupedInt = number_format((int)$intPart, 0, '', '.');
            $visible = $decimalPart !== '' ? $groupedInt . ',' . $decimalPart : $groupedInt;

            return [
                'raw' => $rawNumber,   // Arkaplanda kullanılacak gerçek değer (örn: "1234.56")
                'visible' => $visible  // Kullanıcıya gösterilecek format (örn: "1.234,56")
            ];
        } else {
            return [
                'raw' => null,
                'visible' => null
            ];
        }
    }
}



if (!function_exists('user_notifications')) {
    function user_notifications()
    {
        $notifications = \App\Models\Notification::where('to_id', auth()->user()->id)
            ->where('is_read', 0)
            ->orderByDesc('id')
            ->limit(50)
            ->get();

        $unreadCount = $notifications->count();

        // Bildirimleri sadece çek, okundu olarak işaretleme
        // Kullanıcı bildirime tıkladığında okundu yapılacak

        return [
            'unread_count' => $unreadCount,
            'values' => $notifications,
        ];
    }
}


if (!function_exists('get_user_ip_address')) {
    function get_user_ip_address()
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Çoklu IP varsa ilkini al
            return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            // Cloudflare için
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }

        return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
