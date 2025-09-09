@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-header">
    <h1><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>
    <p>Chào mừng đến với bảng điều khiển quản trị</p>
</div>

<div class="p-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Xin chào, {{ Auth::user()->name ?? Auth::user()->email }}!</strong>
                Bạn đã đăng nhập thành công với tư cách admin.
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Quản lý người dùng</h5>
                    <p class="card-text">Quản lý tài khoản người dùng</p>
                    <button class="btn btn-outline-primary">Xem chi tiết</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Quản lý sản phẩm</h5>
                    <p class="card-text">Quản lý danh mục sản phẩm</p>
                    <button class="btn btn-outline-success">Xem chi tiết</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Thống kê</h5>
                    <p class="card-text">Xem báo cáo và thống kê</p>
                    <button class="btn btn-outline-warning">Xem chi tiết</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Cài đặt hệ thống</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin tài khoản</h6>
                            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            <p><strong>Vai trò:</strong> Admin</p>
                            <p><strong>Đăng nhập lần cuối:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Hành động nhanh</h6>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary">
                                    <i class="fas fa-edit me-2"></i>Chỉnh sửa thông tin
                                </button>
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-key me-2"></i>Đổi mật khẩu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-center">
            <form method="POST" action="{{ route('admin.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                </button>
            </form>
            <a href="{{ route('admin.login') }}" class="btn btn-outline-secondary ms-2">
                <i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập
            </a>
        </div>
    </div>
</div>
@endsection
