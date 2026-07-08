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


                <!-- MANAJEMEN DATA -->
                <li class="nav-item has-treeview <?= ($this->uri->segment(2) == 'SatuanController' || $this->uri->segment(2) == 'MasterkategoriController' || $this->uri->segment(2) == 'MerekController' || $this->uri->segment(2) == 'DepartemenController') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($this->uri->segment(2) == 'SatuanController' || $this->uri->segment(2) == 'MasterkategoriController' || $this->uri->segment(2) == 'MerekController' || $this->uri->segment(2) == 'DepartemenController') ? 'active' : ''; ?>">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            MANAJEMEN DATA
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('master/SatuanController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'SatuanController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Satuan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/MasterkategoriController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'MasterkategoriController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/MerekController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'MerekController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Merek</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('master/DepartemenController'); ?>" class="nav-link <?= ($this->uri->segment(2) == 'DepartemenController') ? 'active' : ''; ?>">
                                <i class="nav-icon far fa-circle"></i>
                                <p>Master Departement</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>