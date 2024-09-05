<html>
    <head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
            body,html{
                height:100%;
                width:100%;
            }
        </style>
    </head>
    <title>Import Database</title>
    <body>

    <div style="height:100%;width:100%;display:flex;flex-direction:column;align-items:center;justify-content:center">



       <!-- Success message -->
       @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Error message -->
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

            <h1>Choose the database file</h1><br/>
            <form method="POST" enctype="multipart/form-data" class="mt-4" action="{{route('importDatabase')}}">
                @csrf
                <input type="file" name="sql_file" required/><br/><br/>

                <small style="color:red">By clicking "import now", you agree to rewrite all of the data in the platform. You will loose any other data in the system</small>
                <br/>
                <br/>

                <button class="btn btn-primary btn-lg"> Import now</button>
            </form>
    </div>
    </body>
</html>