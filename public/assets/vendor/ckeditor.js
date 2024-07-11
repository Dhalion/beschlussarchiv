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
    initialData:
        '<h2>Congratulations on setting up CKEditor 5! 🎉</h2>\n<p>\n    You\'ve successfully created a CKEditor 5 project. This powerful text editor will enhance your application, enabling rich text editing\n    capabilities that are customizable and easy to use.\n</p>\n<h3>What\'s next?</h3>\n<ol>\n    <li>\n        <strong>Integrate into your app</strong>: time to bring the editing into your application. Take the code you created and add to your\n        application.\n    </li>\n    <li>\n        <strong>Explore features:</strong> Experiment with different plugins and toolbar options to discover what works best for your needs.\n    </li>\n    <li>\n        <strong>Customize your editor:</strong> Tailor the editor\'s configuration to match your application\'s style and requirements. Or even\n        write your plugin!\n    </li>\n</ol>\n<p>\n    Keep experimenting, and don\'t hesitate to push the boundaries of what you can achieve with CKEditor 5. Your feedback is invaluable to us\n    as we strive to improve and evolve. Happy editing!\n</p>\n<h3>Helpful resources</h3>\n<ul>\n    <li>📝 <a href="https://orders.ckeditor.com/trial/premium-features">Trial sign up</a>,</li>\n    <li>📕 <a href="https://ckeditor.com/docs/ckeditor5/latest/installation/index.html">Documentation</a>,</li>\n    <li>⭐️ <a href="https://github.com/ckeditor/ckeditor5">GitHub</a> (star us if you can!),</li>\n    <li>🏠 <a href="https://ckeditor.com">CKEditor Homepage</a>,</li>\n    <li>🧑‍💻 <a href="https://ckeditor.com/ckeditor-5/demo/">CKEditor 5 Demos</a>,</li>\n</ul>\n<h3>Need help?</h3>\n<p>\n    See this text, but the editor is not starting up? Check the browser\'s console for clues and guidance. It may be related to an incorrect\n    license key if you use premium features or another feature-related requirement. If you cannot make it work, file a GitHub issue, and we\n    will help as soon as possible!\n</p>\n',

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
