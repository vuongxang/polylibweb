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

    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
            external_filemanager_path:"/filemanager/",
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: { "filemanager" : "/filemanager/plugin.min.js"}
   });
</script>
