@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Channel Settings</div>
                <div class="card-body">
                    <form action="{{ route('channel.update', $channel->slug) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ? old('name') : $channel->name }}">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="slug">Unique URL</label>

                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text" id="slug">{{ config('app.url') }}/channel/</span>
                              </div>

                                <input id="slug" type="text" class="form-control {{ $errors->has('slug') ? ' is-invalid' : '' }}" name="slug" value="{{ old('slug') ? old('slug') : $channel->slug }}">
                               </div>
                            
                            @if ($errors->has('slug'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('slug') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>

                            <textarea name="description" id="description" class="form-control">{{ old('description') ? old('description') : $channel->description }}</textarea>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button class="btn btn-outline-secondary" type="submit">Update</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection