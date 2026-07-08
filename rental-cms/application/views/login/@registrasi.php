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

<style>
.register-page-bg {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 60%, #3b82f6 100%);
}

.register-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
}

.register-card {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    border-radius: 18px;
    padding: 40px 36px;
    box-shadow: 0 20px 45px rgba(15, 42, 105, 0.25);
}

.register-header {
    text-align: center;
    margin-bottom: 30px;
}

.register-header h2 {
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 6px;
    font-size: 26px;
}

.register-header p {
    color: #6b7280;
    font-size: 14px;
    margin: 0;
}

.register-body .form-group {
    margin-bottom: 20px;
}

.register-body label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.register-body .form-control,
.register-body select.form-control {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    background: #fff;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}

.register-body .form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.register-body .input-group {
    display: flex;
    align-items: center;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}

.register-body .input-group:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.register-body .input-group .form-control {
    border: none;
    box-shadow: none;
}

.register-body .input-group-text {
    padding: 0 14px;
    background: #fff;
    color: #9ca3af;
}

.btn-register {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    margin-top: 6px;
    transition: transform .15s, box-shadow .15s;
}

.btn-register:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
}

.login-link {
    text-align: center;
    margin-top: 18px;
    margin-bottom: 0;
    font-size: 14px;
    color: #6b7280;
}

.login-link a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}
</style>

<div class="register-page-bg">
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