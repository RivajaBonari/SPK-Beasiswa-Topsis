<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.php" class="text-nowrap logo-img">
                <img src="../assets/images/logos/logo1.png" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./index.php" aria-expanded="false">
                        <i class="ti ti-home"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->

                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"
                        href="kriteriaBobot.php" aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-scale-outline"></i>
                            </span>
                            <span class="hide-menu">Kriteria dan Bobot</span>
                        </div>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="./sub_kriteria.php" aria-expanded="false">
                    <i class="ti ti-subtask"></i>
                        <span class="hide-menu">Sub Kriteria</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="./data.php" aria-expanded="false">
                        <i class="ti ti-file-text"></i>
                        <span class="hide-menu">Data Mahasiswa</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" href="./pendaftaran.php" aria-expanded="false">
                        <i class="ti ti-sum"></i>
                        <span class="hide-menu">Penilaian Alternatif</span>
                    </a>
                </li>


                <li class="sidebar-item">
                    <a class="sidebar-link" href="./perangkingan.php" aria-expanded="false">
                        <i class="ti ti-badges"></i>
                        <span class="hide-menu">Perangkingan</span>
                    </a>
                </li>


                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Learning</span>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"
                        href="tentang.php" aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-alert-circle"></i>
                            </span>
                            <span class="hide-menu">Tentang</span>
                        </div>
                    </a>
                </li>


                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Auth</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="../backend/authLogout.php" aria-expanded="false">
                        <i class="ti ti-login"></i>
                        <span class="hide-menu">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>