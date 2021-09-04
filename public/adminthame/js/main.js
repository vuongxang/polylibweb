$(document).ready(function () {
    $('#fileUploadForm').ajaxForm({
        beforeSend: function () {
            $(".spinner-border").css("display", "block");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            var percentage = percentComplete;
            $('.progress .progress-bar').css("width", percentage + '%', function () {
                return $(this).attr("aria-valuenow", percentage) + "%";
            })
        },
        error: function (response, status, e) {
            console.log(response.responseJSON.errors.pdf_file[0]);
            $("#error_pdf").css("display", "block");
            $('#error_pdf').html(response.responseJSON.errors.pdf_file[0]);
            $(".spinner-border").css("display", "none");
        },
        success: function(res) {
            $(".spinner-border").css("display", "none");
            $(".alert-success").css("display", "block");
            $("#error_pdf").css("display", "none");

            console.log('File has uploaded');
        },
        complete: function (xhr) {

        }
    });

    // var pusher = new Pusher('{{ env('
    //     PUSHER_APP_KEY ') }}', {
    //         cluster: "ap1"
    //     });
    // var channel = pusher.subscribe('NotificationEvent');
    // channel.bind('send-message', function(data) {

    //     console.log(data)
    //     console.log($('#abcccc'))

    // });

    $('#exampleModal').on('hide.bs.modal', function () {
        var image = $('input#image').val();
        $('img#show_img').attr('src', image)
    })

    $('#page_size').on('change', function () {
        $('#form-page-size').submit();
    })

    $('#total_day').on('change', function () {
        $('#form-page-size').submit();
    })
    $(function () {
        $('.toggle-class').change(function () {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            console.log(status, id)
            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'admin/cate/changeStatus',
                data: {
                    'status': status,
                    'id': id
                },
                success: function (data) {
                    console.log(data.success)
                }
            });
        })
    })

    $(function () {
        $('.toggle-class-book').change(function () {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'admin/book/changeStatus',
                data: {
                    'status': status,
                    'id': id
                },
                success: function (data) {
                    console.log(data.success)
                }
            });
        })
    })

    $(function () {
        $('.toggle-class-post-cate').change(function () {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: 'admin/post-cate/changeStatus',
                data: {
                    'status': status,
                    'id': id
                },
                success: function (data) {
                    console.log(data.success)
                }
            });
        })
    })
});

//     tinymce.init({
//       selector: 'textarea#exampleInputDesc',
//       plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
//       toolbar: 'responsivefilemanager link unlink anchor image media forecolor backcolor print preview code a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
//       toolbar_mode: 'floating',
//       tinycomments_mode: 'embedded',
//       tinycomments_author: 'Author name',
//             external_filemanager_path:"/filemanager/",
//         filemanager_title:"Responsive Filemanager" ,
//         external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
//    });


tinymce.init({
    selector: 'textarea#exampleInputDesc',
    plugins: 'print preview searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap emoticons',

    codesample_languages: [{
        text: 'HTML/XML',
        value: 'markup'
    },
    {
        text: 'JavaScript',
        value: 'javascript'
    },
    {
        text: 'CSS',
        value: 'css'
    },
    {
        text: 'PHP',
        value: 'php'
    },
    {
        text: 'Ruby',
        value: 'ruby'
    },
    {
        text: 'Python',
        value: 'python'
    },
    {
        text: 'Java',
        value: 'java'
    },
    {
        text: 'C',
        value: 'c'
    },
    {
        text: 'C#',
        value: 'csharp'
    },
    {
        text: 'C++',
        value: 'cpp'
    }
    ],
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',

    tinycomments_author: 'Author name',
    external_filemanager_path: "/filemanager/",
    filemanager_title: "Responsive Filemanager",
    external_plugins: {
        "filemanager": "/filemanager/plugin.min.js"
    },
    // templates: [
    //         { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
    //     { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
    //     { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
    // ],
    // template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    // template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    // height: 600,
    // image_caption: true,
    // quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    // noneditable_noneditable_class: 'mceNonEditable',
    // toolbar_mode: 'sliding',
    // spellchecker_ignore_list: ['Ephox', 'Moxiecode'],
    tinycomments_mode: 'embedded',
    // content_style: '.mymention{ color: gray; }',
    // contextmenu: 'link image imagetools table configurepermanentpen',
    // a11y_advanced_options: true
});