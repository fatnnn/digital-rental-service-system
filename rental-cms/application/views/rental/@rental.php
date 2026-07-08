<script>
    model.masterModel = {
        ID_Rental       : 0,
        ID_Item         : "",
        ID_Anggota      : "",
        Tanggal_Pinjam  : "",
        Tanggal_Kembali : "",
        Status          : "Dipinjam",
    }

    var material = {
        title           : "Data Rental",
        Recordmaterial  : ko.mapping.fromJS(model.masterModel),
        Listmaterial    : ko.observableArray([]),
        Mode            : ko.observable(''),
        FilterText      : ko.observable(''),
        FilterValue     : ko.observable('Status'),

        SELECTFILTERVALUE: [
            { name: 'Status',         value: 'Status'         },
            { name: 'Tanggal Pinjam', value: 'Tanggal_Pinjam' },
        ],

        SELECTSTATUS: [
            { name: 'Dipinjam',     value: 'Dipinjam'     },
            { name: 'Dikembalikan', value: 'Dikembalikan' },
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
        ajaxPost("<?php echo base_url('data-rental/getDataSelect') ?>", {
            ID_Rental: id
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
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes!",
            cancelButtonText: "No!",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function(isConfirm) {
            if (isConfirm) {
                if (material.Recordmaterial.ID_Item() == "" || material.Recordmaterial.ID_Anggota() == "") {
                    setTimeout(function() {
                        swal("Peringatan!", "Data Harap diisi Dengan Benar!", "warning");
                    });
                } else {
                    var url = "<?php echo base_url('data-rental/save') ?>";
                    if (material.Mode() === 'Update')
                        url = "<?php echo base_url('data-rental/update') ?>";

                    ajaxPost(url, material.Recordmaterial, function(res) {
                        if (res.result == true || material.Mode() == "Update") {
                            if (res.result == true) {
                                setTimeout(function() {
                                    swal({ title: "Good job!", text: "Data Berhasil di input!", icon: "success" });
                                }, 2000);
                            }
                            if (material.Mode() == "Update") {
                                setTimeout(function() {
                                    swal({ title: "Good job!", text: "Data Berhasil di ubah!", icon: "success" });
                                }, 2000);
                            }
                            material.back(1);
                        }
                    });
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
                ajaxPost("<?php echo base_url('data-rental/delete') ?>", {
                    ID_Rental: id
                }, function(res) {
                    if (res.result) {
                        material.back(1);
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
                    <h1>Modul Rental</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" data-bind="with: material">
                <div class="col-md-12">

                    <ul class="nav nav-tabs customtab" id="tabnavform">
                        <li class="nav-item"><a class="nav-link active" href="#tabform" data-toggle="tab">Form</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tablist" data-toggle="tab">List</a></li>
                    </ul>

                    <div class="content tab-content" id="tabnavform-content">

                        <!-- TAB FORM -->
                        <div class="tab-pane active" id="tabform">
                            <div class="card card-primary">
                                <div class="card-body p-20 animated fadeIn">
                                    <div class="row p-t-23 margMin">
                                        <div class="col-md-12 margMin">
                                            <div class="form-group">
                                                <button class="btn btn-sm btn-warning" data-bind="click:function(){back(1);}, visible: Mode() == 'Update'" data-toggle="tooltip" title="Kembali">
                                                    <i class="fa fa-arrow-left"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" data-bind="click:save" data-toggle="tooltip" title="Simpan">
                                                    <i class="fa fa-save"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bind="click:function(){remove(Recordmaterial.ID_Rental());}, visible: Mode() == 'Update'">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body" data-bind="with: Recordmaterial">
                                        <div class="form-group">
                                            <label>ID Item</label>
                                            <input type="text" class="form-control" data-bind="value: ID_Item" placeholder="Masukkan ID Item">
                                        </div>
                                        <div class="form-group">
                                            <label>ID Anggota</label>
                                            <input type="text" class="form-control" data-bind="value: ID_Anggota" placeholder="Masukkan ID Anggota">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Pinjam</label>
                                            <input type="date" class="form-control" data-bind="value: Tanggal_Pinjam">
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal Kembali</label>
                                            <input type="date" class="form-control" data-bind="value: Tanggal_Kembali">
                                        </div>
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" data-bind="
                                                options: material.SELECTSTATUS,
                                                optionsText: 'name',
                                                optionsValue: 'value',
                                                value: Status">
                                            </select>
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

                                    <div class="col-sm-4 col-md-2">
                                        <fieldset class="form-group">
                                            <select class="form-control" data-bind="
                                                options: SELECTFILTERVALUE,
                                                optionsText: 'name',
                                                optionsValue: 'value',
                                                value: FilterValue">
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-sm-2 col-md-3">
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Filter by data"
                                                data-bind="value: FilterText, event: { keyup: function(data, event) {
                                                    if (event.key === 'Enter') material.filtermaterial();
                                                }}">
                                            <p><small class="text-muted">Contoh: ketik <i>Dipinjam</i> lalu <b>Enter</b></small></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-5 margFilter">
                                        <div class="form-group">
                                            <button class="btn btn-md btn-danger" data-bind="click: filterreset"><span class="fa fa-retweet"></span></button>
                                            <button class="btn btn-md btn-primary" data-bind="click: filtermaterial"><span class="fa fa-search"></span></button>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive m-t-40 animated fadeIn">
                                            <table id="myTable" width="100%" class="table table-bordered table-striped">
 <thead>
<tr>
    <th>ID Rental</th>
    <th>ID Item</th>
    <th>ID Anggota</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

                                                        </tr>
                                                     </thead>
                                                     </table>
                                                     </div> 
                                                    </div>
                                                 </div>
                                                  <!-- ======== END TAB LIST ======== -->
                                                 </div>
                                                 </div>
                                                 </div>
                                                 </div>
                                                 </section>
                                                 </div>
                                                 <script>
$(document).ready(function () {

    model.Processing(true);

    material.grid = $("#myTable").DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        ajax: {
            url: "<?php echo base_url('data-rental/getData') ?>",
            type: "POST",
            data: function (d) {
                d.filtervalue = material.FilterValue();
                d.filtertext = material.FilterText();
            },
            dataSrc: function (json) {
                json.recordsTotal = json.RecordsTotal;
                json.recordsFiltered = json.RecordsFiltered;
                return json.Data;
            }
        },
        columns: [
            { data: "ID_Rental" },
            { data: "ID_Item" },
            { data: "ID_Anggota" },
            { data: "Tanggal_Pinjam" },
            { data: "Tanggal_Kembali" },
            { data: "Status" },
            {
                data: "ID_Rental",
                render: function(data){
                    return "<button class='btn btn-info btn-sm' onclick='material.selectdata("+data+")'><i class='fa fa-edit'></i></button> " +
                           "<button class='btn btn-danger btn-sm' onclick='material.remove("+data+")'><i class='fa fa-trash'></i></button>";
                }
            }
        ]
    });

    model.Processing(false);

});
</script>