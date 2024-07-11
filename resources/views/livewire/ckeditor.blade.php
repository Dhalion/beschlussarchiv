<div>
    @push('head')
        <meta charset="utf-8">
        <title>CKEditor 5 Samplesss</title>
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
    @endpush

    <div class="main-container">
        <div class="editor-container editor-container_classic-editor" id="editor-container">
            <div class="editor-container__editor">
                <div id="editor"></div>
            </div>
        </div>
    </div>
    <button id="submit">Save</button>

    @push('scripts')
        <script type="importmap">
            {
                "imports": {
                    "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                    "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
                }
            }
		</script>
        <script type="module" src="{{ URL::asset('assets/vendor/ckeditor.js') }}"></script>
    @endpush
</div>
