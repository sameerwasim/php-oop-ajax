<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Interview Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>

    <div class="row m-5">
      <div class="col-sm-4">
        <div class="card">
          <form class="card-body" id="form" onsubmit="add(event)">
            <input type="hidden" name="id" id="id">
            <input type="hidden" id="action" name="action" value="add">
            <div class="form-group mb-3">
              <label for="category">Category</label>
              <input type="text" name="category" id="category" class="form-control" placeholder="Category" required />
            </div>
            <div class="form-group mb-3">
              <label for="parent">Parent Category</label>
              <select class="form-select" name="parent" id="parent">
              </select>
            </div>
            <div class="form-group">
              <button type="submit" id="btn" class="btn btn-success">Add</button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive" id="table">
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./main.js"></script>
  </body>
</html>
