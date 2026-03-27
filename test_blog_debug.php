<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Blog;

$blogs = Blog::all();
echo "Total blogs: " . count($blogs) . PHP_EOL;
echo "================================" . PHP_EOL;

foreach($blogs as $blog) {
    echo "Blog ID: " . $blog->id . PHP_EOL;
    echo "Title: " . $blog->title . PHP_EOL;
    echo "Thumbnail (raw): " . ($blog->thumbnail ?? 'NULL') . PHP_EOL;
    echo "Thumbnail URL (accessor): " . ($blog->thumbnail_url ?? 'NULL') . PHP_EOL;
    echo "--------------------------------" . PHP_EOL;
}
?>
