<script>
    model.masterModel = {
        id:"", //Set Property
        name:"",
        desc:"",
    };

    var material = {
        Recordmaterial: ko.mapping.fromJS(model.masterModel),
        Listmaterial: ko.observableArray([]),
        Mode: ko.observable(""),
        status: ko.observable("Nothing"),
        FilterText: ko.observable(""),
        DataFilter: ko.observableArray([]),
        FilterValue: ko.observable("role_id"),
        
    };

 material.back = function(tab){
        material.Mode("");
        material.grid.ajax.reload(null, true);
        ko.mapping.fromJS(model.masterModel, material.Recordmaterial);
        material.changePassword(false)
        model.activetab(tab);
    };

    material.selectdata = function(id){
        model.Processing(true);
        material.back(0);
        material.Mode("Update");
    
        $.get("/material/GetDataSelect", { id: id }, function(res){
            ko.mapping.fromJS(res, {}, material.Recordmaterial);
            model.Processing(false);
        }).fail(function(){
            model.Processing(false);
            alert("Gagal mengambil data");
        });
    };

    material.save = function () {
        var val = ko.toJS(material.Recordmaterial); // penting jika pakai Knockout
    
        var url = material.Mode() === "Update"
            ? "update"
            : "insert";

    
        $.ajax({
            url: `<?= base_url('KategoriController/')?>`+url,
            type: "POST",
            data: val,
            success: function (res) {
               // material.back(1);
               console.log(res);
               // alert(gagal mengambil data)
            }
        });
    };

    material.remove = function(id){
        if(!confirm("Yakin hapus data?")) return;

        $.ajax({
            url: "/material/delete",
            method: "DELETE",
            data: { id: id },
            success: function(res){
                material.back(1);
            }
        });
    };    
</script>

 <?php $this->load->view('template/_app_content_header'); ?>
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row" data-bind="with: material">

              <!-- From-->
                <div class="col-12" data-bind="with: Recordmaterial">

                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header">
                    <div class="card-title"><?= $title?></div>
                  </div>
                  <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body">
                      <div class="mb-3">
                        <label for="Name_kategori" class="form-label">Name</label>
                        <input
                          type="text"
                          name="txtname"
                          data-bind="value: name"
                          class="form-control"
                          id=""
                        />
                      </div>

                      <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input 
                        type="text" 
                        name="txtdesc"
                        data-bind="value: desc" 
                        class="form-control" id="" />
                      </div>
                     
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <button 
                      type="submit"
                      data-bind= "click: material.save"
                      class="btn btn-primary">Submit</button>
                    </div>
                    <!--end::Footer-->

                </div>
                <!--end::Quick Example-->

                </div>
                <!--end::From-->


              </div class="col-12">
                <div class="card mb-4">
                  <div class="card-header">
                    <h3 class="card-title">Bordered Table</h3>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Task</th>
                          <th>Progress</th>
                          <th style="width: 40px">Label</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="align-middle">
                          <td>1.</td>
                          <td>Update software</td>
                          <td>
                            <div class="progress progress-xs">
                              <div
                                class="progress-bar progress-bar-danger"
                                style="width: 55%"
                              ></div>
                            </div>
                          </td>
                          <td><span class="badge text-bg-danger">55%</span></td>
                        </tr>
                        <tr class="align-middle">
                          <td>2.</td>
                          <td>Clean database</td>
                          <td>
                            <div class="progress progress-xs">
                              <div class="progress-bar text-bg-warning" style="width: 70%"></div>
                            </div>
                          </td>
                          <td>
                            <span class="badge text-bg-warning">70%</span>
                          </td>
                        </tr>
                        <tr class="align-middle">
                          <td>3.</td>
                          <td>Cron job running</td>
                          <td>
                            <div class="progress progress-xs progress-striped active">
                              <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                            </div>
                          </td>
                          <td>
                            <span class="badge text-bg-primary">30%</span>
                          </td>
                        </tr>
                        <tr class="align-middle">
                          <td>4.</td>
                          <td>Fix and squish bugs</td>
                          <td>
                            <div class="progress progress-xs progress-striped active">
                              <div class="progress-bar text-bg-success" style="width: 90%"></div>
                            </div>
                          </td>
                          <td>
                            <span class="badge text-bg-success">90%</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                      <li class="page-item">
                        <a class="page-link" href="#">&laquo;</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">1</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">2</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">3</a>
                      </li>
                      <li class="page-item">
                        <a class="page-link" href="#">&raquo;</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- /.card -->
              

              </div>
              <!--end::row--> 
         </div>
         <!--end::Container-->
    </div>
    <!--end::App Content-->
    
    