<div id="modal-delete" class="modal-overlay">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div style="padding: 32px;">
            <div style="width: 64px; height: 64px; background: #fff1f2; color: #f43f5e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 20px;">
                <i class="fas fa-trash"></i>
            </div>
            <h2 style="margin: 0 0 8px 0; font-size: 20px; font-weight: 700; color: #0f172a;">Hapus Data?</h2>
            <p style="margin: 0 0 24px 0; font-size: 14px; color: #64748b;">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="form-delete" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" class="btn-cancel" onclick="closeModal('modal-delete')">Batal</button>
                    <button type="submit" class="btn-action" style="background: #f43f5e; color: white;">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
