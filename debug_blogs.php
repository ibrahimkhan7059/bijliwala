<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$blogs = \Illuminate\Support\Facades\DB::table('blogs')->select('id', 'title', 'thumbnail')->get();

foreach($blogs as $blog) {
    echo "ID: " . $blog->id . " | Title: " . $blog->title . " | Thumbnail: " . ($blog->thumbnail ?? 'NULL') . "\n";
}
