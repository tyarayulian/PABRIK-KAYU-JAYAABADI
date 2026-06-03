@if(session('success'))
<div style="background-color: #f0f7ff; border-left: 4px solid #1e2a78; color: #1e2a78; padding: 16px; margin-bottom: 24px; border-radius: 8px; display: flex; align-items: center; gap: 12px;" role="alert">
    <i class="fas fa-check-circle"></i>
    <div>
        <span style="font-weight: 700;">Berhasil!</span> {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div style="background-color: #fff1f2; border-left: 4px solid #f43f5e; color: #991b1b; padding: 16px; margin-bottom: 24px; border-radius: 8px; display: flex; align-items: center; gap: 12px;" role="alert">
    <i class="fas fa-exclamation-circle"></i>
    <div>
        <span style="font-weight: 700;">Error!</span> {{ session('error') }}
    </div>
</div>
@endif
