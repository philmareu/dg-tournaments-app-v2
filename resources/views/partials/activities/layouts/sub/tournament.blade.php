@extends('partials.activities.layouts.default')

@section('image')
    <img src="{{ url('images/' . $activity->resource->poster->filename) }}" alt="Round Image" class="uk-margin" width="40">
@overwrite
