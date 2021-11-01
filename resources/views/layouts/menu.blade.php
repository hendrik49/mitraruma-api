<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link active">
        <i class="nav-icon fas fa-home"></i>
        <p>Beranda</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Proyek
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="/admin/proyek" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Konsultasi</p>
            </a>
        </li>
        {{-- <li class="nav-item">
        <a href="/admin/pembayaran" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Pembayaran</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="/admin/proyek" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Jadwal</p>
        </a>
      </li> --}}
    </ul>
</li>
@if (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'vendor')
    <li class="nav-item">
        <a href="" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Aplikator
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview" style="display: none;">
            <li class="nav-item">
                <a href="/admin/aplikators" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Review</p>
                </a>
            </li>
            @if (Auth::user()->user_type == 'admin')
                <li class="nav-item">
                    <a href="/admin/aplikator-dashboard-index" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            @elseif(Auth::user()->user_type=="vendor")
                <li class="nav-item">
                    <a href="/admin/aplikator-dashboard" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            @endif
        </ul>
    </li>
@endif

<li class="nav-item">
    <a href="" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            CMS Managment
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
        <li class="nav-item">
            <a href="/admin/seting" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Seting</p>
            </a>
        </li>
        @if (Auth::user()->user_type == 'admin')
            <li class="nav-item">
                <a href="/admin/users" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Users</p>
                </a>
            </li>
        @endif
    </ul>
</li>
{{-- <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-table"></i>
      <p>
        File Managemen
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
      <li class="nav-item">
        <a href="pages/tables/simple.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Gambar</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/data.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Dokumen</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/jsgrid.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Video</p>
        </a>
      </li>
    </ul>
  </li>
  <li class="nav-item">
    <a href="#" class="nav-link">
      <i class="nav-icon fas fa-table"></i>
      <p>
        Master Data
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
      <li class="nav-item">
        <a href="pages/tables/simple.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Skill Aplikator</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/data.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Banner</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/jsgrid.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Order Status</p>
        </a>
      </li>
    </ul>
  </li>  
  <li class="nav-item">
    <a href="" class="nav-link">
      <i class="nav-icon fas fa-table"></i>
      <p>
        User Managment
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview" style="display: none;">
      <li class="nav-item">
        <a href="/admin/users" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Users</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/simple.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Aplikator</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/data.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Customer</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="pages/tables/jsgrid.html" class="nav-link">
          <i class="far fa-circle nav-icon"></i>
          <p>Admin</p>
        </a>
      </li>
    </ul>
  </li> --}}
