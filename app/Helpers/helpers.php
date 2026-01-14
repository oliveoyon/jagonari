<?php

use App\Models\GeneralSetting;

if (! function_exists('general_setting')) {
    /**
     * Get a general setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function general_setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            // Load the single row only once
            $settings = GeneralSetting::first();
        }

        if ($settings && isset($settings->$key)) {
            return $settings->$key;
        }

        return $default;
    }
}
