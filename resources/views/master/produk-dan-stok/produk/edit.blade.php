@extends('layouts.app')

@section('title', 'Edit Produk')
@section('breadcrumb', 'Master Data > Produk > Edit')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .page-container { padding: 40px 24px; background-color: #f8fafc; min-height: 100vh; font-family: 'Plus Jakarta Sans', sans-serif; }
    .card { background: white; border-radius: 28px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); border: 1px solid #f1f5f9; overflow: hidden; width: 100%; }
    .card-header { padding: 32px 48px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; }
    .card-header h2 { margin: 0; font-size: 24px; font-weight: 800; color: #0f172a; }
    .card-body { padding: 48px; }

    .form-section { display: grid; grid-template-columns: 280px 1fr; gap: 48px; margin-bottom: 48px; }
    .section-info h3 { margin: 0 0 12px 0; font-size: 18px; font-weight: 700; color: #0f172a; }
    .section-info p { font-size: 14px; color: #64748b; line-height: 1.6; }

    .form-group label { display: block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control { width: 100%; padding: 12px 16px; border: 1.5px solid #f1f5f9; border-radius: 12px; font-size: 14px; font-weight: 500; background-color: #ffffff; transition: all 0.2s; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #1e2a78; background-color: #fff; box-shadow: 0 0 0 4px rgba(30, 42, 120, 0.05); }

    /* Checklist Kategori */
    .category-checklist { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 10px; }
    .check-item { position: relative; }
    .check-item input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
    .check-label {
        display: flex; align-items: center; gap: 10px; padding: 10px 24px;
        background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 12px;
        font-weight: 700; color: #64748b; font-size: 13px; text-transform: uppercase;
        letter-spacing: 0.5px; cursor: pointer; transition: all 0.2s;
    }
    .check-label i { font-size: 14px; opacity: 0.5; }
    .check-item input:checked + .check-label {
        background: #1e2a78; border-color: #1e2a78; color: white;
        box-shadow: 0 4px 12px rgba(30, 42, 120, 0.15);
    }
    .check-item input:checked + .check-label i { opacity: 1; color: white; }
    .check-label:hover { border-color: #1e2a78; color: #1e2a78; background: #f9fbff; }
    .check-item input:checked + .check-label:hover { background: #151d54; color: white; }

    /* Badge existing */
    .badge-existing {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-size: 10px;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.25);
    }
    .badge-existing i {
        font-size: 9px;
    }
    .check-item input:checked + .check-label .badge-existing {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        box-shadow: none;
    }

    /* Category Panels */
    .category-panel { background: #fff; border: 1.5px solid #f1f5f9; border-radius: 20px; padding: 24px; margin-bottom: 24px; display: none; }
    .category-panel.active { display: block; animation: slideDown 0.3s ease-out; }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }

    .panel-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #f1f5f9; }
    .panel-header h4 { font-weight: 800; color: #1e2a78; text-transform: uppercase; letter-spacing: 1px; margin: 0; font-size: 14px; display: flex; align-items: center; gap: 10px; }

    .size-row { display: grid; grid-template-columns: 1.5fr 1fr 40px; gap: 15px; margin-bottom: 20px; align-items: flex-end; }
    .size-row .form-group label { font-size: 11px; margin-bottom: 10px; white-space: nowrap; font-weight: 800; color: #475569; }
    .size-row .form-control { padding: 12px 14px; font-size: 14px; border-radius: 12px; font-weight: 600; }

    .btn-add-size { background: #f1f5f9; color: #1e2a78; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 800; font-size: 11px; cursor: pointer; transition: 0.2s; }
    .btn-add-size:hover { background: #e2e8f0; }
    .btn-remove-row { color: #ef4444; background: #fff1f2; border: none; cursor: pointer; height: 42px; width: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; transition: 0.2s; }
    .btn-remove-row:hover { background: #fee2e2; transform: scale(1.05); }

    .card-footer { padding: 32px 48px; background: #f8fafc; border-top: 1px solid #f1f5f9; display: flex; justify-content: flex-end; gap: 16px; }
    .btn-save { background: #1e2a78; color: white; border: none; padding: 14px 40px; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; }
    .btn-save:hover { background: #151d54; transform: translateY(-1px); box-shadow: 0 8px 15px rgba(30, 42, 120, 0.2); }
</style>
@endsection

@section('content')
@php
    $allSameWood = \App\Models\Product::where('wood_type', $product->wood_type)
        ->orderBy('product_category')->orderBy('size')->get();
    $groupedByCategory = $allSameWood->groupBy('product_category');
    $existingCategories = $groupedByCategory->keys()->map(fn($k) => strtolower($k))->toArray();
    $allCategories = ['Balok', 'Papan', 'Kasau'];
    // Tambahkan kategori existing yang tidak ada di daftar default
    foreach ($groupedByCategory->keys() as $cat) {
        if ($cat && !in_array($cat, $allCategories)) {
            $allCategories[] = $cat;
        }
    }
@endphp

<div class="page-container">
    <div class="card">
        <div class="card-header">
            <div>
                <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Edit Produk</div>
                <h2>{{ $product->wood_type }}</h2>
            </div>
            <a href="{{ route('master.products.index') }}" style="color: #64748b; text-decoration: none; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 6px;">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>

        <form action="{{ route('master.products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="cost" value="{{ $product->cost }}">
            <input type="hidden" name="stock" value="{{ $product->initial_stock }}">

            <div class="card-body">
                @if(session('error') || $errors->any())
                    <div style="background: #fff1f2; color: #dc2626; padding: 16px; border-radius: 12px; margin-bottom: 32px; font-weight: 600; border: 1px solid #ffe4e6;">
                        @if(session('error')) {{ session('error') }} @else Periksa kembali inputan Anda. @endif
                    </div>
                @endif

                <!-- Identitas Utama -->
                <div class="form-section">
                    <div class="section-info">
                        <h3>Identitas Produk</h3>
                        <p>Perbarui data produk yang sudah terdaftar.</p>
                    </div>
                    <div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            <label>Jenis Kayu*</label>
                            <input type="text" name="wood_type" id="wood_type" class="form-control"
                                   value="{{ old('wood_type', $product->wood_type) }}"
                                   placeholder="Contoh: Duren, Senggon, Racuk" required>
                        </div>
                        <div class="form-group">
                            <a href="#" id="toggle-category-section"
                               style="font-size: 13px; font-weight: 700; color: #1e2a78; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif;">
                                <i class="fas fa-plus-circle"></i><span id="toggle-label"> Mau edit / tambah kategori produk?</span>
                            </a>

                            <div id="category-section" style="display: none; margin-top: 16px;">
                                <label style="display:block; margin-bottom: 10px; font-weight: 800; color: #334155; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    Kategori Bentuk
                                </label>
                                <div class="category-checklist">
                                    @foreach($allCategories as $cat)
                                    @php $isExisting = in_array(strtolower($cat), $existingCategories); @endphp
                                    <div class="check-item">
                                        <input type="checkbox" id="check-{{ \Str::slug($cat) }}"
                                               class="cat-checkbox"
                                               data-category="{{ $cat }}"
                                               data-slug="{{ \Str::slug($cat) }}"
                                               {{ $isExisting ? 'checked' : '' }}>
                                        <label for="check-{{ \Str::slug($cat) }}" class="check-label">
                                            <i class="fas fa-check-circle"></i> {{ $cat }}
                                            @if($isExisting)
                                                <span class="badge-existing"><i class="fas fa-check"></i> Tersimpan</span>
                                            @endif
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel per Kategori — tersembunyi by default, muncul setelah klik toggle -->
                <div id="category-panels-container" style="display: none;">
                    @foreach($allCategories as $cat)
                    @php
                        $catSlug = \Str::slug($cat);
                        $isExisting = $groupedByCategory->has($cat);
                        $catProducts = $isExisting ? $groupedByCategory[$cat] : collect();
                        $catIdx = array_search($cat, $allCategories);
                    @endphp
                    <div class="category-panel {{ $isExisting ? 'active' : '' }}"
                         id="panel-{{ $catSlug }}">
                        <div class="panel-header">
                            <h4>
                                Bagian: {{ $cat }}
                                @if($isExisting)
                                    <span class="badge-existing">Data Existing</span>
                                @else
                                    <span style="background:#fef9c3;color:#ca8a04;font-size:9px;font-weight:800;padding:2px 7px;border-radius:6px;text-transform:uppercase;">Baru</span>
                                @endif
                            </h4>
                            <button type="button" class="btn-add-size"
                                    onclick="addSizeRow('{{ $catSlug }}', {{ $catIdx }})">
                                + Tambah Ukuran
                            </button>
                            <input type="hidden" name="products[{{ $catIdx }}][category]" value="{{ $cat }}">
                        </div>
                        <div class="size-rows-container" id="rows-{{ $catSlug }}">
                            @if($isExisting)
                                @foreach($catProducts as $p)
                                @php $rowIdx = $loop->index; @endphp
                                <div class="size-row" style="grid-template-columns: 1.5fr 1fr;">
                                    <input type="hidden" name="products[{{ $catIdx }}][items][{{ $rowIdx }}][product_id]" value="{{ $p->id }}">
                                    <div class="form-group">
                                        <label>Ukuran*</label>
                                        <input type="text"
                                               name="products[{{ $catIdx }}][items][{{ $rowIdx }}][size]"
                                               class="form-control"
                                               value="{{ old("products.{$catIdx}.items.{$rowIdx}.size", $p->size) }}"
                                               placeholder="Contoh: 8x12x4" required>
                                    </div>
                                    <div class="form-group">
                                        <label>QTY / Kubik</label>
                                        <input type="text" inputmode="numeric"
                                               name="products[{{ $catIdx }}][items][{{ $rowIdx }}][cubic_content]"
                                               class="form-control"
                                               value="{{ old("products.{$catIdx}.items.{$rowIdx}.cubic_content", $p->cubic_content) }}"
                                               placeholder="0"
                                               readonly
                                               style="background-color: #f1f5f9; color: #94a3b8; cursor: not-allowed;">
                                    </div>
                                    {{-- Tidak ada tombol hapus untuk data existing --}}
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>{{-- end card-body --}}

            <div class="card-footer">
                <a href="{{ route('master.products.index') }}" style="display:flex;align-items:center;padding:14px 24px;border-radius:12px;font-weight:700;color:#64748b;text-decoration:none;font-size:14px;">
                    Batal
                </a>
                <button type="submit" class="btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Counter per kategori untuk new rows
    const rowCounters = {};

    @foreach($allCategories as $cat)
    @php
        $catSlug = \Str::slug($cat);
        $catIdx = array_search($cat, $allCategories);
        $count = $groupedByCategory->has($cat) ? $groupedByCategory[$cat]->count() : 0;
    @endphp
    rowCounters['{{ $catSlug }}'] = {{ $count }};
    @endforeach

    // Toggle category section
    document.getElementById('toggle-category-section').addEventListener('click', function(e) {
        e.preventDefault();
        const section = document.getElementById('category-section');
        const panels = document.getElementById('category-panels-container');
        const icon = this.querySelector('i');
        const label = this.querySelector('span#toggle-label');
        const isHidden = section.style.display === 'none';

        section.style.display = isHidden ? 'block' : 'none';
        panels.style.display  = isHidden ? 'block' : 'none';
        icon.className  = isHidden ? 'fas fa-minus-circle' : 'fas fa-plus-circle';
        this.style.color = isHidden ? '#dc2626' : '#1e2a78';
        label.textContent = isHidden ? ' Sembunyikan kategori' : ' Mau edit / tambah kategori produk?';
    });

    // Handle checklist toggle
    document.querySelectorAll('.cat-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const slug = this.dataset.slug;
            const panel = document.getElementById('panel-' + slug);
            if (!panel) return;

            if (this.checked) {
                panel.classList.add('active');
                // Kalau panel baru (kosong), tambah 1 baris otomatis
                const rows = panel.querySelector('.size-rows-container');
                if (rows && rows.children.length === 0) {
                    const catIdx = getCatIdx(slug);
                    addSizeRow(slug, catIdx);
                }
            } else {
                panel.classList.remove('active');
            }
        });
    });

    function getCatIdx(slug) {
        const allSlugs = @json(array_map(fn($c) => \Str::slug($c), $allCategories));
        return allSlugs.indexOf(slug);
    }

    function addSizeRow(catSlug, catIdx) {
        const container = document.getElementById('rows-' + catSlug);
        const rowIdx = rowCounters[catSlug]++;

        const row = document.createElement('div');
        row.className = 'size-row';
        row.innerHTML = `
            <div class="form-group">
                <label>Ukuran*</label>
                <input type="text" name="products[${catIdx}][items][${rowIdx}][size]"
                       class="form-control" placeholder="Contoh: 8x12x4">
            </div>
            <div class="form-group">
                <label>QTY / Kubik</label>
                <input type="text" inputmode="numeric"
                       name="products[${catIdx}][items][${rowIdx}][cubic_content]"
                       class="form-control" placeholder="0">
            </div>
            <button type="button" class="btn-remove-row" onclick="removeSizeRow(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(row);
        row.querySelector('input').focus();
    }

    function removeSizeRow(btn) {
        const row = btn.closest('.size-row');
        const container = row.parentElement;
        if (container.children.length > 1) {
            row.remove();
        } else {
            if (typeof Toast !== 'undefined') {
                Toast.warning('Minimal harus ada satu ukuran untuk kategori ini.');
            } else {
                alert('Minimal harus ada satu ukuran.');
            }
        }
    }
</script>
@endsection
