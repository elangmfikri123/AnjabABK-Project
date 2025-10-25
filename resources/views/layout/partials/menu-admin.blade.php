<div class="pcoded-navigatio-lavel">Admin</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Dashboard --}}
    <li class="{{ request()->is('admin') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/admin-index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>

    {{-- Data User --}}
    <li class="pcoded-hasmenu {{ request()->is('listuser') || request()->is('listjuri') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="feather icon-users"></i></span>
            <span class="pcoded-mtext">Data User</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listuser') ? 'active' : '' }}">
                <a href="{{ url('/listuser') }}"><span class="pcoded-mtext">Data User</span></a>
            </li>
        </ul>
    </li>

    {{-- Data Registrasi --}}
    <li class="pcoded-hasmenu {{ request()->is('listpeserta') || request()->is('submission/klhr') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ion-ios-people"></i></span>
            <span class="pcoded-mtext">Data Registrasi</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listpeserta') ? 'active' : '' }}">
                <a href="{{ url('/data-eksisting/admin') }}"><span class="pcoded-mtext">Data Eksisting</span></a>
            </li>
            <li class="{{ request()->is('listpeserta') ? 'active' : '' }}">
                <a href="{{ url('/data-anjab/admin') }}"><span class="pcoded-mtext">Data Anjab ABK</span></a>
            </li>
        </ul>
    </li>

    {{-- Other --}}
    <li class="pcoded-hasmenu {{ request()->is('categorylist') || request()->is('maindealerlist') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ion-android-settings"></i></span>
            <span class="pcoded-mtext">Other</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('categorylist') ? 'active' : '' }}">
                <a href="{{ url('/akseskecamatan/admin') }}"><span class="pcoded-mtext">Daftar Kecamatan</span></a>
            </li>
            <li class="{{ request()->is('categorylist') ? 'active' : '' }}">
                <a href="{{ url('/aksessekolah/admin') }}"><span class="pcoded-mtext">Daftar Sekolah</span></a>
            </li>
            <li class="{{ request()->is('maindealerlist') ? 'active' : '' }}">
                <a href="{{ url('/aksesjabatan/admin') }}"><span class="pcoded-mtext">Daftar Jabatan</span></a>
            </li>
            <li class="{{ request()->is('maindealerlist') ? 'active' : '' }}">
                <a href="{{ url('/aksesgolongan/admin') }}"><span class="pcoded-mtext">Daftar Golongan</span></a>
            </li>
            <li class="{{ request()->is('maindealerlist') ? 'active' : '' }}">
                <a href="{{ url('/aksesjenis-guru/admin') }}"><span class="pcoded-mtext">Jenis Guru</span></a>
            </li>
            <li class="{{ request()->is('maindealerlist') ? 'active' : '' }}">
                <a href="{{ url('/aksesmapel/admin') }}"><span class="pcoded-mtext">Mata Pelajaran</span></a>
            </li>
        </ul>
    </li>

</ul>
