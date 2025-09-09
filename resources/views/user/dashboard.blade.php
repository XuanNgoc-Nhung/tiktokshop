@extends('user.layouts.app')

@section('title', 'Dashboard - TikTok Shop')

@section('content')
<div class="container">
    <div class="header">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            TikTok Shop
        </div>
        <div class="user-info">
            <span>Xin chào, {{ session('user_phone') }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #4ecdc4; cursor: pointer; margin-left: 10px;">
                    <i class="fas fa-sign-out-alt"></i> Đăng xuất
                </button>
            </form>
        </div>
    </div>

    <div style="text-align: center; padding: 40px 0;">
        <div style="font-size: 48px; color: #4ecdc4; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 style="color: #2c3e50; margin-bottom: 10px;">Đăng nhập thành công!</h1>
        <p style="color: #7f8c8d; margin-bottom: 30px;">Chào mừng bạn đến với TikTok Shop</p>
        
        <div style="background: rgba(78, 205, 196, 0.1); padding: 20px; border-radius: 12px; margin: 20px 0;">
            <h3 style="color: #2c3e50; margin-bottom: 15px;">Thông tin tài khoản demo:</h3>
            <p style="color: #7f8c8d; margin: 5px 0;"><strong>Số điện thoại:</strong> 0123456789</p>
            <p style="color: #7f8c8d; margin: 5px 0;"><strong>Mật khẩu:</strong> 123456</p>
        </div>
        
        <div style="margin-top: 30px;">
            <a href="{{ route('login') }}" style="display: inline-block; padding: 12px 24px; background: linear-gradient(135deg, #ff6b6b, #ff8e53); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                Quay lại đăng nhập
            </a>
        </div>
    </div>
</div>

<style>
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #2c3e50;
    }
</style>
@endsection
