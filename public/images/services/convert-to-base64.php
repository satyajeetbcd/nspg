<?php
// Convert SVG files to base64 data URLs for better browser compatibility

$images = [
    'epc-services.svg',
    'solar-finance.svg', 
    'operations-maintenance.svg',
    'rooftop-solar.svg',
    'ground-mounted-solar.svg',
    'high-roi-solutions.svg'
];

echo "<h1>SVG to Base64 Converter</h1>\n";
echo "<p>Converting SVG files to base64 data URLs for better browser compatibility:</p>\n";

foreach ($images as $image) {
    $filePath = __DIR__ . '/' . $image;
    
    if (file_exists($filePath)) {
        $svgContent = file_get_contents($filePath);
        $base64 = base64_encode($svgContent);
        $dataUrl = 'data:image/svg+xml;base64,' . $base64;
        
        echo "<h3>$image</h3>\n";
        echo "<p>File size: " . filesize($filePath) . " bytes</p>\n";
        echo "<p>Base64 size: " . strlen($base64) . " bytes</p>\n";
        echo "<img src=\"$dataUrl\" style=\"max-width: 400px; height: 200px; border: 1px solid #ccc; margin: 10px 0;\">\n";
        echo "<hr>\n";
    } else {
        echo "<p style='color: red;'>File not found: $image</p>\n";
    }
}
?>
