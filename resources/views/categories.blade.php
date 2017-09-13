@extends('layouts.shop')
@section('content')

<!-- Required for tree -->
<link href="{{ asset('css/tree.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}" ></script>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>

<script>
  $(function(){
    var currentNode=null;
$(".addChild").click(function(){
  currentNode = $(this).data("id");
});

$('#alert').on('hidden.bs.modal', function (e) {
  window.location.reload(1);
});

$(".removeChild").click(function(){
  var that = $(this);
  if(confirm("You are about to delete the category '"+$(this).data("name")+"'. Are you sure?")){
    $.ajax({
      url:$("#removeChild").val(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"delete",
    data:{"nodeId":that.data("id")},
    success:function(result){
      
        $("#form").modal("hide");
        $("#message").html("Node has been removed successfully from the tree");
        $("#alert").modal("show");
    }
    });
  }else{

  }
});
 $("#submitNewChild").click(function(){
    
   

    $.ajax({
      url:$("#newChildUrl").val(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"post",
    data:{"childName":$("#childName").val(),"nodeId":currentNode},
    success:function(result){
      
        $("#form").modal("hide");
        $("#message").html("New child added successfully");
        $("#alert").modal("show");
    }
    });
 });
  });

</script>
<input type="hidden" id="newChildUrl" value="{{ url('categories/newChild') }}" >
<input type="hidden" id="removeChild" value="{{ url('categories/removeChild') }}" >

<div class="treeview">
{!! $result !!}
</div>
<div class="modal" id="form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new child</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <input type="text" class="form-control" aria-describedby="emailHelp" id="childName" placeholder="Enter name of the child">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitNewChild">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="alert">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Completed</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="message">New child added successfully!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
      </div>
    </div>
  </div>
</div>


@endsection