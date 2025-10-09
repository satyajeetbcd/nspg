@extends('admin.layouts.app')

@section('title', 'Edit Calculator Setting')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Calculator Setting</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.calculator.index') }}">Calculator Settings</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Setting: {{ ucwords(str_replace('_', ' ', $calculator->setting_key)) }}</h5>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.calculator.update', $calculator->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="setting_key" class="form-label">Setting Key</label>
                            <input type="text" class="form-control" id="setting_key" value="{{ $calculator->setting_key }}" readonly>
                            <div class="form-text">This field cannot be changed</div>
                        </div>

                        <div class="mb-3">
                            <label for="setting_type" class="form-label">Setting Type</label>
                            <input type="text" class="form-control" id="setting_type" value="{{ ucfirst($calculator->setting_type) }}" readonly>
                            <div class="form-text">This field cannot be changed</div>
                        </div>

                        <div class="mb-3">
                            <label for="setting_value" class="form-label">Setting Value *</label>
                            @if($calculator->setting_type === 'boolean')
                                <select class="form-select @error('setting_value') is-invalid @enderror" id="setting_value" name="setting_value" required>
                                    <option value="1" {{ $calculator->setting_value == '1' ? 'selected' : '' }}>Yes (True)</option>
                                    <option value="0" {{ $calculator->setting_value == '0' ? 'selected' : '' }}>No (False)</option>
                                </select>
                            @elseif($calculator->setting_type === 'number')
                                <input type="number" class="form-control @error('setting_value') is-invalid @enderror" 
                                       id="setting_value" name="setting_value" value="{{ $calculator->setting_value }}" 
                                       step="0.01" required>
                            @else
                                <textarea class="form-control @error('setting_value') is-invalid @enderror" 
                                          id="setting_value" name="setting_value" rows="3" required>{{ $calculator->setting_value }}</textarea>
                            @endif
                            @error('setting_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2">{{ old('description', $calculator->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       {{ $calculator->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (This setting will be used by the calculator)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.calculator.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Setting</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
