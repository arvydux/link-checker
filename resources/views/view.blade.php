@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <label class="control-label" for="name" style="visibility: hidden">URL</label>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Given URL</p></strong>
                            </div>
                            <div class="col-md-10">
                                {{ $link->url }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Redirects</p></strong>
                            </div>
                            <div class="col-md-10">
                                <table class="table table-hover table-striped" style="font-size:16px">
                                    <thead>
                                    <tr>
                                        <th>HTTP status code</th>
                                        <th>URL redirect</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($link->redirects as $urlRedirect => $statusCode)
                                            <tr>
                                                <td><span class="badge badge-warning">{{ $statusCode }}</span></td>
                                                <td><a href={{ $urlRedirect }}>{{ $urlRedirect }}</a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Redirect amount</p></strong>
                            </div>
                            <div class="col-md-10">
                                {{ $link->redirect_amount }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Keywords</p></strong>
                            </div>
                            <div class="col-md-10">
                                {{ $link->keywords }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Added</p></strong>
                            </div>
                            <div class="col-md-10">
                                <div>
                                    {{ $link->created_at->format('Y-m-d H:i:s') }}
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-2">
                                <strong><p>Checked</p></strong>
                            </div>
                            <div class="col-md-8">
                                {{ $link->updated_at->format('Y-m-d H:i:s') }}
                            </div>
                        </div>

                        <a  class="btn btn-primary" href="{{ url('/links') }}">Back</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
