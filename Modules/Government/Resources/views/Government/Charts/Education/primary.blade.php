@extends('government::layouts.master')

@section('page-title')
    
@endsection
@section('page-content')
<h3>{{"Reported"}} {{governmentChartPage()}}  {{"Children Admitted in various Primary Schools In Nigeria"}}</h3>
<div class="col md-12">
    {!! $admitted->container() !!}
    {!! $admitted->script() !!}
</div>

<h3>{{"Reported"}} {{governmentChartPage()}}  {{"Pupils Finishes in various Primary School In Nigeria"}}</h3>
<div class="col md-12">
    {!! $graduated->container() !!}
    {!! $graduated->script() !!}
</div>
@endsection


