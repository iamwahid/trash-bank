<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">
                @lang('menus.backend.sidebar.general')
            </li>
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/dashboard'))
                }}" href="{{ route('admin.dashboard') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    @lang('menus.backend.sidebar.dashboard')
                </a>
            </li>
            @if (!$logged_in_user->isAdmin())
            <li class="nav-item">
                <a class="nav-link {{
                    active_class(Active::checkUriPattern('admin/kasir'))
                }}" href="{{ route('admin.kasir.index') }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    Kasir
                </a>
            </li>
            @endif

            @if ($logged_in_user->isAdmin())
            {{-- Siswa --}}
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/siswa*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/siswa*')) }}" href="#">
                    <i class="nav-icon far fa-user"></i> Siswa
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/siswa')) }}" href="{{ route('admin.siswa.index') }}">
                            Daftar Siswa
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/siswa/create')) }}" href="{{ route('admin.siswa.create') }}">
                            Tambah Siswa
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- Barang --}}
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/barang*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/barang*')) }}" href="#">
                    <i class="nav-icon far fa-file"></i> Barang
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/barang')) }}" href="{{ route('admin.barang.index') }}">
                            Daftar Barang
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/barang/create')) }}" href="{{ route('admin.barang.create') }}">
                            Tambah Barang
                        </a>
                    </li>
                    @endif
                </ul>
            </li>

            {{-- Jualan --}}
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/jualan*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/jualan*')) }}" href="#">
                    <i class="nav-icon far fa-file"></i> Jualan
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/jualan')) }}" href="{{ route('admin.jualan.index') }}">
                            Daftar Jualan
                        </a>
                    </li>
                    @if ($logged_in_user->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/jualan/create')) }}" href="{{ route('admin.jualan.create') }}">
                            Tambah Jualan
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            {{-- Transaksi --}}
            <li class="nav-item nav-dropdown {{ active_class(Active::checkUriPattern('admin/transaksi*'), 'open') }}">
                <a class="nav-link nav-dropdown-toggle {{ active_class(Active::checkUriPattern('admin/transaksi*')) }}" href="#">
                    <i class="nav-icon far fa-file"></i> Transaksi
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ active_class(Active::checkUriPattern('admin/transaksi')) }}" href="{{ route('admin.transaksi.index') }}">
                            Daftar Transaksi
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-title">
                @lang('menus.backend.sidebar.system')
            </li>

            @if ($logged_in_user->isAdmin())
                <li class="nav-item nav-dropdown {{
                    active_class(Active::checkUriPattern('admin/auth*'), 'open')
                }}">
                    <a class="nav-link nav-dropdown-toggle {{
                        active_class(Active::checkUriPattern('admin/auth*'))
                    }}" href="#">
                        <i class="nav-icon far fa-user"></i>
                        @lang('menus.backend.access.title')

                        @if ($pending_approval > 0)
                            <span class="badge badge-danger">{{ $pending_approval }}</span>
                        @endif
                    </a>

                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/user*'))
                            }}" href="{{ route('admin.auth.user.index') }}">
                                @lang('labels.backend.access.users.management')

                                @if ($pending_approval > 0)
                                    <span class="badge badge-danger">{{ $pending_approval }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{
                                active_class(Active::checkUriPattern('admin/auth/role*'))
                            }}" href="{{ route('admin.auth.role.index') }}">
                                @lang('labels.backend.access.roles.management')
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div><!--sidebar-->
