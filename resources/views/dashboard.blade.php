@extends('layouts.shop')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $(function(){
    $("#searchBox").keypress(function(e) { 
    if(e.which == 13) { 
      var location = "{{url('dashboard/0/0')}}/"+($("#searchBox").val()?$("#searchBox").val():"0");
        window.location.href=location;
    }
});

$("#cancel_filter").click(function(){
  var location = "{{url('dashboard/0/0/0')}}";
        window.location.href=location;
});
  });
</script>

<div class="row" >
   

        <main class="col-sm-10 blog-main" role="main">
        @if($category || $search)
        <br>
        <div class="alert alert-warning" role="alert">
          Showing result for '{{$category?$category:$search}}' &nbsp;&nbsp;&nbsp;<button type="button" id="cancel_filter" class="btn btn-outline-info">Cancel</button>
        </div>
        @endif

          <section class="row text-center placeholders">
            @foreach($products as $product)
            <div class="col-6 col-sm-3 placeholder">
              <img src="{{url('products/image/'.$product->image)}}" width="200" height="200" class="img-fluid rounded-circle" alt="Generic placeholder thumbnail">
              <h4>{{$product->title}}</h4>
              <div class="text-muted">${{$product->price}}</div>
            </div>
            @endforeach
           
          </section>

          <h2>Products</h2>
          <div class="table-responsive">
         
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Category</th>
              <th>Description</th>
              <th>Price</th>
              <th>Status</th>
            
            </tr>
            @foreach($products as $index=>$product)
              <tr>
                <td>{{++$index}}</td>
                <td>{{$product->title}}</td>
                <td>{{$product->category}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->status}}</td>
                
              </tr>
            @endforeach
          </thead>
          <tbody>
        
        
           
         
          </tbody>
        </table>
          </div>
        </main>
        <div class="col-sm-1 offset-sm-1 blog-sidebar">
          <br>
          <div class="sidebar-module">
         
          <input style="width:150px" value="{{$search?$search:''}}" id="searchBox" class="form-control mr-sm-1" type="text" placeholder="Search Products" aria-label="Search">
         
    
        <br>
          </div>
          <div class="sidebar-module">
            <h4>Attributes</h4>
            <ol class="list-unstyled">
            @foreach($attributes as $attribute)
              <li><a href="{{url('dashboard/0/'.$attribute->name.'/0')}}">{{$attribute->name}}</a></li>
              @endforeach
             
            </ol>
          </div>
          <div class="sidebar-module">
            <h4>Categories</h4>
            <ol class="list-unstyled">
              @foreach($categories as $category)
              <li><a href="{{url('dashboard/'.$category->name.'/0/0')}}">{{$category->name}}</a></li>
              @endforeach
            </ol>
          </div>
          
        </div>
      </div>
@endsection