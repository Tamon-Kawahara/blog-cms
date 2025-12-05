import "./bootstrap";

import EasyMDE from "easymde";
import "easymde/dist/easymde.min.css";

// Markdownエディタ初期化用（複数ページ対応）
window.initMarkdownEditor = function () {
    const targets = document.querySelectorAll("[data-markdown-editor]");
    if (!targets.length) return;

    targets.forEach((el) => {
        // 二重初期防止
        if (el.easyMDE) return;

        el.easyMDE = new EasyMDE({
            element: el,
            spellChecker: false,
            status: false,
            autofocus: false,
            toolbar: [
                "bold",
                "italic",
                "heading",
                "|",
                "quote",
                "unordered-list",
                "orderred-list",
                "|",
                "link",
                "image",
                "|",
                "preview",
                "side-by-side",
                "fullscreen",
                "|",
                "guide",
            ],
        });
    });
};

// ページ読み込み時に初期化
document.addEventListener("DOMContentLoaded", () => {
    window.initMarkdownEditor();
});

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
