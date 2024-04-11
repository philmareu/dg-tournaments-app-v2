@extends('vendor.laraform.wrappers.form')

@section('field')

    @if(isset($field['value']))
        <div class="image">
            <img src="{{ url('images/' . $field['value']) }}">
        </div>
    @endif

    <input type="file" name="{{ $field['name'] }}">

@overwrite
