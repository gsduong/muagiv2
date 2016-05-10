@extends('dashboard.layouts.master')
@section('page-title', 'Products Management')
@section('page-header')
<h1>
Products
</h1>
<ol class="breadcrumb">
    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> @lang('app.home')</a></li>
    <li class="active">Products</li>
</ol>
@endsection
@section('content')
@include('partials.messages')

<div class="row tab-search">
    <div class="col-md-2 col-xs-2">
        <a href="{{ route('channel.product.create') }}" class="btn btn-success" id="add-user">
            <i class="glyphicon glyphicon-plus"></i>
            Add product
        </a>
    </div>
    <div class="col-md-5 col-xs-3"></div>
    <!-- Search Form -->
    <form method="GET" action="" accept-charset="UTF-8" id="products-form">
        <div class="col-md-2 col-xs-3">
            {!! Form::select('category', $category_name, Input::get('category'), ['id' => 'category', 'class' => 'form-control']) !!}
        </div>
        <div class="col-md-3 col-xs-4">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" name="search" value="{{ Input::get('search') }}" placeholder="Search for product by name or description">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search-products-btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                    @if (Input::has('search') && Input::get('search') != '')
                        <a href="{{ route('channel.product.index') }}" class="btn btn-danger" type="button" >
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    @endif
                </span>
            </div>
        </div>
    </form>
</div>


<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List of products</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <div id="products-table-wrapper">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <th>Title</th>
                                <th>Product link</th>
                                <th>Original link</th>
                                <th>Regular Price</th>
                                <th>New Price</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            @if (count($products))
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->title}}</td>
                                <td>{{ $product->auto_link}}</td>
                                <td>{{ $product->product_link}}</td>
                                <td>{{ $product->old_price }}</td>
                                <td>{{ $product->new_price }}</td>
                                <td>{{ $product->deleted_at ? "Deleted" : "Active" }}</td>
                                <td><img src="{{ empty($product->relative_image_link) ? $product->image_link : asset($product->relative_image_link)}}" alt="{{$product->title}}" height="100px" width="100px"></td>
                                <td class="text-center">
                                    <a href="{{ route('channel.product.show', $product->id) }}" class="btn btn-success btn-circle"
                                        title="Show product" data-toggle="tooltip" data-placement="top">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <a href="{{ route('channel.product.edit', $product->id) }}" class="btn btn-primary btn-circle edit" title="Edit product"
                                        data-toggle="tooltip" data-placement="top">
                                        <i class="glyphicon glyphicon-edit"></i>
                                    </a>
                                    @if($product->deleted_at == NULL)
                                    <a href="{{ route('channel.product.delete', $product->id) }}" class="btn btn-danger btn-circle" title="Delete product"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        data-method="DELETE"
                                        data-confirm-title="Please Confirm'"
                                        data-confirm-text="Are you sure to delete this product"
                                        data-confirm-delete="Yes, delete it">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </a>
                                    @else
                                    <a href="{{ route('channel.product.restore', $product->id) }}" class="btn btn-danger btn-circle" title="Restore product"
                                        data-toggle="tooltip" data-placement="top"
                                        data-method="DELETE"
                                        data-confirm-title="Please Confirm'"
                                        data-confirm-text="Are you sure to restore this product"
                                        data-confirm-delete="Yes, restore it">
                                        <i class="fa fa-refresh"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6"><em>@lang('app.no_records_found')</em></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    {!! $products->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('after-scripts-end')
<script>
$("#category").change(function () {
$("#products-form").submit();
});
</script>
@stop