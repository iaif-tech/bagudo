@extends('government::layouts.master')

@section('page-title')
    {{'Reported Accidents in'}} {{governmentChartPage()}}
@endsection

@section('page-content')

<div class="col md-12">
    {!! $accident->container() !!}
    {!! $accident->script() !!}
</div>
@endsection


