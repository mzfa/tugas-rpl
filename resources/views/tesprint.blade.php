<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- <link href="https://www.dafontfree.net/embed/bHVjaWRhLWhhbmR3cml0aW5nLXJlZ3VsYXImZGF0YS8zNy9sLzEyNTIxOC9xa21hcmlzYS50dGY" rel="stylesheet" type="text/css"/> --}}

    <style>
        /* body{
            font-family: 'lucida-handwriting-regular', sans-serif;
        } */
        .tengah{
            position: absolute;
            z-index: 10;
            top: 46%;
            left: 43%;
            align-items: center;
        }
        .foto{
            position: absolute;
            z-index: 20;
            top: 68%;
            left: 12%;
            width: 110px;
        }
        .sertifikat{
            width: 100vw;
            height: 100vh;
        }
    </style>
  </head>
  <body>
    
    
        <div class="z-3 position-absolute w-100" >
            <br><br><br><br><br><br><br><br><br><br><br><br><br>
            <center><h2 class="mt-2">Muhammad Zulfikar F A</h2></center>
        </div>
        <!-- <h2 class="tengah">Muhammad Zulfikar F A</h2> -->
      
    <div class="container">
        <div class="row">
        </div>
    </div>
    <img src="https://perpustakaan.widyatama.ac.id/wp-content/uploads/2020/07/foto-formal-compres-scaled.jpg" alt="" class="foto">

    <img src="{{ url('images/sertifikat/depan.png') }}" alt="" class="sertifikat">


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>