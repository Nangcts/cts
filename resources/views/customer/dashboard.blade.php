@extends('customer.master')
@section('content')
đây là trang cá nhân customer
@endsection
@section('js')
    <script src="{{ URL('js/sparkline-chart.js') }}"></script>
    <script src="{{ URL('js/easy-pie-chart.js') }}"></script>
    <script src="{{ URL('js/count.js') }}"></script>
@endsection