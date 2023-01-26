    <!-- jQuery 2.1.3 -->
    <!-- <script src="{{ URL::asset('admin/plugins/jQuery/jquery-2.1.3.min.js') }}"></script> -->
    <script src="{{ URL::asset('admin/plugins/jQueryUI/jquery-1.12.4.js') }}" type="text/javascript"></script>  
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- jQuery UI 1.11.2 -->
    <script src="{{ URL::asset('admin/plugins/jQueryUI/jquery-ui.js') }}" type="text/javascript"></script>  
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->


   


    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
   
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ URL::asset('admin/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>  
    
    <!--  This Use  For Dashboard Graph Only -->

    <!-- Morris.js charts -->
    <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
    <script src="{{ URL::asset('admin/plugins/ajax/libs/raphael/raphael-min.js') }}"></script>
    <script src="{{ URL::asset('admin/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="{{ URL::asset('admin/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ URL::asset('admin/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>

    <!--  This Use  For Dashboard Graph Only -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuCIAfY1ODCoVTvJyBtkZe-irKy0ljPXY&libraries=places"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
<!--AIzaSyBuCIAfY1ODCoVTvJyBtkZe-irKy0ljPXY    AIzaSyD7OIFvK1-udIFDgZwvY7FVTFHMHipNy6Y -->
    <!--   Dropzone Js -->
    <script type="text/javascript" src="{{ URL::asset('admin/plugins/dropzone/js/dropzone.js')}}"></script>

   <!-- InputMask -->
   <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.date.extensions.js')}}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/input-mask/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>


    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ URL::asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('admin/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- Slimscroll -->
    <script src="{{ URL::asset('admin/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('admin/plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('admin/dist/js/app.min.js') }}" type="text/javascript"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ URL::asset('admin/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>
     <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script> -->
     <script src="{{ URL::asset('admin/plugins/ajax/libs/moment/moment.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ URL::asset('admin/dist/js/demo.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('admin/plugins/daterangepicker/jquery.comiseo.daterangepicker.js') }}" type="text/javascript"></script>
    
   
    <script src="{{ URL::asset('admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

    <script src="{{ URL::asset('admin/dist/js/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
    
 <!-- DATA TABES SCRIPT -->
 <!-- <script src="{{ URL::asset('admin/plugins/datatables/jquery.dataTables.js')}}" type="text/javascript"></script> -->





    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/dataTables.bootstrap.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable')}}/dataTables.buttons.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/buttons.bootstrap.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/jszip.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/pdfmake.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/vfs_fonts.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/buttons.html5.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/buttons.print.min.js"></script>
    <script src="{{ URL::asset('admin/plugins/export_bootstrap_datatable/')}}/buttons.colVis.min.js"></script>
  
    <script src="{{ URL::asset('admin/plugins/datatables/dataTables.select.min.js')}}" ></secript>
    
    <script src="{{ URL::asset('admin/plugins/datatables/dataTables.bootstrap.js')}}" type="text/javascript"></script>
   
    <!-- daterangepicker -->
    <script src="{{ URL::asset('admin/plugins/timepicker/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>

    <script src="{{ URL::asset('js/select2.min.js')}}"></script>
   
   <script type="text/javascript">
    function view_info(title,website_id,row_id,url)
      {

            console.log('title :'+title)
            console.log('website_id :'+website_id)
            console.log('row_id :'+row_id)
            var url='{{url("admin")}}/'+url+'/'+website_id+'/'+row_id;
            console.log('url :'+url)
            $('#view_details').modal('toggle');
            if(title && website_id && row_id && url)
            {
               $('.details_modal_body').html('<p style="padding-top:200px; text-align:center;"><span class="text-success"> <strong> <i class="fa fa-spinner fa-spin fa-5x"></i>  </strong> </span><p>');
               $.ajax({
                      type: "GET",
                      url: url,
                      //data: {'row_id':row_id,website_id:website_id,"_token":"{{ csrf_token() }}"},
                      success: function(result){
                          //console.log(result)
                          $('.details_modal_content').html(result);
                          $('.modal-title').html(title); 
                          // if(result=='200'){
                            
                          // }
                          // else{ 
                          //   $('.details_modal_body').html('<p style="padding-top:200px; text-align:center;"><span class="text-danger"> Somthing went <strong> Wrong! </strong> </span></p>'); 
                          //   }
                      },
                      error:function()
                      {
                        $('.details_modal_body').html('<p style="padding-top:200px; text-align:center;"><span class="text-danger"> Somthing went <strong> Wrong! </strong> </span></p>');
                      }
                  });

            }
            else
            {
                $('.details_modal_body').html('<p style="padding-top:200px; text-align:center;"><span class="text-danger"> Somthing went <strong> Wrong! </strong> </span></p>');
            }
             

             
          
      }
   </script>
    