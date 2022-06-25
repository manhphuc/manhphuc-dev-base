<section class="box-form">
    <!-- Register Form Validate -->
    <div class="yivic-formValidation">
        <form action="" method="POST" class="yivic-formValidation__form" id="register-form">
            <h3 class="yivic-formValidation__form--heading">Đăng ký thành viên</h3>
            <p class="yivic-formValidation__form--desc">Làm thành viên cùng YIVIC để nhận ưu đãi hấp dẫn! ❤️</p>

            <div class="yivic-formValidation__form--spacer"></div>

            <div class="yivic-formValidation__form--formGroup">
                <label for="fullname" class="form-label">Full name</label>
                <input id="fullname" name="fullname" rules="required" type="text" placeholder="Ex: Phuc Nguyen" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="yivic-formValidation__form--formGroup">
                <label for="email" class="form-label">Email</label>
                <input id="email" name="email" rules="required|email" type="text" placeholder="VD: email@domain.com" class="form-control">
                <span class="form-message"></span>
            </div>

            <div class="yivic-formValidation__form--formGroup">
                <label for="password" class="form-label">Password</label>
                <input id="password" name="password" type="password" rules="required|min:6" placeholder="Enter password" class="form-control">
                <span class="form-message"></span>
            </div>

            <button class="yivic-formValidation__form--formSubmit">Register</button>
        </form>
    </div> <!-- End Register Form Validate -->

</section>