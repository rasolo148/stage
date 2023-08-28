@if(session('error'))
<div class="alert alert-danger" role="alert">
    {{ session('error') }}
</div>
@endif
@if(session('success'))
<div class="alert alert-success" role="alert">
    {{ session('success') }}
</div>
@endif
@if(session('modification'))
<div class="alert alert-info" role="alert">
    {{ session('modification') }}
</div>
@endif
@if(session('suppression'))
<div class="alert alert-warning" role="alert">
    {{ session('suppression') }}
</div>
@endif
@if(session('deconnecter'))
<div class="alert alert-success" role="alert">
    {{ session('deconnecter') }}
</div>
@endif
