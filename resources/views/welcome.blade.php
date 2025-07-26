@extends('template.master')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <h2 class="mb-3">Dashboard Utama</h2>

            {{-- Card To Do --}}
            <div class="mb-4 p-4 border border-primary rounded bg-light shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-tasks text-primary mr-2"></i>
                    <h5 class="mb-0">To Do</h5>
                </div>
                <div class="row" id="todo-cards">
                    <!-- Cards akan dirender dengan JavaScript -->
                </div>
            </div>

            {{-- Card Tiket Belum Terselesaikan --}}
            <div class="mb-4 p-4 border border-warning rounded bg-white shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-ticket-alt text-warning mr-2"></i>
                    <h5 class="mb-0">Tiket Belum Terselesaikan</h5>
                </div>
                <div class="row" id="tiket-belum-terselesaikan-cards">
                    <!-- Cards akan dirender dengan JavaScript -->
                </div>
            </div>

            {{-- Card Invoice Belum Lunas --}}
            <div class="mb-4 p-4 border border-danger rounded bg-white shadow-sm">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-file-invoice-dollar text-danger mr-2"></i>
                    <h5 class="mb-0">Invoice Belum Lunas</h5>
                </div>
                <div class="row" id="invoice-belum-lunas-cards">
                    <!-- Cards akan dirender dengan JavaScript -->
                </div>
            </div>

        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchTodos();
            fetchTiketBelumTerselesaikan();
        });

        const progressList = @json($progressList);
        const csrfToken = '{{ csrf_token() }}';

        function renderCards(containerId, data, tipe) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';

            data.forEach(item => {
                const col = document.createElement('div');
                col.className = 'col-md-4 col-lg-4 col-sm-12';

                // Buat select option dari progressList
                let progressOptions = '';
                progressList.forEach(progress => {
                    const selected = progress.id == item.progress_id ? 'selected' : '';
                    progressOptions +=
                        `<option value="${progress.id}" ${selected}>${progress.nama}</option>`;
                });

                const isSelesai = item.progress_id == 4;
                const progressDisplay = isSelesai ?
                    `<div class="form-control-plaintext">${progressList.find(p => p.id == 4)?.nama ?? 'Selesai'}</div>` :
                    `
                    <form method="POST" action="/${tipe}/update-progress">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="id" value="${item.id}">
                        <input type="hidden" name="tipe" value="${item.tipe ?? tipe}">
                        <select class="form-control mb-2" name="progress_id" onchange="this.form.submit()">
                            ${progressOptions}
                        </select>
                    </form>
                `;

                // Jika tipe 'tiket', tampilkan klien_nama
                const klienInfo = item.tipe === 'tiket' && item.klien_nama ?
                    `<p><strong>Klien:</strong> ${item.klien_nama}</p>` :
                    '';

                col.innerHTML = `
                <div class="card mb-4 shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>${item.judul}</strong>
                        ${item.tipe ? `<span class="badge badge-info text-capitalize">${item.tipe}</span>` : ''}
                    </div>
                    <div class="card-body">
                        <p>${item.keterangan}</p>
                        ${klienInfo}
                        <div class="form-group">
                            ${progressDisplay}
                        </div>
                    </div>
                </div>
            `;

                container.appendChild(col);
            });
        }

        function fetchTodos() {
            fetch("{{ route('todo') }}")
                .then(response => response.json())
                .then(data => renderCards('todo-cards', data, 'todo'))
                .catch(error => console.error("Gagal mengambil data TODO:", error));
        }

        function fetchTiketBelumTerselesaikan() {
            fetch("{{ route('tiket.belum-selesai') }}")
                .then(response => response.json())
                .then(data => renderCards('tiket-belum-terselesaikan-cards', data, 'tiket'))
                .catch(error => console.error("Gagal mengambil data tiket:", error));
        }
    </script>
@endsection
