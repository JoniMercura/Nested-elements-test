<!DOCTYPE html>
<html>
<head>
    <title>Create Company</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Create Company</h1>
            <form action="{{ route('companies.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Company Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="domain">Company Domain</label>
                    <input type="text" class="form-control" id="domain" name="domain" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>


