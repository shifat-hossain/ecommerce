
@extends('layouts.home')

@section('title', 'Page Title')

@section('home_content')

<!-- section start -->
<section class="p-0">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    <h1>404</h1>
                    <h2>page not found</h2>
                    @php
                    
                    @endphp
                    
                    <!--<a href="" class="btn btn-solid">back</a>-->
                    <a href="{{url('/')}}" class="btn btn-solid">Go to homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->

@endsection