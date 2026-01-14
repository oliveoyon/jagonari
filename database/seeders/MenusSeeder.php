<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusSeeder extends Seeder
{
    public function run()
    {
        // Clear previous data
        Menu::truncate();

        // Helper function to create menu with English slug
        $createMenu = function ($title, $slug, $parent_id = null) {
            return Menu::create([
                'title' => $title,
                'slug' => $slug,
                'parent_id' => $parent_id,
                'content' => null,
                'main_image' => null,
                'display_order' => 0,
                'is_active' => true,
            ]);
        };

        // ==== Main Menus ====
        $home = $createMenu('হোম', 'home');
        $aboutUs = $createMenu('আমাদের সম্পর্কে', 'about-us');
        $programs = $createMenu('প্রোগ্রামসমূহ', 'programs');
        $resources = $createMenu('রিসোর্স', 'resources');
        $whereWeWork = $createMenu('আমরা কোথায় কাজ করি', 'where-we-work');

        // ==== Home Submenus ====
        $createMenu('হাইলাইটস', 'highlights', $home->id);
        $createMenu('দ্রুত লিঙ্ক: “দান করুন”, “আমাদের সাথে যুক্ত হোন”', 'quick-links', $home->id);

        // ==== About Us Submenus ====
        $createMenu('লক্ষ্য, দর্শন ও মূল্যবোধ', 'mission-vision-values', $aboutUs->id);
        $createMenu('আমাদের ইতিহাস', 'our-history', $aboutUs->id);
        $createMenu('আইনগত অবস্থা', 'legal-status', $aboutUs->id);
        $createMenu('পরিচালনা দল', 'management-team', $aboutUs->id);
        $createMenu('পরামর্শদাতা ও নির্বাহী কমিটি', 'advisory-executive-committees', $aboutUs->id);
        $createMenu('কার্যক্রম এলাকা ও কাভারেজ মানচিত্র', 'working-areas-map', $aboutUs->id);
        $createMenu('আমাদের নেটওয়ার্ক ও অংশীদারিত্ব', 'networks-partnerships', $aboutUs->id);

        // ==== Programs Submenus ====
        $createMenu('পশুপালনের টিকা ও সচেতনতা কর্মসূচি', 'livestock-vaccination', $programs->id);
        $createMenu('প্রাথমিক পশুস্বাস্থ্য উদ্যোগ', 'primary-animal-health', $programs->id);
        $createMenu('কৃষক প্রশিক্ষণ ও উদ্যোক্তা উন্নয়ন', 'farmer-training', $programs->id);
        $createMenu('সম্পন্ন প্রকল্পসমূহ', 'completed-projects', $programs->id);
        $createMenu('বিষয়ভিত্তিক এলাকা (স্বাস্থ্য, কৃষি, জীবিকা ইত্যাদি)', 'thematic-areas', $programs->id);
        $createMenu('স্বেচ্ছাসেবক কার্যক্রম', 'volunteer-activities', $programs->id);
        $createMenu('ফেলোশিপ / গবেষণা সুযোগ', 'fellowship-research', $programs->id);
        $createMenu('চাকরির সুযোগ', 'job-opportunities', $programs->id);
        $createMenu('দরপত্র / টেন্ডার', 'tenders', $programs->id);

        // ==== Resources Submenus ====
        $createMenu('বার্ষিক প্রতিবেদন', 'annual-reports', $resources->id);
        $createMenu('প্রকাশনা ও গবেষণা', 'publications-research', $resources->id);
        $createMenu('ছবি ও ভিডিও গ্যালারি', 'gallery', $resources->id);

        // ==== Where We Work Submenus ====
        $createMenu('জেলা অনুযায়ী পেজ (ছবি, প্রভাবের তথ্য, স্থানীয় যোগাযোগের তথ্যসহ)', 'district-pages', $whereWeWork->id);
    }
}
