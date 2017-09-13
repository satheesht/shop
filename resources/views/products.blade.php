@extends('layouts.shop')
@section('content')

<!-- Required for tree -->
<link href="{{ asset('css/tree.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('js/popper.min.js') }}" ></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.5/angular.min.js"></script>


<style>#addNew{float:right;}</style>
<script>
var app = angular.module('shop', []);
app.controller('products', function($scope,$http) { 
    $scope.product={
      "_token": "{{ csrf_token() }}"
    };

    $scope.addNew = function(){
      $http({
        url: $("#newProductUrl").val(),
        method: "POST",
        data: $scope.product,
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        then:function(){
          window.location.reload(1);
        }
    });
    }

    $scope.deleteProduct = function(product_id){
      $http({
        url: $("#delete").val(),
        method: "delete",
        data: {"product_id":product_id},
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        then:function(){
          window.location.reload(1);
        }
      });
    }
});
</script>



<div class="container" ng-app="shop" ng-controller="products">

<input type="hidden" id="newProductUrl" value="{{ url('products/addNew') }}" >
<input type="hidden" id="delete" value="{{ url('products/remove') }}" >
<div class="table-responsive">
  <br>
  <h3>Products <button type="button" data-target="#form" data-toggle="modal" id="addNew" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i> Add new</button></h3>
<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Category</th>
      <th>Description</th>
      <th>Price</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
    @foreach($products as $index=>$product)
      <tr>
        <td>{{++$index}}</td>
        <td>{{$product->title}}</td>
        <td>{{$product->category}}</td>
        <td>{{$product->description}}</td>
        <td>{{$product->price}}</td>
        <td>{{$product->status}}</td>
        <td><span class="badge badge-danger removeAttribute" ng-click="deleteProduct('{{$product->product_id}}')">Delete</span> <span class="badge badge-info">Update</span></td>
      </tr>
    @endforeach
  </thead>
  <tbody>


   
 
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
        <input type="text" ng-model="product.name" class="form-control" id="exampleFormControlInput1" >
      </div>

      <div class="form-group">
        <label for="exampleFormControlInput1">Model</label>
        <input type="text"  ng-model="product.model" class="form-control" id="exampleFormControlInput1" >
      </div>

      <div class="form-group">
        <label for="exampleFormControlInput1">Price</label>
        <input type="text" ng-model="product.price" class="form-control" id="exampleFormControlInput1" >
      </div>
      
      <div class="form-group">
        <label for="exampleFormControlSelect2">Category</label>
        <select ng-model="product.category" class="form-control" id="exampleFormControlSelect2">
          @foreach($categories as $row)
            <option value="{{ $row->category_id }}">{{ $row->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlSelect2">Attributes</label>
        <select ng-model="product.attribute" multiple  class="form-control" id="exampleFormControlSelect2">
          @foreach($attributes as $row)
            <option value="{{ $row->id }}">{{ $row->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Description</label>
        <textarea  ng-model="product.description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
      </div>

      <div class="form-group">
      <label for="exampleFormControlSelect2">Status</label>
      <select ng-model="product.status" class="form-control" id="exampleFormControlSelect2">
          <option value="Not Available">Not Available</option>
          <option value="Available">Available</option>
          <option value="Coming Soon">Coming Soon</option>
      </select>
    </div>

      <div class="form-group">
        <label for="exampleFormControlInput1">Quantity</label>
        <input type="text" ng-model="product.quantity" class="form-control" id="exampleFormControlInput1" >
      </div>

      <div class="form-group">
      <label for="exampleFormControlInput1">Price</label>
      <input type="file" ng-model="product.price" class="form-control" id="exampleFormControlInput1" >
    </div>

    </form>
      </div>
      <div class="modal-footer">
        <button type="button" ng-click="addNew()" class="btn btn-primary" id="submitNewChild">Save</button>
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
</div>

@endsection