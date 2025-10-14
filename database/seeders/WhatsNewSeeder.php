<?php

namespace Database\Seeders;

use App\Models\WhatsNew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WhatsNewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $whatsNewItems = [
            [
                'title' => 'New Solar Panel Technology Launch',
                'description' => 'We are excited to announce the launch of our latest high-efficiency solar panels with improved energy conversion rates and enhanced durability.',
                'hindi_description' => 'हम अपनी नवीनतम उच्च-दक्षता सोलर पैनल तकनीक के लॉन्च की घोषणा करते हैं जो बेहतर ऊर्जा रूपांतरण दर और बढ़ी हुई स्थायित्व के साथ आती है।',
                'publish_date' => now()->subDays(5),
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Solar Installation Service Expansion',
                'description' => 'NSPG is expanding its solar installation services to cover more regions across India, bringing clean energy solutions closer to you.',
                'hindi_description' => 'NSPG अपनी सोलर इंस्टॉलेशन सेवाओं का विस्तार कर रहा है ताकि भारत के अधिक क्षेत्रों को कवर किया जा सके और स्वच्छ ऊर्जा समाधान आपके करीब लाया जा सके।',
                'publish_date' => now()->subDays(3),
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Government Solar Subsidy Update',
                'description' => 'Latest updates on government solar subsidies and incentives. Learn how you can save more on your solar installation with current schemes.',
                'hindi_description' => 'सरकारी सोलर सब्सिडी और प्रोत्साहन पर नवीनतम अपडेट। जानें कि वर्तमान योजनाओं के साथ आप अपनी सोलर इंस्टॉलेशन पर कैसे अधिक बचत कर सकते हैं।',
                'publish_date' => now()->subDays(1),
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Customer Success Story: 50kW Installation',
                'description' => 'Read about our successful 50kW solar installation project for a manufacturing unit in Gujarat, showcasing significant energy savings.',
                'hindi_description' => 'गुजरात में एक विनिर्माण इकाई के लिए हमारी सफल 50kW सोलर इंस्टॉलेशन परियोजना के बारे में पढ़ें, जो महत्वपूर्ण ऊर्जा बचत को दर्शाती है।',
                'publish_date' => now()->subWeeks(1),
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Maintenance Service Package Launch',
                'description' => 'Introducing our comprehensive solar panel maintenance service package to ensure optimal performance and longevity of your solar system.',
                'hindi_description' => 'अपने सोलर सिस्टम के इष्टतम प्रदर्शन और दीर्घायु सुनिश्चित करने के लिए हमारे व्यापक सोलर पैनल रखरखाव सेवा पैकेज का परिचय।',
                'publish_date' => now()->subWeeks(2),
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($whatsNewItems as $item) {
            WhatsNew::create($item);
        }
    }
}
