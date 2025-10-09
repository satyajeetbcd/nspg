<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('setting_key', $key)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            return $default;
        }

        switch ($setting->setting_type) {
            case 'number':
                return (float) $setting->setting_value;
            case 'boolean':
                return (bool) $setting->setting_value;
            case 'json':
                return json_decode($setting->setting_value, true);
            default:
                return $setting->setting_value;
        }
    }

    /**
     * Set setting value by key
     */
    public static function setValue($key, $value, $type = 'text', $description = null)
    {
        $setting = static::where('setting_key', $key)->first();

        if (!$setting) {
            $setting = new static();
            $setting->setting_key = $key;
        }

        $setting->setting_value = is_array($value) ? json_encode($value) : (string) $value;
        $setting->setting_type = $type;
        $setting->description = $description;
        $setting->is_active = true;
        $setting->save();

        return $setting;
    }

    /**
     * Get all active settings as key-value pairs
     */
    public static function getAllSettings()
    {
        $settings = static::where('is_active', true)->get();
        $result = [];

        foreach ($settings as $setting) {
            $result[$setting->setting_key] = self::getValue($setting->setting_key);
        }

        return $result;
    }
}
