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
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string')
    {
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
