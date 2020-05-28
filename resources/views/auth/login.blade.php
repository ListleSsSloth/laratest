<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login - {{ config('app.name') }}</title>

  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<style>

  body{
    padding-top:20px;
    margin-top: 17%;
    }
  .errortext{
    color: crimson;
    font-size: 17px;
  }

</style>

</head>
<body>
  <div class="container">
      <div class="row">
      <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            {{-- <div class="panel-heading">
              <h3 class="panel-title">Title</h3>
            </div> --}}
            <div class="panel-body">
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <fieldset>
                  <div class="form-group">
                    <input class="form-control @error('login') is-invalid @enderror" placeholder="Login" name="login" id="login" type="text"
                    value="{{ old('login') }}" required autocomplete="login" autofocus>
                  </div>
                  <div class="form-group">
                    <input class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" type="password" 
                    id="password" value="" required>
                  </div>
                  <input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
                </fieldset>
              </form>
            </div>
        </div>
        <div style="text-align: center">
          @error('login')
            <span class="errortext" role="alert">
              {{ $message }}
            </span>
          @enderror
          @error('password')
            <span class="errortext" role="alert">
              {{ $message }}
            </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</body>
</html>

{{-- autocomplete="current-password" --}}