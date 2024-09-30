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
            <div class="flex gap-x-2 items-center">
                @if ($resolution->id)
                    <h2 class="text-2xl font-bold">Beschluss {{ "$resolution->tag-$resolution->year" }} bearbeiten</h2>
                    <x-icon name="o-eye" class="cursor-pointer w-6" wire:navigate
                        href="{{ route('frontend.resolution', $resolution) }}" />
                @else
                    <h2 class="text-2xl font-bold">Neuen Beschluss anlegen</h2>
                @endif
            </div>
            <x-button id="submit" type="submit" label="Beschluss Speichern" class="btn-primary text-white"
                spinner="update" />
        </div>

        <div id="form-content" class=" grid grid-cols-2 gap-3">


            <div class="col-span-2">
                <x-input type="text" label="Titel" wire:model="title" id="title" />
            </div>

            <x-select label="Kategorie" wire:model="categoryId" name="category" :options="$categories" id="category"
                option-label="tagged_name" option-value="id" />

            <div class="col-start-1 flex justify-between gap-x-3">
                <x-input type="text" label="Tag" wire:model="tag" name="tag" id="tag" class="w-1/2" />
                <x-input type="text" label="Jahr" wire:model="year" name="year" id="year" class="w-1/2" />
            </div>

            <x-select label="Status" wire:model="status" name="status" :options="$resolutionStates" id="status"
                option-value="value" />

            <div wire:ignore class="col-span-2 flex justify-center my-auto">
                {{-- loading spinner --}}
                <x-loading class="text-primary loading-lg self-center mt-10" id="editor-laoding-spinner" />
                <textarea id="editor" class="hidden"></textarea>
            </div>
        </div>


    </x-form>
    <x-toast />
</div>
@push('scripts')
    <script>
        function initializeCKEditor() {
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
            ClassicEditor
                .create(document.querySelector('#editor'), editorConfig)
                .then(() => {
                    document.querySelector('#editor-laoding-spinner').classList.add('hidden');
                    const editor = document.querySelector('#editor');
                    editor.classList.remove('hidden');
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js" onload="initializeCKEditor()"></script>
@endpush
