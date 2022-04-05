<div class="modal fade" id="signupModel" tabindex="-1" aria-labelledby="signupModelLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupModelLabel">Sign Up</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="mb-3">
            <label for="signupfirstname" class="form-label">First Name</label>
            <input type="name" name="signupfirstname" class="form-control" id="signupfirstname" maxlength="16">
            <div class="invalid-feedback">Please input a valid Name</div>
          </div>
          <div class="mb-3">
            <label for="signuplastname" class="form-label">Last Name</label>
            <input type="name" name="signuplastname" class="form-control" id="signuplastname">
            <div class="invalid-feedback">Please input a valid Name</div>
          </div>
          <div class="mb-3">
            <label for="signupemail" class="form-label">Email</label>
            <input type="email" name="signupemail" class="form-control" id="signupemail">
            <div class="invalid-feedback">Please Input a valid email</div>
          </div>
          <div class="mb-3">
            <label for="signuppassword" class="form-label">Password</label>
            <input type="password" name="signuppassword" class="form-control" id="signuppassword">
            <div class="invalid-feedback">Password must be at least 6 characters</div>
          </div>
          <div class="mb-3">
            <label for="csignuppassword" class="form-label">Confirm Password</label>
            <input type="password" name="csignuppassword" class="form-control" id="csignuppassword">
            <div class="invalid-feedback">Both password must be match</div>
          </div>
          <button type="submit" class="btn btn-primary" id="signupBtn" disabled>Sign Up</button>
        </form>
      </div>
    </div>
  </div>
</div>