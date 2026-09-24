<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CacheImages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Sadece görsel dosyaları için cache headers ekle
        $path = $request->path();
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico', 'bmp'];
        $staticExtensions = ['css', 'js', 'woff', 'woff2', 'ttf', 'eot'];

        // Görseller için cache headers
        if (in_array($extension, $imageExtensions)) {
            // Görseller için 1 yıl cache (31536000 saniye)
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
            $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

            // ETag ekle (dosya değiştiğinde cache'i geçersiz kılmak için)
            $filePath = public_path($path);
            if (file_exists($filePath) && is_file($filePath)) {
                $etag = md5_file($filePath);
                $response->headers->set('ETag', '"' . $etag . '"');

                // Last-Modified header ekle
                $lastModified = filemtime($filePath);
                $response->headers->set('Last-Modified', gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');
            }
        }

        // CSS ve JS için cache headers
        if (in_array($extension, $staticExtensions)) {
            if ($extension === 'css' || $extension === 'js') {
                // CSS ve JS için 1 ay cache
                $response->headers->set('Cache-Control', 'public, max-age=2592000');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT');
            } else {
                // Fontlar için 1 yıl cache
                $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
                $response->headers->set('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
            }
        }

        return $response;
    }
}
