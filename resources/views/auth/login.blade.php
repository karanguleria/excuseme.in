@extends('layouts.app')

@section('title', 'Login - excuseme.in')

@section('content')
<div id="wrapper">
    <section class="loginContentArea">      
        <div class="container">
            <div class="login-container">
                <div class="logo">
                    <a href="#"><img src="{{ asset('images/logo.png') }}" alt="excuseme.in"></a>
                </div>
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form_item">
                        <span class="login_icon">
                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="Vector">
                                <path d="M16.0092 16.4054C16.562 16.2902 16.8912 15.7117 16.6165 15.2183C16.0109 14.1307 15.0569 13.1749 13.8365 12.4465C12.2647 11.5085 10.3388 11 8.35764 11C6.37643 11 4.45059 11.5085 2.87879 12.4465C1.65835 13.1749 0.704328 14.1307 0.0987467 15.2183C-0.175951 15.7117 0.153284 16.2902 0.7061 16.4054C5.75291 17.4572 10.9624 17.4572 16.0092 16.4054Z" fill="#069DE1"/>
                                <path d="M13.3577 5C13.3577 7.76142 11.1191 10 8.35767 10C5.59624 10 3.35767 7.76142 3.35767 5C3.35767 2.23858 5.59624 0 8.35767 0C11.1191 0 13.3577 2.23858 13.3577 5Z" fill="#069DE1"/>
                                </g>
                            </svg>
                        </span>
                        <input type="email" name="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" />
                    </div>
                    <div class="form_item">
                        <span class="login_icon">
                            <svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="Subtract">
                                <path d="M0.0146697 4.74434C0 5.36025 0 6.05949 0 6.85714V9.14286C0 12.3753 0 13.9916 0.976311 14.9958C1.95262 16 3.52397 16 6.66667 16H13.3333C16.476 16 18.0474 16 19.0237 14.9958C20 13.9916 20 12.3753 20 9.14286V6.85714C20 6.05949 20 5.36025 19.9853 4.74434L11.0792 9.83355C10.408 10.2171 9.59196 10.2171 8.92079 9.83355L0.0146697 4.74434Z" fill="#069DE1"/>
                                <path d="M0.269963 2.31967C0.36205 2.34345 0.452665 2.37986 0.539603 2.42953L10 7.83548L19.4604 2.42953C19.5473 2.37986 19.638 2.34346 19.73 2.31967C19.5856 1.7785 19.3639 1.35419 19.0237 1.00421C18.0474 0 16.476 0 13.3333 0H6.66667C3.52397 0 1.95262 0 0.976311 1.00421C0.636053 1.35418 0.41438 1.7785 0.269963 2.31967Z" fill="#069DE1"/>
                                </g>
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required />
                        <span class="login_icon_right" id="togglePassword" style="cursor: pointer;">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g id="Vector">
                                <path d="M12.8059 9.7227C12.8567 9.47551 12.8834 9.21967 12.8834 8.9577C12.8834 6.84206 11.1447 5.12699 8.99999 5.12699C8.73441 5.12699 8.47506 5.15329 8.22446 5.20339L9.1203 6.08708C10.6332 6.14771 11.8486 7.34668 11.9101 8.83902L12.8059 9.7227Z" fill="#069DE1"/>
                                <path d="M6.4691 7.53491C6.22624 7.95438 6.08745 8.44005 6.08745 8.9577C6.08745 10.5444 7.39144 11.8307 8.99999 11.8307C9.52475 11.8307 10.0171 11.6938 10.4423 11.4543L11.1475 12.1499C10.5324 12.5533 9.79403 12.7884 8.99999 12.7884C6.85526 12.7884 5.11661 11.0733 5.11661 8.9577C5.11661 8.17443 5.35492 7.44606 5.76393 6.83931L6.4691 7.53491Z" fill="#069DE1"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.5022 5.34387C3.17498 6.28579 2.10025 7.43327 1.42538 8.24152C1.0134 8.73493 0.970845 8.82027 0.970845 8.9577C0.970845 9.09513 1.0134 9.18047 1.42538 9.67388C2.10025 10.4821 3.17498 11.6296 4.5022 12.5715C5.83325 13.5162 7.37691 14.2249 9 14.2249C10.6231 14.2249 12.1667 13.5162 13.4978 12.5715C14.825 11.6296 15.8997 10.4821 16.5746 9.67388C16.9866 9.18047 17.0292 9.09513 17.0292 8.9577C17.0292 8.82027 16.9866 8.73493 16.5746 8.24152C15.8998 7.43327 14.825 6.28579 13.4978 5.34387C12.1667 4.39922 10.6231 3.69048 9 3.69048C7.37691 3.69048 5.83325 4.39922 4.5022 5.34387ZM3.93521 4.56648C5.35171 3.5612 7.09336 2.7328 9 2.7328C10.9066 2.7328 12.6483 3.5612 14.0648 4.56648C15.4851 5.57449 16.6202 6.78974 17.324 7.63266C17.3431 7.6555 17.3621 7.67821 17.3811 7.70082C17.702 8.08333 18 8.43857 18 8.9577C18 9.47682 17.702 9.83206 17.3811 10.2146C17.3621 10.2372 17.3431 10.2599 17.324 10.2827C16.6202 11.1257 15.4851 12.3409 14.0648 13.3489C12.6483 14.3542 10.9066 15.1826 9 15.1826C7.09336 15.1826 5.35171 14.3542 3.93521 13.3489C2.51488 12.3409 1.37982 11.1257 0.675999 10.2827C0.656927 10.2599 0.637878 10.2372 0.618908 10.2146C0.298019 9.83206 -2.89333e-08 9.47682 0 8.9577C2.89335e-08 8.43857 0.298019 8.08333 0.61891 7.70082C0.637879 7.67821 0.656928 7.6555 0.676 7.63266C1.37982 6.78974 2.51488 5.57449 3.93521 4.56648Z" fill="#069DE1"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.4235 16L0.89002 0.677179L1.57651 0L17.11 15.3228L16.4235 16Z" fill="#069DE1"/>
                                </g>
                            </svg>
                        </span>
                    </div>

                    <div class="remember">
                        <label><input type="checkbox" name="remember" /> Remember me</label>
                        <a href="{{ route('password.request') }}" class="forgot">Forgot Password?</a>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
        </div>     
    </section>

    <footer class="footerSite">
        <div class="container">
            <div class="copyRight">
                <p>Copyright © 2025. All rights reserved. </p>
            </div>
        </div>
    </footer>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
    });
</script>
@endsection
