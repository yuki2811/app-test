@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Hello {{Auth::user()->email}} !</h1>
                    @if (Auth::user()->role == 1)
                        <h3>Bạn là admin</h3>
                    @else
                        <h3>Bạn là guest</h3>
                    @endif
                    <a href="{{route('teacher.index')}}">Đi đến teacher</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
