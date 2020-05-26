@if (session()->has('error'))
    <div class="alert alert-danger" role="alert">
        <div class="alert-text">{{ session('error') }}</div>
    </div>
    @endif

@if (session()->has('success'))
    <div class="alert alert-info" role="alert">
        <div class="alert-text">{{ session('success') }}</div>
    </div>
@endif
