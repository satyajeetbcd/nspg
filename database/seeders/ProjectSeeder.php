<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Residential Solar Installation - Delhi',
                'description' => 'Complete 5kW rooftop solar system installation for a family home in South Delhi. This project includes high-efficiency monocrystalline panels, grid-tie inverter, and complete monitoring system.',
                'project_type' => 'residential',
                'location' => 'South Delhi, New Delhi',
                'capacity' => '5kW',
                'image_alt' => 'Residential solar installation in Delhi',
                'installation_date' => '2024-08-15',
                'cost' => 250000.00,
                'features' => [
                    'High-efficiency monocrystalline panels',
                    'Grid-tie inverter with monitoring',
                    'Complete electrical integration',
                    '5-year maintenance warranty',
                    'Real-time energy monitoring app'
                ],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Commercial Office Building - Mumbai',
                'description' => 'Large-scale 50kW commercial solar installation for a corporate office building in Mumbai. This project significantly reduced the building\'s electricity costs and carbon footprint.',
                'project_type' => 'commercial',
                'location' => 'Bandra Kurla Complex, Mumbai',
                'capacity' => '50kW',
                'image_alt' => 'Commercial solar installation in Mumbai',
                'installation_date' => '2024-07-20',
                'cost' => 2200000.00,
                'features' => [
                    '50kW polycrystalline panel array',
                    'Central inverter system',
                    'Net metering integration',
                    'Remote monitoring system',
                    '10-year performance warranty'
                ],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Industrial Manufacturing Plant - Pune',
                'description' => 'Massive 500kW ground-mounted solar farm for a manufacturing facility in Pune. This project provides clean energy for the entire production line and reduces operational costs significantly.',
                'project_type' => 'industrial',
                'location' => 'Pune Industrial Area, Maharashtra',
                'capacity' => '500kW',
                'image_alt' => 'Industrial solar farm in Pune',
                'installation_date' => '2024-06-10',
                'cost' => 20000000.00,
                'features' => [
                    '500kW ground-mounted array',
                    'Multiple string inverters',
                    'Advanced monitoring system',
                    'Grid synchronization',
                    '15-year comprehensive warranty'
                ],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'title' => 'Villa Solar System - Bangalore',
                'description' => 'Premium 8kW residential solar system for a luxury villa in Bangalore. Features the latest technology with battery backup for uninterrupted power supply.',
                'project_type' => 'residential',
                'location' => 'Whitefield, Bangalore',
                'capacity' => '8kW',
                'image_alt' => 'Luxury villa solar system in Bangalore',
                'installation_date' => '2024-09-05',
                'cost' => 450000.00,
                'features' => [
                    '8kW premium monocrystalline panels',
                    'Hybrid inverter with battery backup',
                    'Smart home integration',
                    'Mobile app control',
                    '7-year comprehensive warranty'
                ],
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'Hospital Solar Backup - Chennai',
                'description' => 'Critical power solution for a hospital in Chennai with 25kW solar system and battery backup to ensure uninterrupted medical services.',
                'project_type' => 'commercial',
                'location' => 'Anna Nagar, Chennai',
                'capacity' => '25kW',
                'image_alt' => 'Hospital solar backup system in Chennai',
                'installation_date' => '2024-05-18',
                'cost' => 1200000.00,
                'features' => [
                    '25kW high-efficiency panels',
                    'Battery backup system',
                    'UPS integration',
                    'Critical load management',
                    '24/7 monitoring system'
                ],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 5
            ],
            [
                'title' => 'School Solar Project - Hyderabad',
                'description' => 'Educational institution solar project providing clean energy for classrooms and computer labs. This project also serves as an educational tool for students.',
                'project_type' => 'commercial',
                'location' => 'Gachibowli, Hyderabad',
                'capacity' => '15kW',
                'image_alt' => 'School solar installation in Hyderabad',
                'installation_date' => '2024-04-22',
                'cost' => 750000.00,
                'features' => [
                    '15kW educational solar system',
                    'Student monitoring dashboard',
                    'Educational display panels',
                    'Grid-tie with net metering',
                    'Educational materials included'
                ],
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}