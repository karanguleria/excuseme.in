@extends('layouts.app')

@section('title', 'Add Restaurant - Super Admin')

@section('content')
<div id="wrapper">
    <section class="loginContentArea">      
        <div class="container" style="max-width: 600px;">
            <div class="login-container">
                <h2 style="text-align: center; margin-bottom: 30px;">Add New Restaurant</h2>
                
                @if ($errors->any())
                    <div style="background: #f44336; color: white; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('super-admin.restaurants.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <h3 style="margin: 20px 0 10px;">Restaurant Details</h3>
                    
                    <div class="form_item">
                        <input type="text" name="name" class="form-control" placeholder="Restaurant Name" required value="{{ old('name') }}" />
                    </div>

                    <div class="form_item">
                        <input type="email" name="email" class="form-control" placeholder="Restaurant Email" required value="{{ old('email') }}" />
                    </div>

                    <div class="form_item">
                        <label style="display: block; margin-bottom: 5px; color: #666;">Restaurant Logo (optional)</label>
                        <input type="file" name="logo" class="form-control" accept="image/*" />
                    </div>

                    <div class="form_item">
                        <input type="number" name="number_of_tables" class="form-control" placeholder="Number of Tables" required min="1" max="100" value="{{ old('number_of_tables') }}" />
                    </div>

                    <h3 style="margin: 20px 0 10px;">Admin User Details</h3>

                    <div class="form_item">
                        <input type="text" name="admin_name" class="form-control" placeholder="Admin Name" required value="{{ old('admin_name') }}" />
                    </div>

                    <div class="form_item">
                        <input type="email" name="admin_email" class="form-control" placeholder="Admin Email" required value="{{ old('admin_email') }}" />
                    </div>

                    <div class="form_item">
                        <input type="password" name="admin_password" class="form-control" placeholder="Admin Password" required minlength="8" />
                    </div>

                    <div class="form_item">
                        <input type="password" name="admin_password_confirmation" class="form-control" placeholder="Confirm Password" required minlength="8" />
                    </div>

                    <button type="submit" class="btn">Create Restaurant</button>
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
