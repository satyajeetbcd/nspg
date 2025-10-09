# NSPG Service Images

This directory contains solar panel focused images for the NSPG Services section on the home page.

## Current Images

- `epc-services.svg` - EPC Services with solar panel array and construction elements
- `solar-finance.svg` - Solar Finance Solutions with solar panels and financial tools
- `operations-maintenance.svg` - Operations & Maintenance with solar panels and maintenance equipment
- `rooftop-solar.svg` - Rooftop Solar Solutions with house and rooftop solar panels
- `ground-mounted-solar.svg` - Ground-Mounted Solar with large solar panel array and mounting structure
- `high-roi-solutions.svg` - High ROI Solutions with solar panels and growth charts

## Image Specifications

- **Format**: SVG (Scalable Vector Graphics)
- **Dimensions**: 400x200 pixels
- **Style**: Solar panel focused designs with gradient backgrounds
- **Theme**: All images feature realistic solar panel arrays and related equipment
- **Colors**: Each service has a unique color scheme while maintaining solar panel elements

## Solar Panel Features

Each image includes:
- **Realistic Solar Panel Arrays**: Detailed solar panel grids with proper spacing
- **Grid Lines**: White grid lines on panels for authenticity
- **Mounting Structures**: Appropriate mounting systems for each installation type
- **Service-Specific Elements**: Tools, equipment, and graphics relevant to each service
- **Professional Design**: Clean, modern appearance suitable for business use

## Usage

These images are used in the home page service cards section. They are automatically loaded using Laravel's `asset()` helper function.

## Customization

To replace these images with actual photos:

1. Create new images with the same dimensions (400x200px)
2. Save them as JPG or PNG format
3. Update the image sources in `resources/views/frontend/home.blade.php`
4. Change the file extensions from `.svg` to `.jpg` or `.png`

## Placeholder Generator

The `generate_placeholders.html` file can be used to generate new placeholder images with different colors and text.
