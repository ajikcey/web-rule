CKEDITOR.editorConfig = function (config) {
    config.toolbar_noticeToolbar1 = [
        {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
        {name: 'editing', items: ['Scayt']},
        {name: 'links', items: ['Link', 'Unlink']},
        {name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar', 'Iframe']},
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat', 'CopyFormatting']},
        {name: 'paragraph', items: ['NumberedList', 'BulletedList', "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv']},
        {name: 'colors', items: ['TextColor', 'BGColor']},
        {name: 'styles', items: ['Styles', 'Format']},
        {name: 'document', items: ['Source']},
        {name: 'tools', items: ['Maximize']}
    ];
    config.contentsCss = ['https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css'];
};