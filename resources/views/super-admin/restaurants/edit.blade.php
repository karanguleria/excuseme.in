@extends('layouts.app')

@section('title', 'Edit Restaurant - Super Admin')

@section('content')
<div id="wrapper">
    <section class="loginContentArea">      
        <div class="container" style="max-width: 600px;">
            <div class="login-container">
                <h2 style="text-align: center; margin-bottom: 30px;">Edit Restaurant</h2>
                
                @if ($errors->any())
                    <div style="background: #f44336; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('super-admin.restaurants.update', $restaurant) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">Restaurant Name</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $restaurant->name) }}" />
                    </div>

                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">Restaurant Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email', $restaurant->email) }}" />
                    </div>

                    @if($restaurant->logo)
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 5px; color: #666;">Current Logo</label>
                            <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}" style="max-height: 80px;">
                        </div>
                    @endif

                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">New Logo (optional)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*" />
                    </div>

                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">Number of Tables</label>
                        <input type="number" name="number_of_tables" class="form-control" required min="1" max="100" value="{{ old('number_of_tables', $restaurant->number_of_tables) }}" />
                        <small style="color: #666;">Current: {{ $restaurant->tables->count() }} tables</small>
                    </div>

                    <div class="form_item">
                        <label style="display: flex; align-items: center; color: #666;">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $restaurant->is_active) ? 'checked' : '' }} style="margin-right: 10px;" />
                            Active Status
                        </label>
                    </div>

                    <button type="submit" class="btn">Update Restaurant</button>
                    <a href="{{ route('super-admin.restaurants.index') }}" class="btn" style="background: #666; margin-top: 10px;">Cancel</a>
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
