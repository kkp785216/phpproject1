<div class="modal fade" id="loginModel" tabindex="-1" aria-labelledby="loginModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModelLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="loginemail" class="form-label">Email address</label>
                        <input type="email" class="form-control" name="loginemail" id="loginemail" maxlength="55" aria-describedby="emailHelp">
                        <div class="invalid-feedback">Please Input a valid email</div>
                    </div>
                    <div class="mb-3">
                        <label for="loginpassword" class="form-label">Password</label>
                        <input type="password" class="form-control" name="loginpassword" id="loginpassword" maxlength="55">
                        <div class="invalid-feedback">Password must be at least 6 characters</div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="loginBtn" disabled>Login</button>
                </form>
            </div>
        </div>
    </div>
</div>