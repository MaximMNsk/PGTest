<div class="w-100">
    <div class="card mx-auto col-8 mt-5 mb-5 p-3 bg-light">
    <form action="login/" method="POST">
        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" class="form-control" id="login" name="login" aria-describedby="emailHelp" placeholder="Enter login">
        </div>
        <div class="form-group">
            <label for="pwd">Password</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password">
        </div>
        <?php if( isset($_SESSION['access']) ) : ?>
            <?php if( $_SESSION['access'] == 0 ) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Wrong login or password!</strong> Check data and try again.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        <button type="submit" class="btn btn-secondary">Submit</button>
        </form>
    </div>
</div>