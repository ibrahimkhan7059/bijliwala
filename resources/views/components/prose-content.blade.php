@props(['content'])

{{-- Prose Content Component for displaying formatted HTML content --}}
<div class="blog-content">
    <style>
        .blog-content {
            font-size: 1.125rem;
            line-height: 1.75;
            color: #374151;
        }
        .blog-content p {
            margin-bottom: 1.25rem;
            line-height: 1.75;
        }
        .blog-content ul, .blog-content ol {
            margin-bottom: 1.25rem;
            padding-left: 2rem;
        }
        .blog-content ul {
            list-style-type: disc;
        }
        .blog-content ol {
            list-style-type: decimal;
        }
        .blog-content li {
            margin-bottom: 0.5rem;
            line-height: 1.75;
        }
        .blog-content h1 {
            font-size: 2.25rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 1rem;
            margin-top: 2rem;
        }
        .blog-content h2 {
            font-size: 1.875rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 0.75rem;
            margin-top: 1.5rem;
        }
        .blog-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #111827;
            margin-bottom: 0.5rem;
            margin-top: 1.25rem;
        }
        .blog-content strong {
            font-weight: 600;
            color: #111827;
        }
        .blog-content em {
            font-style: italic;
        }
        .blog-content a {
            color: #dc2626;
            text-decoration: none;
        }
        .blog-content a:hover {
            text-decoration: underline;
        }
        .blog-content br {
            display: block;
            content: "";
            margin-top: 0.5rem;
        }
    </style>
    {!! $content !!}
</div>
