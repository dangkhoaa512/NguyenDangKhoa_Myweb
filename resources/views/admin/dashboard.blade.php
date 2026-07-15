@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h2 class="mb-4">Dashboard</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-tags"></i> Loại sản phẩm</h5>
                <p class="card-text fs-3 fw-bold">{{ \App\Models\Category::count() }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-box-seam"></i> Sản phẩm</h5>
                <p class="card-text fs-3 fw-bold">{{ \App\Models\Product::count() }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-patch-check"></i> Thương hiệu</h5>
                <p class="card-text fs-3 fw-bold">{{ \App\Models\Brand::count() }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people"></i> Người dùng</h5>
                <p class="card-text fs-3 fw-bold">{{ \App\Models\User::count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection