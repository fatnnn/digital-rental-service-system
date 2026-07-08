<script>
    model.masterModel = {
        id_anggota:    0,
        nama:          "",
        alamat:        "",
        nomor_telepon: "",
    }

    var material = {
        TITLE: "Data Anggota",
        Recordmaterial: ko.mapping.fromJS(model.masterModel),
        Listmaterial:   ko.observableArray([]),
        Mode:           ko.observable(''),
        DataFilter:     ko.observableArray(['nama']),
        FilterText:     ko.observable(''),
        FilterValue:    ko.observable('nama'),

        SELECTFILTERVALUE: [
            { name: 'Nama',          value: 'nama'          },
            { name: 'Alamat',        value: 'alamat'        },
            { name: 'Nomor Telepon', value: 'nomor_telepon' },
        ],
    }

    material.filtermaterial = function() {
        material.grid.ajax.reload();
    }

    material.filterreset = function() {
        material.FilterText('');
        material.grid.ajax.reload(null, false);
    }

    material.back = function(tab) {
        material.Mode('');
        material.grid.ajax.reload(null, false);
        ko.mapping.fromJS(model.masterModel, material.Recordmaterial);
        model.activetab(tab);
    }

    material.selectdata = function(id) {
        model.Processing(true);
        ajaxPost("<?php echo site_url('rental/AnggotaController/getDataSelect') ?>", {
            id: id
        }, function(res) {
            console.log(res[0]);
            material.back(0);
            ko.mapping.fromJS(res[0], material.Recordmaterial);
            material.Mode("Update");
            model.Processing(false);
        });
    }

    material.save = function() {
        model.Processing(true);
        swal({
            title: "Perhatian",
            text: "Anda akan simpan data ini?",
            type: "info",
            className: 'animate__animated animate__fadeInUp',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function(isConfirm) {
            if (isConfirm) {
                if (material.Recordmaterial.nama() == "") {
                    setTimeout(function() {
                        swal("Peringatan!", "Nama harap diisi dengan benar!", "warning");
                    });
                } else {
                    if (showLoaderOnConfirm = true) {
                        var url = "<?php echo base_url('rental/AnggotaController/save') ?>";
                        if (material.Mode() === 'Update')
                            url = "<?php echo base_url('rental/AnggotaController/update') ?>";

                        ajaxPost(url, material.Recordmaterial, function(res) {
                            console.log(res.result);
                            if (res.result == true || material.Mode() == "Update") {
                                if (res.result == true) {
                                    setTimeout(function() {
                                        swal({ title: "Good job!", text: "Data berhasil diinput!", icon: "success" });
                                    }, 2000);
                                }
                                if (material.Mode() == "Update") {
                                    setTimeout(function() {
                                        swal({ title: "Good job!", text: "Data berhasil diubah!", icon: "success" });
                                    }, 2000);
                                }
                                material.back(1);
                            }
                        });
                    }
                }
            }
            model.Processing(false);
        });
        model.Processing(false);
    }

    material.remove = function(id) {
        swal({
            title: "Are you sure?",
            text: "Delete this data?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
        }, function(isConfirm) {
            if (isConfirm) {
                ajaxPost("<?php echo base_url('rental/AnggotaController/delete') ?>", {
                    id: id
                }, function(res) {
                    if (res.result) {
                        material.back(1);
                        swal("Deleted!", "Data berhasil dihapus.", "success");
                    } else {
                        swal("Failed!", res.message, "warning");
                    }
                });
            }
        });
    }
</script>

<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Modul Anggota</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" data-bind="with: material">
                <div class="col-md-12">

                    <!-- Nav Tab -->
                    <ul class="nav nav-tabs customtab" id="tabnavform">
                        <li class="nav-item"><a class="nav-link active" href="#tabform" data-toggle="tab">Form</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tablist" data-toggle="tab">List</a></li>
                    </ul>
                    <!-- end Nav Tab -->

                    <div class="content tab-content" id="tabnavform-content">

                        <!-- TAB FORM -->
                        <div class="tab-pane active" id="tabform">
                            <div class="card card-primary">
                                <div class="card-body p-20 animated fadeIn">
                                    <div class="row p-t-23 margMin">
                                        <div class="col-md-12 margMin">
                                            <div class="form-group">
                                                <!-- Tombol Kembali (hanya muncul saat Update) -->
                                                <button class="btn btn-sm btn-warning"
                                                    data-bind="click: function(){ back(1); }, visible: Mode() == 'Update'"
                                                    data-toggle="tooltip" title="Kembali">
                                                    <i class="fa fa-arrow-left"></i>
                                                </button>

                                                <!-- Tombol Simpan -->
                                                <button class="btn btn-sm btn-info"
                                                    data-bind="click: save"
                                                    data-toggle="tooltip" title="Simpan">
                                                    <i class="fa fa-save"></i>
                                                </button>

                                                <!-- Tombol Hapus (hanya muncul saat Update) -->
                                                <button class="btn btn-sm btn-danger"
                                                    data-bind="click: function(){ remove(Recordmaterial.id_anggota()); }, visible: Mode() == 'Update'"
                                                    data-toggle="tooltip" title="Hapus">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Form Fields -->
                                    <div class="card-body" data-bind="with: Recordmaterial">

                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control"
                                                data-bind="value: nama"
                                                placeholder="Masukkan Nama Anggota">
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <textarea class="form-control" rows="3"
                                                data-bind="value: alamat"
                                                placeholder="Masukkan Alamat"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor Telepon</label>
                                            <input type="text" class="form-control"
                                                data-bind="value: nomor_telepon"
                                                placeholder="Contoh: 0812-3456-7890">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end TAB FORM -->

                        <!-- TAB LIST -->
                        <div class="tab-pane card card-white" id="tablist">
                            <div class="card-body p-20" data-bind="with: material">
                                <div class="row p-t-23">

                                    <!-- Filter -->
                                    <div class="col-sm-4 col-md-2">
                                        <fieldset class="form-group">
                                            <select class="form-control"
                                                data-bind="
                                                    options: SELECTFILTERVALUE,
                                                    optionsText: 'name',
                                                    optionsValue: 'value',
                                                    value: FilterValue">
                                            </select>
                                        </fieldset>
                                    </div>

                                    <div class="col-sm-2 col-md-3">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Filter data..."
                                                data-bind="value: FilterText, event: {
                                                    keyup: function(data, event) {
                                                        if (event.key === 'Enter') material.filtermaterial();
                                                    }
                                                }">
                                            <p>
                                                <small class="text-muted">Ketik lalu tekan <b>Enter</b></small>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-sm-2 col-md-5 margFilter">
                                        <div class="form-group">
                                            <button class="btn btn-md btn-danger" data-bind="click: filterreset">
                                                <span class="fa fa-retweet"></span>
                                            </button>
                                            <button class="btn btn-md btn-primary" data-bind="click: filtermaterial">
                                                <span class="fa fa-search"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- end Filter -->

                                    <!-- Tabel -->
                                    <div class="col-md-12">
                                        <div class="table-responsive m-t-40 animated fadeIn">
                                            <table id="myTable" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Nama</th>
                                                        <th>Alamat</th>
                                                        <th>Nomor Telepon</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end Tabel -->

                                </div>
                            </div>
                        </div>
                        <!-- end TAB LIST -->

                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- end wrapper -->

<script>
    $(document).ready(function() {
        model.Processing(true);

        material.grid = $("#myTable").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('rental/AnggotaController/getData') ?>",
                "type": "POST",
                "data": function(d) {
                    d['filtervalue'] = material.FilterValue();
                    d['filtertext']  = material.FilterText();
                    return d;
                },
                "dataSrc": function(json) {
                    json.recordsTotal    = json.RecordsTotal;
                    json.recordsFiltered = json.RecordsFiltered;
                    return json.Data ? json.Data : [];
                },
            },
            "searching": false,
            "columns": [
                { "data": "id_anggota" },
                { "data": "nama" },
                { "data": "alamat" },
                { "data": "nomor_telepon" },
                {
                    "data": "id_anggota",
                    "render": function(data, type, full, meta) {
                        return "<button class='btn btn-sm btn-info' onclick='material.selectdata(\"" + data + "\")'>" +
                                    "<i class='fa fa-edit'></i>" +
                               "</button> &nbsp; " +
                               "<button class='btn btn-sm btn-danger' onclick='material.remove(\"" + data + "\")'>" +
                                    "<i class='fa fa-trash'></i>" +
                               "</button>";
                    }
                }
            ],
        });

        model.Processing(false);
    });
</script>