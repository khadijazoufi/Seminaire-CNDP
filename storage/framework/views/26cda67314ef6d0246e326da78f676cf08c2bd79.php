



<?php $__env->startSection('validator_content'); ?>
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
  
<?php if(Session::get('success')): ?>
      <div class="alert alert-success mt-3" role="alert">
        <?php echo e(Session::get('success')); ?>

      </div>
<?php elseif(Session::get('error')): ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?php echo e(Session::get('error')); ?>

      </div>
  <?php endif; ?>

    <table class="table table-hover text-center">
 
 
    <thead>
      <tr>
        <th>Room Name</th>
        <th  class="room_desc">Room Description</th>
        
        <th >Access Code</th>
        <th >State</th>
        <th >Created at</th>
        <th >Last usage</th>
        <th >Options</th>
      </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <tr>
        <td><?php echo e($room->room_name); ?></td>
        <td class="room_desc"><?php echo e($room->room_desc); ?></td>
        
        <td><?php echo e($room->viewer_pw); ?></td>
        <td><?php echo e($room->verified); ?></td>
        <td><?php echo e($room->created_at); ?></td>
        <td><?php echo e($room->last_usage); ?></td>
        <td colspan="3">
          <?php if($room->verified!='Pending' && $room->verified!='Denied'): ?>


       <?php endif; ?>

       <?php if($room->verified!='Pending'): ?>
       
       <a class="delete_room" id="<?php echo e($room->id); ?>"><button  class="btn btn-primary btn-sm" style="background-color: #dc3545" ><i class="fas fa-trash-alt"></i></button></a>
       <a  href="#"><button class="btn btn-primary btn-sm editRoom" id="editRoom" style="background-color: rgb(19, 184, 19)" data-id="<?php echo e($room->id); ?>" ><i class="fas fa-edit" ></i></button></a>
       <a class="room_history" target="popup" id="<?php echo e($room->id); ?>"><button  class="btn btn-primary btn-sm" style="background-color: #8a0cff" >
        <i class="fas fa-history"></i></button></a>
      </td>
     
      <!-- Trigger -->
      </tr>
      <?php endif; ?>
     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    </tbody>

  </table>

    <span class="pagination justify-content-center" >
    
    </span>
<!--///////////////////////////////////////////////////////////////////////////-->


<!-- Modal -->
<div class="modal fade " id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Room Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       Are you sure u wanna delete this Room?
      </div>
      <div class="modal-footer">
      
        <a style="color:white" type="button" class="btn btn-danger btn_c_delete">Confirm Delete</a>
        <a style="color:white" type="button" class="btn btn-info btn_cancel">Cancel</a>
      </div>
    </div>
  </div>
</div>

<!--///////////////////////////////////////////////////////////////////////////-->



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
        <a id='specialURL1' href="streamer/rooms"> <button type="submit" class="btn btn-success">Update Room</button></a>
      </div>
    </div>
  </div>
</div>
</form>
<script>

$('.room_history').click(function(){
  var room_id= $(this).attr('id');
  var str='<?php echo e(route("ev_room_history",":id")); ?>';
    url= str.replace(':id',room_id);
  window.open(url,'popup','width=1000,height=800')
});
</script>
<script>
  // btn_c_delete
    $('.btn-close ,.btn_cancel').click(function(){
      $('#deleteModal').modal('hide');
    });
      $('.delete_room').click(function(){
          var room_id= $(this).attr("id");
        //console.log(room_id);
          var str='<?php echo e(route("delete.room",":id")); ?>';
          str= str.replace(':id',room_id);
          $('#deleteModal').modal('show');
          $('.btn_c_delete').attr('href',str);
      });
  </script>

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
      url: '/rooms/'+id+'/edit/',
      method:"GET",

      success:function (result){
        //console.log(result.room.room_name);//.val(result.event.event_theme);
        room_id.value=id;
        RoomNameUpdate.value=result.room.room_name;
        //MaxViewerUpdate.value=result.room.max_viewers;
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

<?php echo $__env->make('EventValidator.EV_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Seminaire-CNDP\resources\views/EventValidator/rooms.blade.php ENDPATH**/ ?>