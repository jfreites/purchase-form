@if(session()->has('success'))
<div id="userMessage" class="alert alert-success alert-dismissible fade show" role="alert">
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session()->has('warning'))
<div id="userMessage" class="alert alert-warning alert-dismissible fade show" role="alert">
    <span>{{ session('warning') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif