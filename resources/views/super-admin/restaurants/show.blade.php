@extends('layouts.app')

@section('title', 'Restaurant Details - Super Admin')

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
        <h2>Restaurant Details</h2>
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
        <div style="margin-bottom: 20px;">
            <a href="{{ route('super-admin.restaurants.index') }}" class="btn" style="display: inline-block; text-decoration: none; background: #666;">
                <i class="fa-solid fa-arrow-left"></i> Back to Restaurants
            </a>
        </div>

        <!-- Restaurant Info -->
        <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h2 style="margin-bottom: 20px;">{{ $restaurant->name }}</h2>
            
            @if($restaurant->logo)
                <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}" style="max-height: 100px; margin-bottom: 20px;">
            @endif

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div>
                    <strong>Email:</strong> {{ $restaurant->email }}
                </div>
                <div>
                    <strong>Number of Tables:</strong> {{ $restaurant->tables->count() }}
                </div>
                <div>
                    <strong>Status:</strong> 
                    <span style="padding: 5px 10px; border-radius: 20px; background: {{ $restaurant->is_active ? '#4caf50' : '#f44336' }}; color: white; font-size: 12px;">
                        {{ $restaurant->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <div>
                    <strong>Created:</strong> {{ $restaurant->created_at->format('M d, Y') }}
                </div>
            </div>
        </div>

        <!-- Admin Users -->
        <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 20px;">
            <h3 style="margin-bottom: 20px;">Admin Users</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #ddd;">
                        <th style="padding: 10px; text-align: left;">Name</th>
                        <th style="padding: 10px; text-align: left;">Email</th>
                        <th style="padding: 10px; text-align: left;">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurant->users as $user)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 10px;">{{ $user->name }}</td>
                            <td style="padding: 10px;">{{ $user->email }}</td>
                            <td style="padding: 10px;">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tables with QR Codes -->
        <div style="background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <h3 style="margin-bottom: 20px;">Tables & QR Codes</h3>
            <p style="color: #666; margin-bottom: 20px;">Download these QR codes and place them on respective tables. Guests can scan them to call the waiter.</p>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px;">
                @foreach($restaurant->tables as $table)
                    <div style="text-align: center; padding: 20px; border: 2px solid #ddd; border-radius: 10px;">
                        <h4 style="margin-bottom: 15px;">Table {{ $table->table_number }}</h4>
                        <div style="background: white; padding: 10px; display: inline-block;">
                            {!! QrCode::size(150)->generate(route('guest.show', $table->unique_url)) !!}
                        </div>
                        <div style="margin-top: 15px;">
                            <a href="{{ route('guest.show', $table->unique_url) }}" target="_blank" style="color: #069DE1; font-size: 12px; word-break: break-all;">
                                View Link
                            </a>
                        </div>
                        <div style="margin-top: 10px;">
                            <button onclick="downloadQR({{ $table->id }}, {{ $table->table_number }})" class="btn" style="font-size: 12px; padding: 8px 15px;">
                                <i class="fa-solid fa-download"></i> Download
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
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

    function downloadQR(tableId, tableNumber) {
        // Get the QR code SVG
        const qrContainer = event.target.closest('div').parentElement.querySelector('svg');
        const serializer = new XMLSerializer();
        const svgString = serializer.serializeToString(qrContainer);
        const svgBlob = new Blob([svgString], {type: 'image/svg+xml;charset=utf-8'});
        const url = URL.createObjectURL(svgBlob);
        
        const link = document.createElement('a');
        link.href = url;
        link.download = `table-${tableNumber}-qr-code.svg`;
        link.click();
        
        URL.revokeObjectURL(url);
    }
</script>
@endpush
@endsection
