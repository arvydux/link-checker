@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" action={{ route('links.store') }}>
                            {!! csrf_field() !!}

                            <div class="row">
                                <div class="form-group col-md-3{{ $errors->has('url') ? ' has-error' : '' }}">
                                    <label class="control-label" for="name" style="visibility: hidden">URL</label>
                                    <input type="text" class="form-control" name="url" placeholder="URL"">

                                    @if ($errors->has('url'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                                    @endif
                                </div>

                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" name="submit" value="1" class="form-control btn btn-primary">Add URL</button>
                                </div>
                            </div>
                        </form>

                        @include('list')

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
