$(function() {

    var editor;
    KindEditor.ready(function(K) {
        editor = K.create('textarea.texteditor', {
            resizeType: 1,
            filterMode: false,//是否开启过滤模式
            allowPreviewEmoticons: false,
//            items: [
//                'source', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
//                'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
//                'insertunorderedlist', '|', 'emoticons', 'image', 'link']
        });
        editor.sync();
    });


});