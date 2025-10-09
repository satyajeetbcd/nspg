<?php

namespace Database\Seeders\Tables;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Website settings - English
        Setting::setValue('website', 'title', 'Future ERP - Complete Business Management Solution', 'string', 'en');
        Setting::setValue('website', 'description', 'Future ERP provides comprehensive business management solutions including accounting, CRM, manufacturing, project management, HR, sales, and more. Streamline your business operations with our integrated platform.', 'string', 'en');
        Setting::setValue('website', 'keywords', 'ERP, business management, accounting, CRM, manufacturing, project management, HR, sales, inventory, Future ERP', 'string', 'en');

        // Website settings - Arabic
        Setting::setValue('website', 'title', 'مستقبل ERP - حل إدارة الأعمال الشامل', 'string', 'ar');
        Setting::setValue('website', 'description', 'يوفر Future ERP حلول شاملة لإدارة الأعمال تشمل المحاسبة وإدارة علاقات العملاء والتصنيع وإدارة المشاريع والموارد البشرية والمبيعات والمزيد. بسط عمليات عملك مع منصتنا المتكاملة.', 'string', 'ar');
        Setting::setValue('website', 'keywords', 'ERP، إدارة الأعمال، المحاسبة، إدارة علاقات العملاء، التصنيع، إدارة المشاريع، الموارد البشرية، المبيعات، المخزون، Future ERP', 'string', 'ar');

        // Discover features settings - English
        $discoverFeaturesEn = [
            "3" => [
                "discover_icon" => "fas fa-calculator",
                "discover_heading" => "Accounting",
                "discover_description" => "Future ERP accounting services enable you to manage your company's financial aspects with ease and efficiency. We offer comprehensive solutions that include tracking daily financial transactions and accurate financial analysis, helping you make financial decisions with confidence and better understand your business performance."
            ],
            "4" => [
                "discover_icon" => "fas fa-users",
                "discover_heading" => "Customer Relationship",
                "discover_description" => "Customer Relationship Services in Future ERP System aims to improve your interaction with your customers effectively. Through our platform, you can easily track and manage customer details, analyze their behavior and needs, which enables you to provide personalized services and build sustainable and strong relationships with them."
            ],
            "5" => [
                "discover_icon" => "fas fa-industry",
                "discover_heading" => "Manufacturing",
                "discover_description" => "Future ERP Manufacturing Services provides you with integrated solutions to efficiently manage all aspects of your manufacturing process. With our platform, you can easily organize your manufacturing operations, from inventory tracking and production management, to performance analytics to optimize your production processes and increase efficiency."
            ],
            "6" => [
                "discover_icon" => "fas fa-project-diagram",
                "discover_heading" => "Projects",
                "discover_description" => "Future ERP's shared project management services ensure that projects are organized and directed effectively. Through our platform, you can track project progress, plan resources, organize schedules, and assign tasks, helping you achieve goals efficiently and effectively."
            ],
            "7" => [
                "discover_icon" => "fas fa-user-tie",
                "discover_heading" => "Human Resources Management",
                "discover_description" => "HR management services in the Future ERP system help you organize and manage your work team efficiently. Through our platform, you can track personal information, skills and performance of employees, manage attendance and departure, and organize training processes, which enables you to improve human resource management and enhance the performance of your work team comprehensively."
            ],
            "8" => [
                "discover_icon" => "fas fa-chart-line",
                "discover_heading" => "Sales",
                "discover_description" => "Sales services in the Future ERP system aim to enhance marketing strategies and increase revenue. Through our platform, you can track sales processes, manage offers and contracts, and analyze data to understand sales performance and identify opportunities for improvement, enabling you to enhance sales strategies and achieve positive results."
            ],
            "9" => [
                "discover_icon" => "fas fa-warehouse",
                "discover_heading" => "Warehouses",
                "discover_description" => "Future ERP warehouse management services make it easy to track and manage inventory efficiently. With our platform, you can track inventory movement, manage warehouses, identify available stock and deliverables, and optimize your supply and distribution processes, helping you achieve greater warehouse management efficiency and improve supply chain performance."
            ],
            "10" => [
                "discover_icon" => "fas fa-dollar-sign",
                "discover_heading" => "Costs and Pricing",
                "discover_description" => "Future ERP cost management and pricing services help you analyze costs and set prices effectively. Through our platform, you can track costs related to production, marketing and distribution, and analyze data to determine effective pricing strategies and achieve the desired profitability. You can also generate quotes and manage sales processes easily, helping you achieve sustainable financial success and achieve your business goals."
            ],
            "11" => [
                "discover_icon" => "fas fa-shopping-cart",
                "discover_heading" => "Purchases",
                "discover_description" => "Purchasing management services in the Future ERP system facilitate the process of purchasing materials and products efficiently. Through our platform, you can track purchasing needs, manage suppliers, track orders and inventory, and organize purchasing operations efficiently. You can also analyze financial data related to purchasing to make informed decisions and achieve cost savings."
            ],
            "12" => [
                "discover_icon" => "fas fa-robot",
                "discover_heading" => "Artificial Intelligence",
                "discover_description" => "Artificial Intelligence Services in Future ERP System provides innovative and intelligent solutions for data analysis and decision making. By applying AI technologies, we provide you with advanced analytics that help analyze big data, predict trends, and improve your business performance."
            ],
            "13" => [
                "discover_icon" => "fas fa-bullhorn",
                "discover_heading" => "Marketing",
                "discover_description" => "Marketing services in the Future ERP system help you develop effective marketing strategies for the success of your business. Through our platform, you can manage digital marketing campaigns, analyze campaign performance, and implement marketing strategies across social media, email, and websites, enabling you to reach a wider audience and increase your sales effectively."
            ],
            "14" => [
                "discover_icon" => "fas fa-tachometer-alt",
                "discover_heading" => "Productivity Services",
                "discover_description" => "Future ERP productivity services help you improve your work efficiency and increase your productivity. Through our platform, you can analyze and optimize production processes, organize schedules, track performance, and optimize resource utilization. We also provide advanced technology solutions that enhance communication and collaboration between teams, enabling you to achieve better results and significantly increase productivity."
            ]
        ];

        // Discover features settings - Arabic
        $discoverFeaturesAr = [
            "3" => [
                "discover_icon" => "fas fa-calculator",
                "discover_heading" => "المحاسبة",
                "discover_description" => "خدمات المحاسبة في Future ERP تمكنك من إدارة الجوانب المالية لشركتك بسهولة وكفاءة. نقدم حلول شاملة تشمل تتبع المعاملات المالية اليومية والتحليل المالي الدقيق، مما يساعدك على اتخاذ القرارات المالية بثقة وفهم أفضل لأداء عملك."
            ],
            "4" => [
                "discover_icon" => "fas fa-users",
                "discover_heading" => "إدارة علاقات العملاء",
                "discover_description" => "تهدف خدمات إدارة علاقات العملاء في نظام Future ERP إلى تحسين تفاعلك مع عملائك بفعالية. من خلال منصتنا، يمكنك بسهولة تتبع وإدارة تفاصيل العملاء، وتحليل سلوكهم واحتياجاتهم، مما يمكنك من تقديم خدمات مخصصة وبناء علاقات مستدامة وقوية معهم."
            ],
            "5" => [
                "discover_icon" => "fas fa-industry",
                "discover_heading" => "التصنيع",
                "discover_description" => "خدمات التصنيع في Future ERP توفر لك حلول متكاملة لإدارة جميع جوانب عملية التصنيع بكفاءة. من خلال منصتنا، يمكنك بسهولة تنظيم عمليات التصنيع، من تتبع المخزون وإدارة الإنتاج، إلى تحليلات الأداء لتحسين عمليات الإنتاج وزيادة الكفاءة."
            ],
            "6" => [
                "discover_icon" => "fas fa-project-diagram",
                "discover_heading" => "المشاريع",
                "discover_description" => "خدمات إدارة المشاريع المشتركة في Future ERP تضمن تنظيم وتوجيه المشاريع بفعالية. من خلال منصتنا، يمكنك تتبع تقدم المشروع، وتخطيط الموارد، وتنظيم الجداول الزمنية، وتكليف المهام، مما يساعدك على تحقيق الأهداف بكفاءة وفعالية."
            ],
            "7" => [
                "discover_icon" => "fas fa-user-tie",
                "discover_heading" => "إدارة الموارد البشرية",
                "discover_description" => "خدمات إدارة الموارد البشرية في نظام Future ERP تساعدك على تنظيم وإدارة فريق عملك بكفاءة. من خلال منصتنا، يمكنك تتبع المعلومات الشخصية والمهارات وأداء الموظفين، وإدارة الحضور والانصراف، وتنظيم عمليات التدريب، مما يمكنك من تحسين إدارة الموارد البشرية وتعزيز أداء فريق عملك بشكل شامل."
            ],
            "8" => [
                "discover_icon" => "fas fa-chart-line",
                "discover_heading" => "المبيعات",
                "discover_description" => "تهدف خدمات المبيعات في نظام Future ERP إلى تعزيز استراتيجيات التسويق وزيادة الإيرادات. من خلال منصتنا، يمكنك تتبع عمليات المبيعات، وإدارة العروض والعقود، وتحليل البيانات لفهم أداء المبيعات وتحديد فرص التحسين، مما يمكنك من تعزيز استراتيجيات المبيعات وتحقيق نتائج إيجابية."
            ],
            "9" => [
                "discover_icon" => "fas fa-warehouse",
                "discover_heading" => "المستودعات",
                "discover_description" => "خدمات إدارة المستودعات في Future ERP تجعل من السهل تتبع وإدارة المخزون بكفاءة. مع منصتنا، يمكنك تتبع حركة المخزون، وإدارة المستودعات، وتحديد المخزون المتاح والسلع القابلة للتسليم، وتحسين عمليات التوريد والتوزيع، مما يساعدك على تحقيق كفاءة أكبر في إدارة المستودعات وتحسين أداء سلسلة التوريد."
            ],
            "10" => [
                "discover_icon" => "fas fa-dollar-sign",
                "discover_heading" => "التكاليف والتسعير",
                "discover_description" => "خدمات إدارة التكاليف والتسعير في Future ERP تساعدك على تحليل التكاليف وتحديد الأسعار بفعالية. من خلال منصتنا، يمكنك تتبع التكاليف المتعلقة بالإنتاج والتسويق والتوزيع، وتحليل البيانات لتحديد استراتيجيات التسعير الفعالة وتحقيق الربحية المطلوبة. يمكنك أيضًا إنشاء عروض أسعار وإدارة عمليات المبيعات بسهولة، مما يساعدك على تحقيق النجاح المالي المستدام وتحقيق أهداف عملك."
            ],
            "11" => [
                "discover_icon" => "fas fa-shopping-cart",
                "discover_heading" => "المشتريات",
                "discover_description" => "خدمات إدارة المشتريات في نظام Future ERP تسهل عملية شراء المواد والمنتجات بكفاءة. من خلال منصتنا، يمكنك تتبع احتياجات الشراء، وإدارة الموردين، وتتبع الطلبات والمخزون، وتنظيم عمليات الشراء بكفاءة. يمكنك أيضًا تحليل البيانات المالية المتعلقة بالمشتريات لاتخاذ قرارات مدروسة وتحقيق توفير في التكاليف."
            ],
            "12" => [
                "discover_icon" => "fas fa-robot",
                "discover_heading" => "الذكاء الاصطناعي",
                "discover_description" => "خدمات الذكاء الاصطناعي في نظام Future ERP توفر حلول مبتكرة وذكية لتحليل البيانات واتخاذ القرارات. من خلال تطبيق تقنيات الذكاء الاصطناعي، نقدم لك تحليلات متقدمة تساعد في تحليل البيانات الضخمة والتنبؤ بالاتجاهات وتحسين أداء عملك."
            ],
            "13" => [
                "discover_icon" => "fas fa-bullhorn",
                "discover_heading" => "التسويق",
                "discover_description" => "خدمات التسويق في نظام Future ERP تساعدك على تطوير استراتيجيات تسويقية فعالة لنجاح عملك. من خلال منصتنا، يمكنك إدارة الحملات التسويقية الرقمية، وتحليل أداء الحملات، وتنفيذ استراتيجيات التسويق عبر وسائل التواصل الاجتماعي والبريد الإلكتروني والمواقع الإلكترونية، مما يمكنك من الوصول إلى جمهور أوسع وزيادة مبيعاتك بفعالية."
            ],
            "14" => [
                "discover_icon" => "fas fa-tachometer-alt",
                "discover_heading" => "خدمات الإنتاجية",
                "discover_description" => "خدمات الإنتاجية في Future ERP تساعدك على تحسين كفاءة عملك وزيادة إنتاجيتك. من خلال منصتنا، يمكنك تحليل وتحسين عمليات الإنتاج، وتنظيم الجداول الزمنية، وتتبع الأداء، وتحسين استخدام الموارد. نقدم أيضًا حلول تكنولوجية متقدمة تعزز التواصل والتعاون بين الفرق، مما يمكنك من تحقيق نتائج أفضل وزيادة الإنتاجية بشكل كبير."
            ]
        ];

        Setting::setValue('features', 'discover_of_features', $discoverFeaturesEn, 'json', 'en');
        Setting::setValue('features', 'discover_of_features', $discoverFeaturesAr, 'json', 'ar');

        // Generic settings (shared across all languages) - language_code = null
        Setting::setValue('website', 'logo', 'logo.png', 'string', null);
        Setting::setValue('website', 'favicon', 'favicon.ico', 'string', null);
        Setting::setValue('website', 'contact_email', 'info@futureerp.com', 'string', null);
        Setting::setValue('website', 'contact_phone', '+1-555-0123', 'string', null);
        Setting::setValue('website', 'address', '123 Business Street, City, Country', 'string', null);

        // Social media settings are generic (shared across all languages)
        $socialMediaLinks = [
            [
                'platform' => 'facebook',
                'url' => 'https://www.facebook.com/share/18Li5Y5Lsm/',
                'icon' => 'fab fa-facebook-f'
            ],
            [
                'platform' => 'instagram',
                'url' => 'https://www.instagram.com/thefuture.erp/?fbclid=IwY2xjawJSK-FleHRuA2FlbQIxMAABHW7Yl0-LjkHzElU5BqkfrgnrXdMf6RD_3rYZkptQY9ebxTWusfeEWncNcw_aem_vQeigHzKAW77A7qACHJdqA#',
                'icon' => 'fab fa-instagram'
            ],
            [
                'platform' => 'youtube',
                'url' => 'https://www.youtube.com/@TheFuture-ERP',
                'icon' => 'fab fa-youtube'
            ],
            [
                'platform' => 'tiktok',
                'url' => 'https://www.tiktok.com/@thefuture.erp?fbclid=IwY2xjawJSK75leHRuA2FlbQIxMAABHWFEuDHgWp1y4_dQpb7eiB4cmWZbs65YMVm8GEWDC9UtaREPBPHU1NsZGQ_aem_aA3ZdZZSH_Y9-_HLY65hKQ',
                'icon' => 'fab fa-tiktok'
            ],
            [
                'platform' => 'twitter',
                'url' => 'https://x.com/ThefutureErp',
                'icon' => 'fab fa-twitter'
            ],
            [
                'platform' => 'whatsapp',
                'url' => 'https://wa.me/201023068425',
                'icon' => 'fab fa-whatsapp'
            ]
        ];

        Setting::setValue('website', 'social_media_links', $socialMediaLinks, 'json', null);

        // Contact information settings (generic - shared across all languages)
        $contactInfo = [
            'phones' => [
                [
                    'country' => 'EGYPT',
                    'phone' => '+201023068425'
                ],
                [
                    'country' => 'Saudi Arabia',
                    'phone' => '+966508060608'
                ],
                [
                    'country' => 'Emirates',
                    'phone' => '+971506058635'
                ],
                [
                    'country' => 'Morroco',
                    'phone' => '+212680080175'
                ]
            ],
            'emails' => [
                'info@thefuture-erp.com',
                'info@hololtec.com'
            ],
            'addresses' => [
                'en' => [
                    'Egypt - Cairo - Qalyubia - El-Gomhoria st',
                    'Alexandria - almandara'
                ],
                'ar' => [
                    'مصر - القاهرة - القليوبية - شارع الجمهورية',
                    'الإسكندرية - المندرة'
                ]
            ]
        ];

        Setting::setValue('website', 'contact_info', $contactInfo, 'json', null);
    }
}
