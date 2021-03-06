<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="/assets/js/main-frame.js"></script>

<div class="m-5"> 
    <form id="main-form">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" disabled="true">
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName" disabled="true">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Enter E-mail">
        </div>
        <div class="form-group">
            <label for="identifier">Identifier</label>
            <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter Identifier">
        </div>
        <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter Full Name">
        </div>
        <div class="form-group">
            <label for="rate">Rate</label>
            <input type="text" class="form-control" id="rate" name="rate" placeholder="Set Rate">
        </div>
        <input type="hidden" id="id" name="id">
        <div class="alert alert-danger"></div>
        <div class="alert alert-warning"></div>
        <div class="alert alert-success"></div>
        <button class="btn btn-secondary" id="submit">Submit</button>
    </form>
</div>
