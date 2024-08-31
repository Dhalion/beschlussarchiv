@push('head')
    <meta charset="utf-8">
    <title>Beschluss bearbeiten</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
@endpush

<div class="p-4">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif



    <x-form wire:submit.prevent="update">
        <div id="heading" class="flex justify-between">
            <h2 class="text-2xl font-bold">Beschluss {{ "$resolution->tag-$resolution->year" }} bearbeiten</h2>
            <x-button id="submit" type="submit" label="Beschluss Speichern" class="btn-primary text-white"
                spinner="update" />
        </div>

        <div id="form-content" class=" grid grid-cols-2 gap-3">


            <div class="col-span-2">
                <x-input type="text" label="Titel" wire:model="title" id="title" />
            </div>

            <x-select label="Kategorie" wire:model="category_id" name="category" :options="$categories" id="category"
                option-label="tagged_name">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </x-select>

            <div class="col-start-1 flex justify-between">
                <x-input type="text" label="Tag" wire:model="tag" name="tag" id="tag" />
                <x-input type="text" label="Jahr" wire:model="year" name="year" id="year" />
            </div>

            <x-select label="Status" wire:model="status" name="status" :options="$resolutionStates" id="status">
                @foreach ($resolutionStates as $state)
                    @php
                        /** @var App\Enums\ResolutionStatus $state */
                    @endphp
                    <option value="{{ $state }}">{{ $state }}</option>
                @endforeach
            </x-select>

            <div wire:ignore class="col-span-2">
                <textarea id="editor"></textarea>
            </div>
        </div>


    </x-form>
    <x-toast />
</div>
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script type="module">
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
            initialData: {!! json_encode($resolution->text) !!},
            list: {
                properties: {
                    styles: true,
                    startIndex: true,
                    reversed: true,
                },
            },
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
    </script>
@endpush
