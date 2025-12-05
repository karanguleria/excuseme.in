@extends('layouts.app')

@section('title', 'Dashboard - excuseme.in')

@section('content')
<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebar">
    <i class="fa-solid fa-xmark close-btn" id="closeBtn"></i>
    <div class="logo">
        <a href="#" class="logo_white"><img src="{{ asset('images/logo_white.png') }}" alt=""></a>
    </div>
    
    <ul>
        <li><a href="{{ route('dashboard') }}" class="active"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="{{ route('profile.edit') }}"><i class="fa-solid fa-gear"></i> Settings</a></li>
    </ul>
</div>

<div class="main">
    <div class="topbar">
        <i class="fa-solid fa-bars menu-btn" id="menuBtn"></i>
        <h2>Table Dashboard</h2>
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

    <div class="table-grid" id="tableGrid">
        @foreach($tables as $table)
            <div class="table-card {{ $table->is_ringing ? 'active' : '' }}" data-table-id="{{ $table->id }}">
                <span class="bell_iconBox">
                    <i class="fa-solid fa-bell bell-icon"></i>
                </span>
                <h3>Table {{ $table->table_number }}</h3>
            </div>
        @endforeach
    </div>

    <footer>© 2025 RestoAdmin — Restaurant Management Dashboard</footer>
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

    // Real-time table updates
    function updateTables() {
        fetch('{{ route("api.tables") }}')
            .then(response => response.json())
            .then(tables => {
                tables.forEach(table => {
                    const tableCard = document.querySelector(`[data-table-id="${table.id}"]`);
                    if (tableCard) {
                        if (table.is_ringing) {
                            tableCard.classList.add('active');
                        } else {
                            tableCard.classList.remove('active');
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching tables:', error));
    }

    // Poll for updates every 2 seconds
    setInterval(updateTables, 2000);

    // Handle table click to acknowledge
    document.getElementById('tableGrid').addEventListener('click', function(e) {
        const tableCard = e.target.closest('.table-card');
        if (tableCard && tableCard.classList.contains('active')) {
            const tableId = tableCard.dataset.tableId;
            
            fetch(`/api/tables/${tableId}/acknowledge`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    tableCard.classList.remove('active');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    });
</script>
@endpush
@endsection
