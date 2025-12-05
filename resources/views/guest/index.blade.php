@extends('layouts.app')

@section('title', 'Call Waiter - Table {{ $table->table_number }}')

@section('content')
<div class="wraper">
    <h2 class="desktopText">This page is meant to be used on mobile only</h2>
    <div class="guest_wrapper">
        <div class="main">
            <div class="topbar">
                <h2>
                    @if($table->restaurant->logo)
                        <img src="{{ asset('storage/' . $table->restaurant->logo) }}" alt="{{ $table->restaurant->name }}" style="max-height: 40px;">
                    @else
                        {{ $table->restaurant->name }}
                    @endif
                </h2>
            </div>

            <div class="switchesArea">
                <h2>Call Us On Table</h2>
                <div class="switches-container">
                    <input type="radio" id="switchOff" name="switchPlan" value="Off" checked="checked" />
                    <input type="radio" id="switchRing" name="switchPlan" value="Ring" />
                    <label for="switchOff">Off</label>
                    <label for="switchRing">Ring</label>
                    <div class="switch-wrapper">
                        <div class="switch">
                            <div>Off</div>
                            <div>Ring</div>
                        </div>
                    </div>
                </div>
                <div class="viewButton">
                    <a href="#" class="viewBtn">View Menu</a>
                </div>
            </div>

            <footer class="footerBox">© 2025 excuseme.in — Restaurant Management Dashboard</footer>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const switchOff = document.getElementById('switchOff');
    const switchRing = document.getElementById('switchRing');
    const tableUrl = '{{ $table->unique_url }}';

    // Check current status on page load
    function checkStatus() {
        fetch(`/table/${tableUrl}/status`)
            .then(response => response.json())
            .then(data => {
                if (data.is_ringing) {
                    switchRing.checked = true;
                } else {
                    switchOff.checked = true;
                }
            })
            .catch(error => console.error('Error:', error));
    }

    checkStatus();
    setInterval(checkStatus, 3000);

    // Handle ring toggle
    switchRing.addEventListener('change', function() {
        if (this.checked) {
            fetch(`/table/${tableUrl}/ring`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                switchOff.checked = true;
            });
        }
    });

    // Handle off toggle
    switchOff.addEventListener('change', function() {
        if (this.checked) {
            fetch(`/table/${tableUrl}/stop`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                switchRing.checked = true;
            });
        }
    });
</script>
@endpush
@endsection
