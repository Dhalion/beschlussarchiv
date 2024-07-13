@push('head')
    <meta charset="utf-8">
    <title>CKEditor 5 Samplesss</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endpush

<div>
    <h2>Beschluss {{ $resolution->id }} bearbeiten</h2>
    <form wire:submit.prevent="update">
        <div id="editor"></div>
        <button id="submit" type="submit">Save</button>
    </form>
</div>

@push('scripts')
    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.0/"
            }
        }
    </script>
    {{-- <script type="text/javascript" src="{{ URL::asset('assets/vendor/ckeditor.js') }}"></script> --}}
    <script type="module">
        import {
            ClassicEditor,
            Bold,
            Essentials,
            GeneralHtmlSupport,
            Italic,
            Link,
            ListProperties,
            Paragraph,
            SelectAll,
            Underline,
            Undo,
            Heading,
        } from "ckeditor5";

        const editorConfig = {
            toolbar: {
                items: [
                    "undo",
                    "redo",
                    "|",
                    "bold",
                    "italic",
                    "underline",
                    "|",
                    "heading",
                    "|",
                    "bulletedList",
                    "numberedList",
                ],
                shouldNotGroupWhenFull: false,
            },
            plugins: [
                Bold,
                Essentials,
                GeneralHtmlSupport,
                Italic,
                Link,
                ListProperties,
                Paragraph,
                SelectAll,
                Underline,
                Undo,
                Heading,
            ],
            initialData: {!! json_encode($resolution->text) !!},
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true,
                },
            },
            placeholder: "Type or paste your content here!",
        };

        ClassicEditor.create(document.querySelector("#editor"), editorConfig).then(
            (editor) => {
                window.editor = editor;
                document.querySelector("#submit").addEventListener("click", () => {
                    const editorData = editor.getData();
                    @this.set('editorContent', editorData);
                });
            }
        );

        // Assuming there is a <button id="submit">Submit</button> in your application.
    </script>
@endpush
