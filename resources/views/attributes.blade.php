@extends('layouts.shop')
@section('content')

<!-- Required for tree -->
<link href="{{ asset('css/tree.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}" ></script>

<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<style>#addNew{float:right;}</style>
<script>
  $(function(){
    $('#alert').on('hidden.bs.modal', function (e) {
      window.location.reload(1);
    });
    var currentNode=null;
$("#submitNewChild").click(function(){
    $.ajax({
      url:$("#addNew").val(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"post",
    data:{"name":$("#name").val(),"description":$("#description").val(),"category":$("#category").val()},
    success:function(result){
      
        $("#form").modal("hide");
        $("#message").html("Node has been removed successfully from the tree");
        $("#alert").modal("show");
    }
    });
  });
    $(".removeAttribute").click(function(){
      var that = $(this);
      $.ajax({
      url:$("#delete").val(),
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    method:"delete",
    data:{"id":that.data("id")},
    success:function(result){
      
        $("#form").modal("hide");
        $("#message").html("Node has been removed successfully from the tree");
        $("#alert").modal("show");
    }
   
    });
});




  });

</script>
<input type="hidden" id="addNew" value="{{ url('attributes/add') }}" >
<input type="hidden" id="delete" value="{{ url('attributes/remove') }}" >
<div class="table-responsive">
  <br>
  <h3>Attributes <button type="button" data-target="#form" data-toggle="modal" id="addNew" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add new</button></h3>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Category</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($attributes as $index=>$row)
    <tr>
      <td>{{++$index}}</td>
      <td>{{$row->title}}</td>
      <td>{{$row->category}}</td>
      <td>{{$row->description}}</td>
      <td><span class="badge badge-danger removeAttribute" data-id="{{$row->id}}">Delete</span> <span class="badge badge-info">Update</span></td>
      
    </tr>
    @endforeach

   
 
  </tbody>
</table>
</div>
<div class="modal" id="form">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new attribute</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="form-group">
        <label for="exampleFormControlInput1">Name</label>
        <input type="text" id="name" class="form-control" id="exampleFormControlInput1" placeholder="Ex. Color">
      </div>
      
      <div class="form-group">
        <label for="exampleFormControlSelect2">Category</label>
        <select id="category" class="form-control" id="exampleFormControlSelect2">
          @foreach($categories as $row)
            <option value="{{ $row->category_id }}">{{ $row->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Description</label>
        <textarea id="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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