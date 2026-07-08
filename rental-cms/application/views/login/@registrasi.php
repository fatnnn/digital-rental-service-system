<script>

model.masterModel = {
    username: '',
    password: '',
    id_peran: '',
}

var registrasi = {
    title: 'form Registrasi',
    RecordRegistrasi: ko.mapping.fromJS(model.masterModel),
    SELECTPERAN: ko.observableArray([]),
}

registrasi.loadPeran = function() {
    $.ajax({
        url      : '<?= base_url('login/LoginController/getperan') ?>',
        type     : 'GET',
        dataType : 'JSON',
        success  : function(res) {
            console.log("peran:", res);
            registrasi.SELECTPERAN(res);
        },
        error    : function(err) {
            console.log("error:", err);
        }
    });
};

registrasi.save = function() {

    model.Processing(true);

    if (registrasi.RecordRegistrasi.username() == "") {
        swal("Peringatan", "Username harus diisi", "warning");
        model.Processing(false);
        return;
    }

    if (registrasi.RecordRegistrasi.password() == "") {
        swal("Peringatan", "Password harus diisi", "warning");
        model.Processing(false);
        return;
    }

    if (registrasi.RecordRegistrasi.id_peran() == "" || registrasi.RecordRegistrasi.id_peran() == null) {
        swal("Peringatan", "Peran harus dipilih", "warning");
        model.Processing(false);
        return;
    }

    var url = '<?= site_url('login/LoginController/save_registrasi') ?>';

    ajaxPost(url, registrasi.RecordRegistrasi, function(res) {

        if (res.result == true) {

            swal({
                title: "Berhasil",
                text: "Registrasi berhasil",
                icon: "success",
            });

            setTimeout(function() {
                window.location.href = '<?= base_url('login/LoginController') ?>';
            }, 1500);

        } else {
            swal({
                title: "Gagal",
                text: res.message,
                icon: "error",
            });
        }

        model.Processing(false);
    });
}

</script>

<div class="register-wrapper">

    <div class="register-card">

        <div class="register-header">
            <h2>Daftar Akun</h2>
            <p>Isi form di bawah untuk membuat akun baru</p>
        </div>

        <div class="register-body">

            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Masukkan username"
                    data-bind="value: registrasi.RecordRegistrasi.username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input
                        id="passwordReg"
                        type="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        data-bind="value: registrasi.RecordRegistrasi.password">
                    <span class="input-group-text" onclick="togglePasswordReg()" style="cursor: pointer;">
                        <i id="eyeIconReg" class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <div class="form-group">
                <label>Peran</label>
                <select
                    class="form-control"
                    data-bind="
                        options: registrasi.SELECTPERAN,
                        optionsText: 'name',
                        optionsValue: 'value',
                        optionsCaption: '-- Pilih Peran --',
                        value: registrasi.RecordRegistrasi.id_peran">
                </select>
            </div>

            <button
                type="button"
                class="btn-register"
                data-bind="click: registrasi.save">
                Daftar Sekarang
            </button>

            <p class="login-link">
                Sudah punya akun? <a href="<?= base_url('login/LoginController') ?>">Login di sini</a>
            </p>

        </div>

    </div>

</div>

<script>
$(document).ready(function() {
    registrasi.loadPeran();
});
</script>

<script>
function togglePasswordReg() {
    var passwordInput = document.getElementById("passwordReg");
    var eyeIcon = document.getElementById("eyeIconReg");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}
</script>