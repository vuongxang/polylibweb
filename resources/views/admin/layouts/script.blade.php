    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('adminthame/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('adminthame/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('adminthame/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('adminthame/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('adminthame/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('adminthame/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{asset('adminthame/js/demo/chart-pie-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        $('#exampleModal').on('hide.bs.modal',function(){
          var image = $('input#image').val();
          $('img#show_img').attr('src',image)
        })
        
        $(function() {
          $('.toggle-class').change(function() {
              var status = $(this).prop('checked') == true ? 1 : 0; 
              var id = $(this).data('id'); 
               
              $.ajax({
                  type: "GET",
                  dataType: "json",
                  url: 'cate/changeStatus',
                  data: {'status': status, 'id': id},
                  success: function(data){
                    console.log(data.success)
                  }
              });
          })
        })
      </script>