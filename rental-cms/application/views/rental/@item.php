<script>
    model.masterModel = {
        id_item:   0,
        nama_item: "",
        stok:      0,
    }

    var material = {
        TITLE: "Data Item",
        Recordmaterial: ko.mapping.fromJS(model.masterModel),
        Listmaterial: ko.observableArray([]),
        Mode: ko.observable(''),
        DataFilter: ko.observableArray(['nama_item']),
        FilterText: ko.observable(''),
        FilterValue: ko.observable('nama_item'),

        SELECTFILTERVALUE: [
            { name: 'Nama Item', value: 'nama_item' }
        ],
    }

    material.filtermaterial = function() {
        material.grid.ajax.reload();
    }

    material.filterreset = function() {
        material.FilterText('');
        material.grid.ajax.reload(null, false);
    }

    material.back = function() {
        material.Mode('');
        material.grid.ajax.reload(null, false);
        ko.mapping.fromJS(model.masterModel, material.Recordmaterial);
        $('#tabnavform a[href="#tablist"]').tab('show');
    }

    material.tambah = function() {
        ko.mapping.fromJS(model.masterModel, material.Recordmaterial);
        material.Mode('');
        $('#tabnavform a[href="#tabform"]').tab('show');
    }

    material.selectdata = function(id) {
        model.Processing(true);
        ajaxPost("<?php echo site_url('rental/ItemController/getDataSelect') ?>", {
            id: id
        }, function(res) {
            ko.mapping.fromJS(res[0], material.Recordmaterial);
            material.Mode("Update");
            $('#tabnavform a[href="#tabform"]').tab('show');
            model.Processing(false);
        });
    }

    material.save = function() {
        if (material.Recordmaterial.nama_item() == "" || material.Recordmaterial.stok() === "") {
            swal("Peringatan!", "Nama Item dan Stok harap diisi!", "warning");
            return;
        }

        if (isNaN(material.Recordmaterial.stok()) || Number(material.Recordmaterial.stok()) < 0) {
            swal("Peringatan!", "Stok harus berupa angka dan tidak boleh minus!", "warning");
            return;
        }

        swal({
            title: "Perhatian",
            text: "Anda akan simpan data ini?",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function(isConfirm) {
            if (isConfirm) {
                model.Processing(true);

                var url = "<?php echo base_url('rental/ItemController/save') ?>";
                if (material.Mode() === 'Update')
                    url = "<?php echo base_url('rental/ItemController/update') ?>";

                ajaxPost(url, material.Recordmaterial, function(res) {
                    model.Processing(false);
                    if (res.result == true || material.Mode() == "Update") {
                        var pesan = material.Mode() == "Update" ? "Data Berhasil di ubah!" : "Data Berhasil di input!";
                        swal("Berhasil!", pesan, "success");
                        material.back();
                    } else {
                        swal("Gagal!", "Data gagal disimpan.", "error");
                    }
                });
            }
        });
    }

    material.remove = function(id_item) {
        swal({
            title: "Are you sure?",
            text: "Delete this data?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Yes, delete!",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
        }, function(isConfirm) {
            if (isConfirm) {
                model.Processing(true);
                ajaxPost("<?php echo base_url('rental/ItemController/delete') ?>", {
                    id_item: id_item
                }, function(res) {
                    model.Processing(false);
                    if (res.result) {
                        material.grid.ajax.reload(null, false);
                        swal("Deleted!", "Data has been deleted successfully.", "success");
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
                    <h1>Modul Item</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" data-bind="with: material">
                <div class="col-md-12">

                    <ul class="nav nav-tabs customtab" id="tabnavform">
                        <li class="nav-item">
                            <a class="nav-link active" href="#tabform" data-toggle="tab">Form</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#tablist" data-toggle="tab">List</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="tabnavform-content">

                        <!-- TAB FORM -->
                        <div class="tab-pane active" id="tabform">
                            <div class="card card-primary">
                                <div class="card-body p-20 animated fadeIn">
                                    <div class="row p-t-23 margMin">
                                        <div class="col-md-12 margMin">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-warning"
                                                    data-bind="click: function(){ back(1); }, visible: Mode() == 'Update'"
                                                    data-toggle="tooltip" title="Kembali">
                                                    <i class="fa fa-arrow-left"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info"
                                                    data-bind="click: save"
                                                    data-toggle="tooltip" title="Simpan">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger"
                                                    data-bind="click: function(){ remove(Recordmaterial.id_item()); }, visible: Mode() == 'Update'">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-body" data-bind="with: Recordmaterial">
                                            <div class="form-group">
                                                <label>NAMA ITEM</label>
                                                <input type="text" class="form-control"
                                                    data-bind="value: nama_item"
                                                    placeholder="Masukkan Nama Item">
                                            </div>

                                            <div class="form-group">
                                                <label>STOK</label>
                                                <input type="number" class="form-control"
                                                    data-bind="value: stok"
                                                    min="0"
                                                    placeholder="Masukkan Jumlah Stok">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- END TAB FORM -->

                        <!-- TAB LIST -->
                        <div class="tab-pane fade" id="tablist">
                            <div class="card mt-3">
                                <div class="card-header">
                                    <div class="row mb-3">
                                        <div class="col-md-2">
                                            <select class="form-control form-control-sm" data-bind="
                                                options: SELECTFILTERVALUE,
                                                optionsText: 'name',
                                                optionsValue: 'value',
                                                value: FilterValue">
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <input class="form-control form-control-sm" placeholder="Cari..."
                                                data-bind="value: FilterText, event: { keyup: function(data, event) {
                                                    if (event.key === 'Enter') material.filtermaterial();
                                                }}">
                                        </div>
                                        <div class="col-sm-2 col-md-5 margFilter">
                                            <div class="form-group">
                                                <button class="btn btn-md btn-danger" data-bind="click: filterreset"><span class="fa fa-retweet"></span></button>
                                                <button class="btn btn-md btn-primary" data-bind="click: filtermaterial"><span class="fa fa-search"></span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="myTable" width="100%" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Item</th>
                                                <th>Stok</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- END TAB LIST -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        model.Processing(true);

        material.grid = $("#myTable").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url('rental/ItemController/getData') ?>",
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
                { "data": "nama_item" },
                { "data": "stok" },
                {
                    "data": "id_item",
                    "render": function(data) {
                        return "<button class='btn btn-sm btn-info' onClick='material.selectdata(\"" + data + "\")'><i class='fa fa-edit'></i></button> &nbsp;" +
                               "<button class='btn btn-sm btn-danger' onClick='material.remove(\"" + data + "\")'><i class='fa fa-trash'></i></button>";
                    }
                }
            ],
        });

        model.Processing(false);
    });
</script>