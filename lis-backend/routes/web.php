<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect("/login");
});

Route::get("/launch-import",function(){
    return view('importer');
});
