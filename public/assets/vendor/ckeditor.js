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
    ],
    initialData: $wire?.resolution?.text ?? "Loading...",
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
    }
);

// Assuming there is a <button id="submit">Submit</button> in your application.
document.querySelector("#submit").addEventListener("click", () => {
    const editorData = window.editor.getData();

    console.log(editorData);
    // ...
});
