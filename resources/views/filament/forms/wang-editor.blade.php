@php
    $id = $getId();
    $statePath = $getStatePath();
    $mode = $getMode();
    $htmlId = str_replace(['.', '[]', '[', ']'], ['_', '', '_', ''], $id);
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div wire:ignore>
        <div id="{{ $htmlId }}" style="border: 1px solid #dbe3e6; border-radius: 4px;">
            <div id="{{ $htmlId }}-tb" style="border-bottom: 1px solid #dbe3e6;"></div>
            <div id="{{ $htmlId }}-ed" style="height: 500px;"></div>
        </div>
    </div>

    <input id="{{ $htmlId }}-h" type="hidden"
        x-data="{ v: $wire.$entangle('{{ $statePath }}') }"
        :value="v">

    <style>
        #{{ $htmlId }} .w-e-text-container { z-index: 10; }
        .we-code-btn {
            border: none;
            background: transparent;
            cursor: pointer;
            font-family: Inter, ui-sans-serif, system-ui, sans-serif;
            font-size: 14px;
            color: #595959;
            height: 40px;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 21px;
            min-width: 30px;
        }
        .we-code-btn:hover { background-color: #f0f0f0; }
        .we-code-textarea {
            width: 100%;
            min-height: 500px;
            padding: 12px;
            font-family: monospace;
            font-size: 13px;
            border: none;
            outline: none;
            resize: vertical;
            tab-size: 2;
            background: #fafafa;
            box-sizing: border-box;
        }
    </style>

    <link href="{{ asset('vendor/wangEditor5/style.css') }}" rel="stylesheet">
    <script src="{{ asset('vendor/wangEditor5/index.js') }}"></script>
    <script>
        (function() {
            var config = {
                placeholder: '请输入内容...',
                MENU_CONF: {},
                onChange: function(editor) {
                    var h = document.getElementById('{{ $htmlId }}-h');
                    var html = editor.getHtml();
                    if (h && h.value !== html) {
                        h.value = html;
                        h.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                },
            };

            function initEditor() {
                if (typeof window.wangEditor === 'undefined') { setTimeout(initEditor, 100); return; }
                if (document.getElementById('{{ $htmlId }}').__weDone) return;

                // 等待 Alpine Livewire 数据就绪
                var h = document.getElementById('{{ $htmlId }}-h');
                var alpineVal = '';
                if (h && h._x_dataStack) {
                    try { alpineVal = h._x_dataStack[0].v || ''; } catch(e) {}
                }
                if (!alpineVal && h) {
                    alpineVal = h.value || h.getAttribute('value') || '';
                }
                if (!alpineVal || alpineVal === '<p><br></p>') {
                    setTimeout(initEditor, 200);
                    return;
                }

                document.getElementById('{{ $htmlId }}').__weDone = true;
                var initialHtml = alpineVal;

                var { createEditor, createToolbar } = window.wangEditor;
                var editor = createEditor({
                    selector: '#{{ $htmlId }}-ed',
                    html: initialHtml,
                    config: config,
                    mode: '{{ $mode }}',
                });

                createToolbar({
                    editor: editor,
                    selector: '#{{ $htmlId }}-tb',
                    config: {},
                    mode: '{{ $mode }}',
                });

                // 原始码切换按钮（放在工具栏末尾）
                setTimeout(function() {
                    var tb = document.getElementById('{{ $htmlId }}-tb');
                    var bar = tb ? tb.querySelector('.w-e-bar') : null;
                    if (!bar || bar.querySelector('.we-code-btn')) return;
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'we-code-btn';
                    btn.title = '原始碼';
                    btn.textContent = '</>';
                    bar.appendChild(btn);

                    var codeMode = false, codeArea = null;

                    btn.addEventListener('click', function() {
                        codeMode = !codeMode;
                        if (codeMode) {
                            var html = editor.getHtml();
                            document.getElementById('{{ $htmlId }}-ed').style.display = 'none';
                            var ta = document.createElement('textarea');
                            ta.className = 'we-code-textarea';
                            ta.value = html;
                            document.getElementById('{{ $htmlId }}-ed').parentNode.insertBefore(ta, document.getElementById('{{ $htmlId }}-ed').nextSibling);
                            codeArea = ta;
                            ta.addEventListener('input', function() {
                                var h2 = document.getElementById('{{ $htmlId }}-h');
                                if (h2) h2.value = ta.value;
                            });
                        } else {
                            if (codeArea) {
                                editor.setHtml(codeArea.value);
                                codeArea.remove();
                                codeArea = null;
                            }
                            document.getElementById('{{ $htmlId }}-ed').style.display = '';
                        }
                    });
                }, 200);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initEditor);
            } else {
                initEditor();
            }
        })();
    </script>
</x-dynamic-component>