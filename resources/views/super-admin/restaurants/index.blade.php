@extends('layouts.app')

@section('title', 'Manage Restaurants - Super Admin')

@section('content')
<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebar">
    <i class="fa-solid fa-xmark close-btn" id="closeBtn"></i>
    <div class="logo">
        <a href="#" class="logo_white"><img src="{{ asset('images/logo_white.png') }}" alt=""></a>
    </div>
    
    <ul>
        <li><a href="{{ route('super-admin.restaurants.index') }}" class="active"><i class="fa-solid fa-building"></i> Restaurants</a></li>
        <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a></li>
    </ul>
</div>

<div class="main">
    <div class="topbar">
        <i class="fa-solid fa-bars menu-btn" id="menuBtn"></i>
        <h2>Manage Restaurants</h2>
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

    <div style="padding: 20px;">
        @if(session('success'))
            <div style="background: #4caf50; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom: 20px;">
            <a href="{{ route('super-admin.restaurants.create') }}" class="btn" style="display: inline-block; text-decoration: none;">
                <i class="fa-solid fa-plus"></i> Add New Restaurant
            </a>
        </div>

        <div style="background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #ddd;">
                        <th style="padding: 15px; text-align: left;">Name</th>
                        <th style="padding: 15px; text-align: left;">Email</th>
                        <th style="padding: 15px; text-align: center;">Tables</th>
                        <th style="padding: 15px; text-align: center;">Status</th>
                        <th style="padding: 15px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restaurants as $restaurant)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 15px;">
                                @if($restaurant->logo)
                                    <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}" style="max-height: 30px; margin-right: 10px;">
                                @endif
                                {{ $restaurant->name }}
                            </td>
                            <td style="padding: 15px;">{{ $restaurant->email }}</td>
                            <td style="padding: 15px; text-align: center;">{{ $restaurant->tables_count }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="padding: 5px 10px; border-radius: 20px; background: {{ $restaurant->is_active ? '#4caf50' : '#f44336' }}; color: white; font-size: 12px;">
                                    {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <a href="{{ route('super-admin.restaurants.edit', $restaurant) }}" style="color: #069DE1; margin-right: 10px;">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <a href="{{ route('super-admin.restaurants.show', $restaurant) }}" style="color: #4caf50; margin-right: 10px;">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('super-admin.restaurants.destroy', $restaurant) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this restaurant?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; color: #f44336; cursor: pointer;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 30px; text-align: center; color: #999;">
                                No restaurants found. <a href="{{ route('super-admin.restaurants.create') }}">Add your first restaurant</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
