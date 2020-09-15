@extends('layouts.app')

@section('title', __('Settings'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
{{--            <div class="card">--}}
{{--                <div class="card-header">Dashboard</div>--}}

{{--                <div class="card-body">--}}
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @role('admin')
                    <passport-clients></passport-clients>
                    <br />

                    <passport-authorized-clients></passport-authorized-clients>
                    <br />

                    <passport-personal-access-tokens></passport-personal-access-tokens>
                    <br />

                    <api2cart-configuration></api2cart-configuration>
                    <br />

                    <rmsapi-configuration></rmsapi-configuration>
                    <br />

                    <printnode-configuration></printnode-configuration>
                    <br />
                    @endrole
                    <printer-configuration></printer-configuration>
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</div>
@endsection
