    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('adminthame/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminthame/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('adminthame/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('adminthame/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('adminthame/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('adminthame/js/chart/chart-area.js') }}"></script>
    <script src="{{ asset('adminthame/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/hmuw3s2zqh2hz2ctu3t8rxpvxh61d6ci6pkldvwxndprwi2a/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <!-- Pusher -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        CKEDITOR.replace('editor1');
    </script>
    <script>
        $(document).ready(function() {
            $('#fileUploadForm').ajaxForm({
                beforeSend: function() {
                    $("#progress").css("display", "block");
                    var percentage = '0';
                },
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentage = percentComplete;
                    $('.progress .progress-bar').css("width", percentage + '%', function() {
                        return $(this).attr("aria-valuenow", percentage) + "%";
                    })
                },
                error: function(response, status, e) {
                    alert('Oops something went.');
                },
                complete: function(xhr) {
                    $("#progress-arlert").css("display", "block");

                    console.log('File has uploaded');
                }
            });

            var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
                cluster: "ap1"
            });
            var channel = pusher.subscribe('NotificationEvent');
            channel.bind('send-message', function(data) {

                console.log(data)
                console.log($('#abcccc'))

            });


            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount: 5,
                searchResultLimit: 5,
                renderChoiceLimit: 5
            });


            $('#exampleModal').on('hide.bs.modal', function() {
                var image = $('input#image').val();
                $('img#show_img').attr('src', image)
            })

            $('#image_gallery').on('hide.bs.modal', function() {
                var image_list = $('input#list_image').val();
                if (image_list.length > 0) {
                    if (/^[\],:{}\s]*$/.test(image_list.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                                /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                            .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                        var image_gallery = $.parseJSON(image_list);
                        console.log(image_gallery);
                        var html = '';
                        image_gallery.forEach((item, index) => {
                            html +=
                                `<img src="${item}" id="show_list_image" width="50" class="img-thumbnail">`;
                        });
                        console.log(html);
                        $('.img-gallery').html(html);
                    } else {
                        html =
                            `<img src="${image_list}" id="show_list_image" width="50" class="img-thumbnail">`;
                        $('.img-gallery').html(html);
                    }
                }

            })

            $('#audio_gallery').on('hide.bs.modal', function() {
                var audio_list = $('input#list_audio').val();
                if (audio_list.length) {
                    if (/^[\],:{}\s]*$/.test(audio_list.replace(/\\["\\\/bfnrtu]/g, '@').replace(
                                /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                            .replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {
                        var audio_gallery = $.parseJSON(audio_list);
                        var html = '';
                        audio_gallery.forEach((item, index) => {
                            console.log(item);
                            html +=
                                `<audio src="${item}" id="show_list_audio" controls>
                                Trình duyệt không hỗ trợ phát âm thanh
                                </audio></br>`;
                        });
                        $('.audio-gallery').html(html);
                    } else {
                        console.log(audio_list);
                        html = `<audio src="${audio_list}" id="show_list_audio" controls>
                        Trình duyệt không hỗ trợ phát âm thanh
                        </audio>`;
                        $('.audio-gallery').html(html);
                    }
                }
            })
            
            $(function() {
                $('.toggle-class').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var id = $(this).data('id');

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: 'cate/changeStatus',
                        data: {
                            'status': status,
                            'id': id
                        },
                        success: function(data) {
                            console.log(data.success)
                        }
                    });
                })
            })

            $(function() {
                $('.toggle-class-book').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var id = $(this).data('id');

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: 'book/changeStatus',
                        data: {
                            'status': status,
                            'id': id
                        },
                        success: function(data) {
                            console.log(data.success)
                        }
                    });
                })
            })

            $(function() {
                $('.toggle-class-post-cate').change(function() {
                    var status = $(this).prop('checked') == true ? 1 : 0;
                    var id = $(this).data('id');

                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: 'post-cate/changeStatus',
                        data: {
                            'status': status,
                            'id': id
                        },
                        success: function(data) {
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
            plugins: 'print preview tinydrive searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',

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

        $('#page_size').change(function() {
            var pagesize = $(this).val();
            $('#form-page-size').submit();
            // $.ajax({
            //     type: "GET",
            //     dataType: "json",
            //     url: 'author/changePageSize',
            //     data: {
            //         'pagesize': pagesize,
            //     },
            //     success: function(data) {
            //         console.log(data.authors.data);
            //         let result = data.authors.data.map(item =>{
            //             return `
        //             <tr>
        //                 <td>${item.id}</td>
        //                 <td>${item.name}</td>
        //                 <td>
        //                     <img src="${item.avatar}" alt="" width="50">
        //                 </td>
        //                 <td>
        //                     ${item.date_birth}
        //                 </td>
        //                 <td>
        //                     <div class="text-center">
        //                         
        //                     </div>
        //                 </td>
        //             </tr>
        //             `
            //         }).join("");
            //         $('#table-body').html(result);
            //     }
            // });




        })
    </script>
