<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-building"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SITUGAS</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if(Auth()->user()->jabatan->akses_master)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master"
            aria-expanded="true" aria-controls="master">
            <i class="fas fa-fw fa-database"></i>
            <span>{{ ucwords(str_replace('_', ' ', 'master')) }}</span>
        </a>
        <div id="master" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                @if(Auth()->user()->jabatan->akses_master_daftar_divisi)
                <a class="collapse-item" href="{{ route('divisi.index') }}">{{ ucwords(str_replace('_', ' ', 'divisi')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_jabatan)
                <a class="collapse-item" href="{{ route('jabatan.index') }}">{{ ucwords(str_replace('_', ' ', 'jabatan')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_user)
                <a class="collapse-item" href="{{ route('user.index') }}">{{ ucwords(str_replace('_', ' ', 'user')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_progress)
                <a class="collapse-item" href="{{ route('progress.index') }}">{{ ucwords(str_replace('_', ' ', 'progress')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_level_klien)
                <a class="collapse-item" href="{{ route('level_klien.index') }}">{{ ucwords(str_replace('_', ' ', 'level_klien')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_klien)
                <a class="collapse-item" href="{{ route('klien.index') }}">{{ ucwords(str_replace('_', ' ', 'klien')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_master_daftar_produk)
                <a class="collapse-item" href="{{ route('produk.index') }}">{{ ucwords(str_replace('_', ' ', 'produk')) }}</a>
                @endif
            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->jabatan->akses_customer_service)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customer_service"
            aria-expanded="true" aria-controls="customer_service">
            <i class="fas fa-fw fa-headset"></i>
            <span>{{ ucwords(str_replace('_', ' ', 'customer_service')) }}</span>
        </a>
        <div id="customer_service" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                @if(Auth()->user()->jabatan->akses_daftar_jenis_tiket)
                <a class="collapse-item" href="{{ route('jenis_tiket.index') }}">{{ ucwords(str_replace('_', ' ', 'jenis_tiket')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_daftar_tiket)
                <a class="collapse-item" href="{{ route('tiket.index') }}">{{ ucwords(str_replace('_', ' ', 'tiket')) }}</a>
                @endif

            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->jabatan->akses_tugas)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tugas"
            aria-expanded="true" aria-controls="tugas">
            <i class="fas fa-fw fa-tasks"></i>
            <span>{{ ucwords(str_replace('_', ' ', 'tugas')) }}</span>
        </a>
        <div id="tugas" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                @if(Auth()->user()->jabatan->akses_daftar_tugas_rutin)
                <a class="collapse-item" href="{{ route('tugas_rutin.index') }}">{{ ucwords(str_replace('_', ' ', 'tugas_rutin')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_daftar_tugas)
                <a class="collapse-item" href="{{ route('tugas.index') }}">{{ ucwords(str_replace('_', ' ', 'tugas')) }}</a>
                @endif

            </div>
        </div>
    </li>
    @endif

    @if(Auth()->user()->jabatan->akses_keuangan)
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#keuangan"
            aria-expanded="true" aria-controls="keuangan">
            <i class="fas fa-fw fa-wallet"></i>
            <span>{{ ucwords(str_replace('_', ' ', 'keuangan')) }}</span>
        </a>
        <div id="keuangan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                @if(Auth()->user()->jabatan->akses_daftar_jenis_akun)
                <a class="collapse-item" href="{{ route('jenis_akun.index') }}">{{ ucwords(str_replace('_', ' ', 'jenis_akun')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_daftar_akun)
                <a class="collapse-item" href="{{ route('akun.index') }}">{{ ucwords(str_replace('_', ' ', 'akun')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_daftar_tagihan)
                <a class="collapse-item" href="{{ route('tagihan.index') }}">{{ ucwords(str_replace('_', ' ', 'tagihan')) }}</a>
                @endif

                @if(Auth()->user()->jabatan->akses_daftar_pelunasan)
                <a class="collapse-item" href="{{ route('pelunasan.index') }}">{{ ucwords(str_replace('_', ' ', 'pelunasan')) }}</a>
                @endif

            </div>
        </div>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
