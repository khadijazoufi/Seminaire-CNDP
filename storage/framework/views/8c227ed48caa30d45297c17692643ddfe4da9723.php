


<?php $__env->startSection('streamer_content'); ?>
<style>
  .room_desc{
  width: 250px;
  max-width: 250px;
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
.link_guide{
color:rgb(39, 39, 39) !important;
   }
   .link_guide:hover{
color:rgb(90, 30, 255) !important;
   }
</style>
<link rel="stylesheet" href="\js\sweetalert2.css">
<div class="container">
  <div class="alert alert-info alert-dismissible fade show" role="alert" style="text-transform: capitalize">
    <strong>Note :</strong> After creating Your first room, you should create an event for that Room at the sidebar > <b> <span class="link_guide"> <a style="color: rgb(37, 37, 37)" class="link_guide" href="<?php echo e(url('streamer/events')); ?>"><i class="nav-icon fas fa-bolt"></i> Events</a></span></b>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
<?php if(Session::get('success')): ?>
      <div class="alert alert-success mt-3" role="alert">
        <?php echo e(Session::get('success')); ?>

      </div>
<?php elseif(Session::get('error')): ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?php echo e(Session::get('error')); ?>

      </div>
      <?php endif; ?>
    <?php if($c == 0): ?>
    <div class="btn mb-4 mr-4" style="float: right">   
          <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalRegisterForm"><i class="fas fa-plus"></i> Add Room</button>
    </div>
    <?php else: ?>
    <div class="alert alert-danger mt-3" role="alert">
      You Have Reached Your Limit (1/1 Room)
    </div>
    <?php endif; ?>  
    <table class="table table-hover"> 
 
 <form action="<?php echo e(route('search_room_streamer')); ?>" method="GET">
 <div class="row">
  <div class="col-lg-4 col-lg-offset-4">
    <div class="input-group">
      <input type="search" id="search" name="search" class="form-control" placeholder="Search ">
      <button type="submit" class="btn btn-outline-primary">search</button>
    </div>
  </div>
</div>
</form>
    <thead>
      <tr>
        <th>Room Name</th>
        <th  class="room_desc">Room Description</th>
        <th >Max Attendees</th>
        <th >Access Code</th>
        <th >State</th>
        <th >Options</th>
      </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(Auth::user()->id == $room->user->id  ): ?>
            
        <tr> 
        <td><?php echo e($room->room_name); ?></td>
        <td class="room_desc"><?php echo e($room->room_desc); ?></td>
        <td ><?php echo e($room->max_viewers); ?></td>
        <td><?php echo e($room->viewer_pw); ?></td>
        <td><?php echo e($room->verified); ?></td>
      
         
        <td colspan="3">
          <?php if($room->verified!='Pending' && $room->verified!='Denied'): ?>

           
       <?php endif; ?> 

       <?php if($room->verified!='Pending'): ?>
       <a  href="<?php echo e(route('delete.room' , $room->id)); ?>"><button class="btn btn-primary btn-sm" style="background-color: #dc3545">Delete Room</button></a>
       <a  href="#"><button class="btn btn-primary btn-sm editRoom" style="background-color: Green" data-id="<?php echo e($room->id); ?>" ><i class="fas fa-edit" ></i></button></a>
       <?php endif; ?> 

        </td>
        
        <!-- Trigger -->
        
      
      </tr>
      <?php endif; ?>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
   
  
    </tbody>
  
  </table>
  
    <span class="pagination justify-content-center" >
    <?php echo e($rooms->links()); ?>

    </span>


 
  <form action="<?php echo e(route ('streamers.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
  <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Create Room</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-3">
            <label data-error="wrong" data-success="right" for="orangeForm-email">Room Name</label>
            <input type="text" id="RoomName" name="room_name" class="form-control validate">
          
        </div>
        <div class="row">
          <div class="col">
            <div class="md-form mb-3">
                <label data-error="wrong" data-success="right" for="orangeForm-email">Max Attendees</label>
                <input type="text" id="MaxViewer" name="max_viewers" class="form-control validate">
            </div>
            </div>
            <div class="col">
            <div class="md-form mb-3">
              <label data-error="wrong" data-success="right" for="orangeForm-email">Viewer Password</label>
              <input type="text" id="MaxViewer" name="viewer_pw" class="form-control validate">
            </div>
          </div>
          </div>
          
        <div class="md-form mb-4"> 
            <label data-error="wrong" data-success="right" for="orangeForm-pass">Room Description</label>
            <textarea id="RoomDesc" name="room_desc" class="form-control validate" cols="30" rows="8" maxlength="300"></textarea>
            <div id="countL" style="color:green;"></div>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="submit" class="btn btn-info">Create Room</button>
      </div>
    </div>
  </div>
</div>
  </form>


 <!--********************************************************************************-->

<!-- Modal -->
<form method="POST" id="updateRoomForm" action="">
  <?php echo csrf_field(); ?>
<div class="modal fade" id="updateRoomModal" tabindex="-1" role="dialog" aria-labelledby="updateRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Update Room</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-3">
            <label data-error="wrong" data-success="right" for="orangeForm-email">Room Name</label>
            <input type="text" id="RoomNameUpdate" name="room_nameupdate" class="form-control validate">
            <small class="text-error room_nameupdate_error"  style="color:red;"></small>
        </div>
        <input type="hidden" name="room_id" id="room_id">
        <div class="row">
          <div class="col">
            <div class="md-form mb-3">
                <label data-error="wrong" data-success="right" for="orangeForm-email">Max Attendees</label>
                <input type="text" id="MaxViewerUpdate" name="max_viewersupdate" class="form-control validate">
                <small class="text-error max_viewersupdate_error"  style="color:red;"></small>
            </div>
            </div>
            <div class="col">
            <div class="md-form mb-3">
              <label data-error="wrong" data-success="right" for="orangeForm-email">Viewer Password</label>
              <input type="text" id="viewer_pwUpdate" name="viewer_pwupdate" class="form-control validate">
              <small class="text-error viewer_pwupdate_error"  style="color:red;"></small>
            </div>
          </div>
          </div>
          
        <div class="md-form mb-4"> 
            <label data-error="wrong" data-success="right" for="orangeForm-pass">Room Description</label>
            <textarea id="room_descUpdate" name="room_descUpdate" class="form-control validate" cols="30" rows="8" maxlength="300"></textarea>
            <div id="countL" style="color:green;"></div>
            <small class="text-error room_descUpdate_error" style="color:red;"></small>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <a id='specialURL1' href="streamer/events/"> <button type="submit" class="btn btn-success">Update Room</button></a>
      </div>
    </div>
  </div>
</div>
</form>

<script src="\js\sweetalert2.js"></script>
<script>
  new ClipboardJS('.btn');
</script>

<script>
  $('#RoomDesc').unbind('keyup change input paste').bind('keyup change input paste',function(e){
    var $this = $(this);
    var val = $this.val();
    var valLength = val.length;
    $('#countL').attr("style","color:red");
    var maxCount = $this.attr('maxlength');
  
   $('#countL').text(valLength+"/"+maxCount);
    if(valLength>maxCount){
        $this.val($this.val().substring(0,maxCount)); 
    }
}); 
</script>
<script>
  $('.editRoom').on('click', function (e) {
    $('#updateRoomModal').modal('show');
    $('#updateRoomForm').find('small.text-error').text(" ");
    var id = $(this).data('id');
    $.ajax({
      url: '/room/'+id+'/edit/',
      method:"GET",
      success:function (result){
         // console.log(result.event.event_theme);//.val(result.event.event_theme);
        room_id.value=id;
        RoomNameUpdate.value=result.room.room_name;
        MaxViewerUpdate.value=result.room.max_viewers;
        viewer_pwUpdate.value=result.room.viewer_pw;
        room_descUpdate.value=result.room.room_desc; 
        }
      })
  });
$('#updateRoomForm').submit(function (e) {
  var form =this;
e.preventDefault();
$.ajax({
      url: "<?php echo e(route('streamers.room_update')); ?>",
      method:"POST",
      processData: false,
      contentType: false,
      dataType: 'json',
      data: new FormData(form),
      beforeSend: function () {
        $(form).find('small.text-error').text(" ");
        console.log( $(form).find('small.text-error'));
      },
      success:function (result){
        if (result.status == 0) {

        $.each(result.errors, function (prefix, val) {
            $(form).find('small.text-error.' + prefix + '_error').text(val[0]);
          });
          } else if (result.status == 1) {
            $('#updateRoomModal').modal('hide');
            Swal.fire(
  'Room Added',
  'Successfully',
  'success'
)
          }
      }
       
});
});
</script>

</div>
</form>
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('streamers.streamer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Tamkin\Desktop\Nouveau dossier\plateforme-seminaire\resources\views/streamers/rooms.blade.php ENDPATH**/ ?>