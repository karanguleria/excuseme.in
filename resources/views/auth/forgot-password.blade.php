@extends('layouts.app')

@section('title', 'Forgot Password - excuseme.in')

@section('content')
<div id="wrapper">
    <section class="loginContentArea">      
        <div class="container">
            <div class="login-container">
                <div class="logo">
                    <a href="#"><img src="{{ asset('images/logo.png') }}" alt="excuseme.in"></a>
                </div>
                
                <h3 style="text-align: center; margin-bottom: 20px;">Forgot Password?</h3>
                <p style="text-align: center; color: #666; margin-bottom: 20px;">Enter your email address and we'll send you a link to reset your password.</p>

                @if (session('status'))
                    <div style="background: #4caf50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: #f44336; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form_item">
                        <span class="login_icon">
                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="Subtract">
                                <path d="M0.0146697 4.74434C0 5.36025 0 6.05949 0 6.85714V9.14286C0 12.3753 0 13.9916 0.976311 14.9958C1.95262 16 3.52397 16 6.66667 16H13.3333C16.476 16 18.0474 16 19.0237 14.9958C20 13.9916 20 12.3753 20 9.14286V6.85714C20 6.05949 20 5.36025 19.9853 4.74434L11.0792 9.83355C10.408 10.2171 9.59196 10.2171 8.92079 9.83355L0.0146697 4.74434Z" fill="#069DE1"/>
                                <path d="M0.269963 2.31967C0.36205 2.34345 0.452665 2.37986 0.539603 2.42953L10 7.83548L19.4604 2.42953C19.5473 2.37986 19.638 2.34346 19.73 2.31967C19.5856 1.7785 19.3639 1.35419 19.0237 1.00421C18.0474 0 16.476 0 13.3333 0H6.66667C3.52397 0 1.95262 0 0.976311 1.00421C0.636053 1.35418 0.41438 1.7785 0.269963 2.31967Z" fill="#069DE1"/>
                                </g>
                            </svg>
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required value="{{ old('email') }}" />
                    </div>

                    <button type="submit" class="btn">Send Reset Link</button>
                    <a href="{{ route('login') }}" class="btn" style="background: #666; margin-top: 10px;">Back to Login</a>
                </form>
            </div>
        </div>     
    </section>

    <footer class="footerSite">
        <div class="container">
            <div class="copyRight">
                <p>Copyright © 2025. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>
@endsection
