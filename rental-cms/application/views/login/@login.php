<script>

model.masterModel = {
    username: '',
    password: '',
}

var login = {
    title: 'form Login',
    RecordLogin: ko.mapping.fromJS(model.masterModel),
}

login.prosesLogin = function() {

    model.Processing(true);

    if (login.RecordLogin.username() == "") {
        swal("Peringatan", "Username harus diisi", "warning");
        model.Processing(false);
        return;
    }

    if (login.RecordLogin.password() == "") {
        swal("Peringatan", "Password harus diisi", "warning");
        model.Processing(false);
        return;
    }

    var url = '<?= site_url('login/LoginController/get_valid_login') ?>';

    ajaxPost(url, login.RecordLogin, function(res) {

        if (res.result == true) {

            swal({
                title: "Berhasil",
                text: "Login berhasil",
                icon: "success",
            });

            setTimeout(function() {
                window.location.href = '<?= base_url('rental/RentalController') ?>';
            }, 1000);

        } else {
            swal({
                title: "Gagal",
                text: res.message,
                icon: "error",
            });

            model.Processing(false);
        }
    });
}

</script>

<style>
.login-page-bg {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 60%, #3b82f6 100%);
}

.login-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
}

.login-card {
    width: 100%;
    max-width: 400px;
    background: #ffffff;
    border-radius: 18px;
    padding: 40px 36px;
    box-shadow: 0 20px 45px rgba(15, 42, 105, 0.25);
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-header h2 {
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 6px;
    font-size: 26px;
}

.login-header p {
    color: #6b7280;
    font-size: 14px;
    margin: 0;
}

.login-body .form-group {
    margin-bottom: 20px;
}

.login-body label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.login-body .form-control {
    width: 100%;
    padding: 11px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: border-color .2s, box-shadow .2s;
    box-sizing: border-box;
}

.login-body .form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.login-body .input-group {
    display: flex;
    align-items: center;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}

.login-body .input-group:focus-within {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.login-body .input-group .form-control {
    border: none;
    box-shadow: none;
}

.login-body .input-group-text {
    padding: 0 14px;
    background: #fff;
    color: #9ca3af;
}

.btn-login {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: transform .15s, box-shadow .15s;
}

.btn-login:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
}

.login-card .text-center a {
    color: #2563eb;
    font-weight: 600;
    text-decoration: none;
}

.login-card .text-center a:hover {
    text-decoration: underline;
}
</style>

<div class="login-page-bg">
<div class="login-wrapper">

    <div class="login-card">

        <div class="login-header">
            <h2>Login Sistem</h2>
            <p>Silahkan masukkan data untuk melanjutkan</p>
        </div>

        <div class="login-body">

            <div class="form-group">
                <label>Username</label>
                <input
                    type="text"
                    class="form-control"
                    placeholder="Masukkan Username"
                    data-bind="value: login.RecordLogin.username">
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-group">
                    <input
                        id="password"
                        type="password"
                        class="form-control"
                        placeholder="Masukkan Password"
                        data-bind="value: login.RecordLogin.password">
                    <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                        <i id="eyeIcon" class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

        </div>

        <button
            type="button"
            class="btn-login"
            data-bind="click: login.prosesLogin">
            Login
        </button>

        <p class="mb-0 text-center" style="margin-top:18px; font-size:14px; color:#6b7280;">
            Belum punya akun?
            <a href="<?= base_url('login/LoginController/registrasi') ?>">Daftar di sini</a>
        </p>

    </div>

</div>
</div>

<script>
function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");

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