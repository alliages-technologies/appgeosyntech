@extends('......layouts.consultant')
@section('content')


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                 @include('includes.Show.formation_left_side')
            </div>
            <div class="col-md-8 col-sm-12">
                 @include('includes.Show.formation_right_side')
            </div>
        </div>
    </div>


@endsection
