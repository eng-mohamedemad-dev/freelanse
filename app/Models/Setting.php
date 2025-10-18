<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) {
            return $default;
        }
        if (($setting->type ?? 'string') === 'json') {
            $decoded = json_decode($setting->value, true);
            return $decoded === null ? $default : $decoded;
        }
        return $setting->value;
    }

    public static function set($key, $value, $type = 'string')
    {
        // Auto-detect arrays/objects and store as JSON
        if (is_array($value) || is_object($value)) {
            $type = 'json';
            $value = json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }

    public static function getBoolean($key, $default = false)
    {
        $value = static::get($key, $default);
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function getInteger($key, $default = 0)
    {
        $value = static::get($key, $default);
        return (int) $value;
    }
}
