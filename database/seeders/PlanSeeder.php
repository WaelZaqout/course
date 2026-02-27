<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 خطط المعلمين
        Plan::updateOrCreate(
            ['title' => 'الباقة الأساسية', 'audience' => 'teacher'],
            [
                'billing_period'  => 'monthly',
                'price'           => 500,
                'currency'        => 'SAR',
                'features'        => [
                    '10 فيديوهات',
                    '20 ملف',
                    'إحصائيات أساسية',
                    'دعم عبر البريد الإلكتروني'
                ],
                'is_active'       => true,
                'max_videos'      => 10,
                'max_courses'     => 2,
                'max_files'       => 20,
                'stripe_price_id' => 'price_1T5XR4AajKPiV5QnNyJ6iP4V',
            ]
        );

        Plan::updateOrCreate(
            ['title' => 'الباقة المتوسطة', 'audience' => 'teacher'],
            [
                'billing_period'  => 'monthly',
                'price'           => 800,
                'currency'        => 'SAR',
                'features'        => [
                    '25 فيديو',
                    '50 ملف',
                    'إحصائيات متقدمة',
                    'دعم فوري'
                ],
                'is_active'       => true,
                'max_videos'      => 25,
                'max_courses'     => 5,
                'max_files'       => 50,
                'stripe_price_id' => 'price_1T5XdYAajKPiV5Qn6peDzGAt',
            ]
        );

        Plan::updateOrCreate(
            ['title' => 'الباقة المتميزة', 'audience' => 'teacher'],
            [
                'billing_period'  => 'monthly',
                'price'           => 1200,
                'currency'        => 'SAR',
                'features'        => [
                    '50 فيديو',
                    '100 ملف',
                    'إحصائيات كاملة',
                    'دعم مميز'
                ],
                'is_active'       => true,
                'max_videos'      => 50,
                'max_courses'     => 10,
                'max_files'       => 100,
                'stripe_price_id' => 'price_1T5XdtAajKPiV5QnyT9OWBQp',
            ]
        );

        // // 🔹 خطط الطلاب
        // Plan::updateOrCreate(
        //     ['title' => 'الباقة الأساسية', 'audience' => 'student'],
        //     [
        //         'billing_period'  => 'monthly',
        //         'price'           => 300,
        //         'currency'        => 'SAR',
        //         'features'        => [
        //             '5 فيديوهات',
        //             '10 ملفات تعليمية',
        //             'متابعة أساسية'
        //         ],
        //         'is_active'       => true,
        //         'max_videos'      => 5,
        //         'max_courses'     => 1,
        //         'max_files'       => 10,
        //         'stripe_price_id' => 'price_1S3eM9CuR5oL6l4VPGIjt9OK',
        //     ]
        // );

        // Plan::updateOrCreate(
        //     ['title' => 'الباقة المتوسطة', 'audience' => 'student'],
        //     [
        //         'billing_period'  => 'monthly',
        //         'price'           => 600,
        //         'currency'        => 'SAR',
        //         'features'        => [
        //             '15 فيديو',
        //             '30 ملف تعليمي',
        //             'دعم عبر البريد'
        //         ],
        //         'is_active'       => true,
        //         'max_videos'      => 15,
        //         'max_courses'     => 3,
        //         'max_files'       => 30,
        //         'stripe_price_id' => 'price_XXX_medium_student',
        //     ]
        // );

        // Plan::updateOrCreate(
        //     ['title' => 'الباقة المتميزة', 'audience' => 'student'],
        //     [
        //         'billing_period'  => 'monthly',
        //         'price'           => 900,
        //         'currency'        => 'SAR',
        //         'features'        => [
        //             '25 فيديو',
        //             '50 ملف تعليمي',
        //             'اختبارات تقييمية',
        //             'دعم كامل'
        //         ],
        //         'is_active'       => true,
        //         'max_videos'      => 25,
        //         'max_courses'     => 5,
        //         'max_files'       => 50,
        //         'stripe_price_id' => 'price_XXX_premium_student',
        //     ]
        // );
    }
}
