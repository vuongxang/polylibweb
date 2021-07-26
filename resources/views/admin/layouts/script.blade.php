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
    <script src="{{ asset('adminthame/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('adminthame/js/demo/chart-pie-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/hmuw3s2zqh2hz2ctu3t8rxpvxh61d6ci6pkldvwxndprwi2a/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
 
           CKEDITOR.replace( 'editor1' );
 
       </script>  
<script>
      $(document).ready(function(){

        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
        removeItemButton: true,
        maxItemCount:10,
        searchResultLimit:10,
        renderChoiceLimit:10
        });


        $('#exampleModal').on('hide.bs.modal', function() {
            var image = $('input#image').val();
            $('img#show_img').attr('src', image)
        })

        $('#image_gallery').on('hide.bs.modal', function() {
            var image_list = $('input#list_image').val();
            var image_gallery = $.parseJSON(image_list);
            // console.log(image_gallery);
            var html = '';
            image_gallery.forEach((item, index) => {
                html +=
                    `<img src="${item}" id="show_list_image" width="50" class="img-thumbnail">`;
            });
            console.log(html);
            $('.img-gallery').html(html);
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
        plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
        // mobile: {
        //     plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable'
        // },
        // menu: {
        //     tc: {
        //     title: 'Comments',
        //     items: 'addcomment showcomments deleteallconversations'
        //     }
        // },
        toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
        // autosave_ask_before_unload: false,
        // autosave_interval: '30s',
        // autosave_prefix: '{path}{query}-{id}-',
        // autosave_restore_when_empty: false,
        // autosave_retention: '2m',
        // image_advtab: true,
        // importcss_append: true,
        tinycomments_author: 'Author name',
            external_filemanager_path:"/filemanager/",
            filemanager_title:"Responsive Filemanager" ,
            external_plugins: { "filemanager" : "/filemanager/plugin.min.js"},
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

   $('#page_size').change(function(){
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
