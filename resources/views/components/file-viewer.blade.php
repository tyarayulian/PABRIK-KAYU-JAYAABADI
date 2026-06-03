<!-- FILE VIEWER MODALS -->
<div id="pdfViewerModal" class="pdf-viewer-modal">
    <div class="pdf-viewer-content">
        <div class="pdf-viewer-header">
            <h3 class="pdf-viewer-title" id="pdfViewerTitle">Lihat PDF</h3>
            <div class="viewer-actions">
                <button type="button" class="viewer-download-btn" onclick="downloadPdfViewer()" id="pdfDownloadBtn">
                    <i data-feather="download" style="width: 16px; height: 16px;"></i>
                    <span>Download</span>
                </button>
                <button type="button" class="pdf-viewer-close" onclick="closePdfViewer()" title="Tutup">
                    <i data-feather="x"></i>
                </button>
            </div>
        </div>
        <div class="pdf-viewer-container">
            <iframe id="pdfViewerFrame" src="" type="application/pdf"></iframe>
        </div>
    </div>
</div>

<div id="imageViewerModal" class="image-viewer-modal">
    <div class="image-viewer-content">
        <div class="image-viewer-header">
            <h3 class="image-viewer-title" id="imageViewerTitle">Lihat Gambar</h3>
            <div class="viewer-actions">
                <button type="button" class="viewer-download-btn" onclick="downloadImageViewer()" id="imageDownloadBtn">
                    <i data-feather="download" style="width: 16px; height: 16px;"></i>
                    <span>Download</span>
                </button>
                <button type="button" class="image-viewer-close" onclick="closeImageViewer()" title="Tutup">
                    <i data-feather="x"></i>
                </button>
            </div>
        </div>
        <div class="image-viewer-container">
            <img id="imageViewerImg" src="" alt="Gambar">
        </div>
    </div>
</div>

<style>
    .pdf-viewer-modal, .image-viewer-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .pdf-viewer-modal.active, .image-viewer-modal.active {
        display: flex;
    }

    .pdf-viewer-content, .image-viewer-content {
        background: white;
        border-radius: 12px;
        width: 90%;
        height: 90vh;
        max-width: 1000px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .image-viewer-content {
        max-width: 900px;
    }

    .pdf-viewer-header, .image-viewer-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        border-radius: 12px 12px 0 0;
    }

    .pdf-viewer-title, .image-viewer-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        margin: 0;
        flex: 1;
    }

    .viewer-actions {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .viewer-download-btn {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .viewer-download-btn:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .pdf-viewer-close, .image-viewer-close {
        background: #f3f4f6;
        border: none;
        color: #374151;
        cursor: pointer;
        padding: 0;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        border-radius: 50%;
    }

    .pdf-viewer-close svg, .image-viewer-close svg {
        width: 20px;
        height: 20px;
    }

    .pdf-viewer-close:hover, .image-viewer-close:hover {
        background: #e5e7eb;
        color: #000;
        transform: rotate(90deg);
    }

    .pdf-viewer-container, .image-viewer-container {
        flex: 1;
        overflow: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f3f4f6;
        padding: 20px;
    }

    .pdf-viewer-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        border-radius: 6px;
    }

    .image-viewer-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 6px;
    }
</style>

<script>
    let currentPdfUrl = '';
    let currentPdfFileName = '';
    let currentImageUrl = '';
    let currentImageFileName = '';

    function openViewer(url, fileName) {
        const ext = fileName.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'].includes(ext)) {
            openImageViewer(url, fileName);
        } else if (ext === 'pdf') {
            openPdfViewer(url, fileName);
        } else {
            // Fallback for other files
            window.open(url, '_blank');
        }
    }

    function openPdfViewer(pdfUrl, fileName) {
        const modal = document.getElementById('pdfViewerModal');
        const frame = document.getElementById('pdfViewerFrame');
        const title = document.getElementById('pdfViewerTitle');
        
        currentPdfUrl = pdfUrl;
        currentPdfFileName = fileName || 'file.pdf';
        
        title.textContent = fileName || 'Lihat PDF';
        frame.src = pdfUrl;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Re-run feather icons to ensure they are rendered
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    function closePdfViewer() {
        const modal = document.getElementById('pdfViewerModal');
        const frame = document.getElementById('pdfViewerFrame');
        
        modal.classList.remove('active');
        frame.src = '';
        currentPdfUrl = '';
        currentPdfFileName = '';
        document.body.style.overflow = '';
    }

    function downloadPdfViewer() {
        if (currentPdfUrl) {
            const link = document.createElement('a');
            link.href = currentPdfUrl;
            link.download = currentPdfFileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    function openImageViewer(imageUrl, fileName) {
        const modal = document.getElementById('imageViewerModal');
        const img = document.getElementById('imageViewerImg');
        const title = document.getElementById('imageViewerTitle');
        
        currentImageUrl = imageUrl;
        currentImageFileName = fileName || 'image.jpg';
        
        title.textContent = fileName || 'Lihat Gambar';
        img.src = imageUrl;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // Re-run feather icons to ensure they are rendered
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    function closeImageViewer() {
        const modal = document.getElementById('imageViewerModal');
        const img = document.getElementById('imageViewerImg');
        
        modal.classList.remove('active');
        img.src = '';
        currentImageUrl = '';
        currentImageFileName = '';
        document.body.style.overflow = '';
    }

    function downloadImageViewer() {
        if (currentImageUrl) {
            const link = document.createElement('a');
            link.href = currentImageUrl;
            link.download = currentImageFileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    // Close on overlay click
    window.addEventListener('click', function(event) {
        const pdfModal = document.getElementById('pdfViewerModal');
        if (event.target === pdfModal) {
            closePdfViewer();
        }
        
        const imageModal = document.getElementById('imageViewerModal');
        if (event.target === imageModal) {
            closeImageViewer();
        }
    });

    // Close on Escape key
    window.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePdfViewer();
            closeImageViewer();
        }
    });
</script>
