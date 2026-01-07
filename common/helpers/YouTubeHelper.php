<?php

namespace common\helpers;

class YouTubeHelper
{
    /**
     * YouTube video ID ni olish
     */
    public static function getVideoId($url)
    {
        if (empty($url)) {
            return null;
        }

        // Turli formatlar
        $patterns = [
            '/youtube\.com\/watch\?v=([^\&\?\/]+)/',
            '/youtube\.com\/embed\/([^\&\?\/]+)/',
            '/youtu\.be\/([^\&\?\/]+)/',
            '/youtube\.com\/v\/([^\&\?\/]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Embed URL
     */
    public static function getEmbedUrl($url)
    {
        $videoId = self::getVideoId($url);
        return $videoId ? "https://www.youtube.com/embed/{$videoId}?rel=0&modestbranding=1" : null;
    }

    /**
     * Thumbnail
     */
    public static function getThumbnail($url)
    {
        $videoId = self::getVideoId($url);
        return $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : null;
    }
}