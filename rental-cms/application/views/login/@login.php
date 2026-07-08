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

<div class="login-wrapper">

    <div class="login-card">

        <div class="login-header">
            <h2>Login Sistem</h2>
            <p>Silahkan masukkan untuk melanjutkan</p>
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

        <p class="mb-0 text-center" style="margin-top:15px;">
            <a href="<?= base_url('login/LoginController/registrasi') ?>">Register a new membership</a>
        </p>

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