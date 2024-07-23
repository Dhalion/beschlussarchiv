@push('head')
    <meta charset="utf-8">
    <title>Beschluss bearbeiten</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.0/ckeditor5.css">
@endpush

<div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Beschluss {{ "$resolution->tag-$resolution->year" }} bearbeiten</h2>
    <form wire:submit.prevent="update">
        <label for="title">Titel</label>
        <input type="text" wire:model="title" name="title" id="title">

        <label for="category">Kategorie</label>
        <select wire:model="category_id" name="category" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="tag">Tag</label>
        <input type="text" wire:model="tag" name="tag" id="tag">

        <label for="year">Jahr</label>
        <input type="text" wire:model="year" name="year" id="year">

        <label for="status">Status</label>
        <select wire:model="status" name="status" id="status">
            @foreach ($resolutionStates as $state)
                @php
                    /** @var App\Enums\ResolutionStatus $state */
                @endphp
                <option value="{{ $state }}">{{ $state }}</option>
            @endforeach
        </select>

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
