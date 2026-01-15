<?php

use App\Models\GeneralSetting;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

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

if (! function_exists('get_menus')) {
    /**
     * Get all active menus with submenus
     * 
     * @return \Illuminate\Support\Collection
     */
    function get_menus()
    {
        static $menus = null;

        if ($menus === null) {
            $menus = Menu::where('is_active', 1)
                         ->whereNull('parent_id')
                         ->with(['children' => function($query) {
                             $query->where('is_active', 1)
                                   ->orderBy('display_order', 'asc');
                         }])
                         ->orderBy('display_order', 'asc')
                         ->get();
        }

        return $menus;
    }
}

if (! function_exists('menu_image_url')) {
    /**
     * Get full URL for menu's main image stored in storage
     *
     * @param string|null $path
     * @param string|null $default
     * @return string
     */
    function menu_image_url($path = null, $default = null)
    {
        if ($path) {
            return Storage::url($path);
        }

        return $default ?? asset('assets/img/default-menu.png');
    }
}

if (! function_exists('get_footer_menus')) {
    /**
     * Get footer menus by parent slug
     *
     * Example:
     *  useful-links
     *  services
     *
     * @param string $parentSlug
     * @return \Illuminate\Support\Collection
     */
    function get_footer_menus(string $parentSlug)
    {
        static $cache = [];

        if (! isset($cache[$parentSlug])) {

            $parent = Menu::where('slug', $parentSlug)
                ->where('is_active', 1)
                ->first();

            $cache[$parentSlug] = $parent
                ? $parent->children()
                    ->where('is_active', 1)
                    ->orderBy('display_order')
                    ->get()
                : collect();
        }

        return $cache[$parentSlug];
    }
}

