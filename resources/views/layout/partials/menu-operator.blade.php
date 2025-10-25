<div class="pcoded-navigatio-lavel">Operator</div>
<ul class="pcoded-item pcoded-left-item">

    {{-- Dashboard --}}
    <li class="{{ request()->is('admin') ? 'active pcoded-trigger' : '' }}">
        <a href="{{ url('/operators-index') }}">
            <span class="pcoded-micon"><i class="feather icon-home"></i></span>
            <span class="pcoded-mtext">Dashboard</span>
        </a>
    </li>

    {{-- Data Registrasi --}}
    <li class="pcoded-hasmenu {{ request()->is('listpeserta') || request()->is('submission/klhr') ? 'active pcoded-trigger' : '' }}">
        <a href="javascript:void(0)">
            <span class="pcoded-micon"><i class="ion-ios-people"></i></span>
            <span class="pcoded-mtext">Data Registrasi</span>
        </a>
        <ul class="pcoded-submenu">
            <li class="{{ request()->is('listpeserta') ? 'active' : '' }}">
                <a href="{{ url('/datalist') }}"><span class="pcoded-mtext">Data Peserta</span></a>
            </li>
            <li class="{{ request()->is('submission/klhr') ? 'active' : '' }}">
                <a href="{{ url('/submission/klhr') }}"><span class="pcoded-mtext">Submission KLHR</span></a>
            </li>
        </ul>
    </li>  

</ul>
