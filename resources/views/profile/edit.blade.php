@extends('layouts.app')

@section('title', 'Profile Settings - excuseme.in')

@section('content')
<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebar">
    <i class="fa-solid fa-xmark close-btn" id="closeBtn"></i>
    <div class="logo">
        <a href="#" class="logo_white"><img src="{{ asset('images/logo_white.png') }}" alt=""></a>
    </div>
    
    <ul>
        @if(auth()->user()->isSuperAdmin())
            <li><a href="{{ route('super-admin.restaurants.index') }}"><i class="fa-solid fa-building"></i> Restaurants</a></li>
        @else
            <li><a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        @endif
        <li><a href="{{ route('profile.edit') }}" class="active"><i class="fa-solid fa-gear"></i> Settings</a></li>
    </ul>
</div>

<div class="main">
    <div class="topbar">
        <i class="fa-solid fa-bars menu-btn" id="menuBtn"></i>
        <h2>Profile Settings</h2>
        <div class="user-menu">
            <i class="fa-solid fa-user-circle user-icon"></i>
            <div class="dropdown">
                <a href="javascript:void(0)" class="idText"><i></i> {{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer; padding: 10px 15px; display: block; width: 100%; text-align: left;">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div style="padding: 20px; max-width: 800px; margin: 0 auto;">
        @if(session('success'))
            <div style="background: #4caf50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background: #f44336; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Information -->
        <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h3 style="margin-bottom: 20px;">Profile Information</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')
                
                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required />
                </div>

                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required />
                </div>

                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" readonly />
                </div>

                @if($user->restaurant)
                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">Restaurant</label>
                        <input type="text" class="form-control" value="{{ $user->restaurant->name }}" readonly />
                    </div>
                @endif

                <button type="submit" class="btn">Update Profile</button>
            </form>
        </div>

        <!-- Change Password -->
        <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 20px;">Change Password</h3>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                
                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required />
                </div>

                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">New Password</label>
                    <input type="password" name="password" class="form-control" required minlength="8" />
                </div>

                <div class="form_item">
                    <label style="display: block; margin-bottom: 5px; color: #666;">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required minlength="8" />
                </div>

                <button type="submit" class="btn">Change Password</button>
            </form>
        </div>
    </div>

    <footer>© 2025 excuseme.in — Restaurant Management Dashboard</footer>
</div>

@push('scripts')
<script>
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeBtn');
    const overlay = document.getElementById('overlay');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.add('active');
        overlay.classList.add('active');
    });

    function closeSidebar() {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
    }

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeSidebar();
    });
</script>
@endpush
@endsection
