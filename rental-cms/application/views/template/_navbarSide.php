<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="<?= base_url(); ?>assets\img\faces\admin.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Managemen Magang</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img style="border-radius: 50%; background:grey;" src="<?= base_url(); ?>assets\admin\img\kazuya.png" />
            </div>
            <div class="info">
                <a href="https://www.kazuyamedia.com/" class="d-block">Kazuya Media Indonesia</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- BERANDA -->
                <li class="nav-item has-treeview <?= ($this->uri->segment(2) == 'FormTestimoniController' || $this->uri->segment(2) == 'FormKeunggulanController') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($this->uri->segment(2) == 'FormTestimoniController' || $this->uri->segment(2) == 'FormKeunggulanController') ? 'active' : ''; ?>">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            BERANDA
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('data-testimoni'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'TestimoniController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Modul Testimoni</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('data-keunggulan'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'KeunggulanController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Modul Keunggulan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('data-review'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'ReviewController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Modul Review</p>
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('data-education'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'EducationController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Modul Education</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MANAJEMEN DATA -->
                <li class="nav-item has-treeview <?= ($this->uri->segment(2) == 'FormIntansiController' || $this->uri->segment(2) == 'FormJabatanController' || $this->uri->segment(2) == 'UsersController' || $this->uri->segment(2) == 'PendaftaranController') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($this->uri->segment(2) == 'FormIntansiController' || $this->uri->segment(2) == 'FormJabatanController' || $this->uri->segment(2) == 'UsersController' || $this->uri->segment(2) == 'PendaftaranController') ? 'active' : ''; ?>">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            MANAJEMEN DATA
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/FormIntansiController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'FormIntansiController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Instansi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/FormJabatanController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'FormJabatanController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Jabatan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/UsersController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'UsersController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/PendaftaranController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'PendaftaranController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Modul Pendaftaran</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>