<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }}</title>
    <style>
        body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, sans-serif; }
    </style>
    <!-- Tambahkan CSS lain jika diperlukan untuk styling content -->
 </head>
<body>
    @php
        $raw = $page->content;
        $html = null;
        $css = null;
        $project = null;

        $findNested = function(array $arr, array $candidates) use (&$findNested) {
            // case-insensitive key search, depth-first
            foreach ($candidates as $cand) {
                foreach ($arr as $k => $v) {
                    if (is_string($k) && strcasecmp($k, $cand) === 0 && is_string($v)) {
                        return $v;
                    }
                }
            }
            foreach ($arr as $v) {
                if (is_array($v)) {
                    $found = $findNested($v, $candidates);
                    if ($found !== null) return $found;
                }
            }
            return null;
        };
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                // try common keys first, then nested search
                $html = $decoded['gjs-html'] ?? $decoded['html'] ?? $findNested($decoded, ['gjs-html','gjsHtml','html']);
                $css  = $decoded['gjs-css']  ?? $decoded['css']  ?? $findNested($decoded, ['gjs-css','gjsCss','css']);
                // detect grapesjs project data (components/styles) when html/css not present
                if ((empty($html) && empty($css)) && (
                    array_key_exists('gjs-components', $decoded) ||
                    array_key_exists('gjs-styles', $decoded) ||
                    array_key_exists('pages', $decoded)
                )) {
                    $project = $decoded;
                }
            } else {
                // if it looks like raw HTML, use it directly
                if (preg_match('/^\s*</', $raw) === 1) {
                    $html = $raw;
                }
            }
        }
    @endphp

    @if(!empty($html))
        @if(!empty($css))
            <style>{!! $css !!}</style>
        @endif
        {!! $html !!}
    @elseif($project)
        <div id="renderTarget"></div>
        <script src="{{ asset('grapesjs/js/grapes.min.js') }}"></script>
        <script>
            (function(){
                const project = @json($project);
                // Headless render: compute HTML+CSS from project data
                const editor = grapesjs.init({ headless: true });
                editor.loadProjectData(project);
                const html = editor.getHtml();
                const css = editor.getCss();
                const target = document.getElementById('renderTarget');
                const style = document.createElement('style');
                style.innerHTML = css || '';
                document.head.appendChild(style);
                target.innerHTML = html || '';
            })();
        </script>
    @else
        {!! $page->content !!}
    @endif
</body>
</html>
