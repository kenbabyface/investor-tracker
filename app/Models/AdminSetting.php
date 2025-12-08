<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminSetting extends Model
{
    protected $fillable = ['key', 'value'];


    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function verifyPassword($password)
    {
        $hashedPassword = self::get('admin_password');
        
        if (!$hashedPassword) {
            return false;
        }

        return Hash::check($password, $hashedPassword);
    }

    public static function updatePassword($newPassword)
    {
        return self::set('admin_password', Hash::make($newPassword));
    }
}