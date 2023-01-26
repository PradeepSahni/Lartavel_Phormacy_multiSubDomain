
<style type="text/css">
	.modal_style {
        position: fixed;
	      margin: auto;
	      right: 15px;
        top: 118px;
	}
	.modal-content{
		height: 600px;
	}
	.details_modal_body{
		height: 67vh; 
		overflow-y: auto;
	}
	.modal-title{
		font-size: 30px;
	}
</style>
<div id="view_details" class="modal fade" role="dialog">
  <div class="modal-dialog modal_style">

    <!-- Modal content-->
    <div class="modal-content details_modal_content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body details_modal_body">
        
      </div>
      
    </div>

  </div>
</div>
<footer class="main-footer">
        <!-- <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div> -->
        <strong>Copyright &copy; {{date('Y')}}-{{date('Y')+1}} <a href="javascript:void(0)">PackPeak</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->