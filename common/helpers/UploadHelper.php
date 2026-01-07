<?php
namespace common\helpers;

use Yii;

class UploadHelper
{
    /**
     * Rasm URL ni olish
     */
    public static function getImageUrl($path)
    {
        if (empty($path)) {
            return null;
        }

        // Agar to'liq URL bo'lsa
        if (strpos($path, 'http') === 0) {
            return $path;
        }

        // Nisbiy yo'lni to'liq URL ga aylantirish
        return Yii::$app->request->baseUrl . '/' . ltrim($path, '/');
    }

    /**
     * Rasm saqlash yo'li
     */
    public static function getUploadPath($subDir = '')
    {
        $path = Yii::getAlias('@common/uploads/' . $subDir);

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }

    /**
     * Rasmni o'chirish
     */
    public static function deleteImage($path)
    {
        if (empty($path)) {
            return false;
        }

        $fullPath = Yii::getAlias('@common/' . $path);

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }
}