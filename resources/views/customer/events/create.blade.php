@extends('layouts.customer')
@section('title', 'دعوة جديدة')

@push('styles')
<style>
    .form-input:disabled { background: #f5f5f4; cursor: not-allowed; color: #a8a29e; }
</style>
@endpush

@section('content')
    @livewire('event-wizard')
@endsection
