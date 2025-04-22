@extends('layouts.customer-app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include('admin.blocks.flash')
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Customer Dashboard - {{ Auth::guard('customer')->check() ? 'Khach Hang' : 'Admin' }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif

                    Customer logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
