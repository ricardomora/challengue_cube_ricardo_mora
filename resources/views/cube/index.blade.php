@extends('layouts.template')

@section('content')

<div class="container text-center">
    <div class="page-header">
        <h1>
            Cube Summation Challengue
        </h1>
    </div>

    <div class="page">
        <div class="col-md-8">
            <h3>Instructions</h3><hr>
            <div class="panel" style="text-align: left">
                <p>You are given a 3-D Matrix in which each block contains 0 initially. The first block is defined by the coordinate (1,1,1) and the last block is defined by the coordinate (N,N,N). There are two types of queries.</p>
                <h3>
                    <span class="label label-success">UPDATE x y z W</span>
                </h3>
                <p>
                    updates the value of block (x,y,z) to W.
                </p>
                <h3>
                    <span class="label label-success">QUERY x1 y1 z1 x2 y2 z2</span>
                </h3>
                <p>calculates the sum of the value of blocks whose x coordinate is between x1 and x2 (inclusive), y coordinate between y1 and y2 (inclusive) and z coordinate between z1 and z2 (inclusive).</p>

                <h3>Input Format</h3>
                <ul>
                    <li>The first line contains an integer T, the number of test-cases. T testcases follow.</li>
                    <li>For each test case, the first line will contain two integers N and M separated by a single space.</li>
                    <li>N defines the N * N * N matrix. </li>
                    <li>M defines the number of operations. </li>
                    <li>The next M lines will contain either </li>
                </ul>

                <h3>
                    <span class="label label-success"> 1. UPDATE x y z W </span>
                    <span class="label label-success"> 2. QUERY  x1 y1 z1 x2 y2 z2 </span>
                </h3>

                <h3>Sample Input</h3>
                <p>
                    2 
                    <br>4 5
                    <br>UPDATE 2 2 2 4
                    <br>QUERY 1 1 1 3 3 3
                    <br>UPDATE 1 1 1 23
                    <br>QUERY 2 2 2 4 4 4
                    <br>QUERY 1 1 1 3 3 3
                    <br>2 4
                    <br>UPDATE 2 2 2 1
                    <br>QUERY 1 1 1 1 1 1
                    <br>QUERY 1 1 1 2 2 2
                    <br>QUERY 2 2 2 2 2 2
                </p>

                <h3>Sample Output</h3>
                <p>
                    4
                    <br>4
                    <br>27
                    <br>0
                    <br>1
                    <br>1
                </p>
            </div>
        </div>


        <div class="col-md-4">

            @if (count($errors) > 0)
            @include('error.deserror')
            @endif


            <form class="form-signin" method="POST" novalidate >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <h3>Data input</h3>
                <div class="form-group ">
                    <textarea class="form-control" rows="12" id="text-in" name="text-in" value="" {{ !empty($textold) ? 'disabled' : '' }}>{{ !empty($textold) ? $textold : "" }}</textarea>
                </div>
                <button class="btn btn-lg btn-primary " type="submit" style="display:{{ !empty($textold) ? 'none' : '' }}">Submit cube</button>

            </form>


            <h3>Data Output </h3>
            @if (count($result) > 0)
            <div class="alert alert-success">
                <ul>
                    @foreach ($result as $res)
                    <li>{{ $res }}</li>
                    @endforeach
                </ul>
            </div>
            <a href="{{ route('cube-index') }}" class="btn btn-lg btn-danger " >Reset cube </a>
            @else
            <div class="alert alert-danger"> No results </div>
            @endif;


        </div>	

    </div>
</div>

@endsection