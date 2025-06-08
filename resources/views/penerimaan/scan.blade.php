<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan</title>
</head>
<body>
    <div id="reader"></div>
    <script src="{{ asset('assets/html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // inisiasi html5QRCodeScanner
        let html5QRCodeScanner = new Html5QrcodeScanner(
            // target id dengan nama reader, lalu sertakan juga 
            // pengaturan untuk qrbox (tinggi, lebar, dll)
            "reader", {
                fps: 10,
                qrbox: {
                    width: 200,
                    height: 200,
                },
            }
        );

        // function yang dieksekusi ketika scanner berhasil
        // membaca suatu QR Code
        function onScanSuccess(decodedText, decodedResult) {
            // redirect ke link hasil scan
            // window.location.href = decodedResult.decodedText;
            id = decodedResult.decodedText;
            console.log(id);
            html5QRCodeScanner.clear();
            $.ajax({ 
                type : 'get',
                url : "{{ url('penerimaan/terima_barang/'.$penerimaan->id)}}/"+id,
                // data:{'id':id}, 
                success:function(tampil){
                    Swal.fire({
                        icon: "success",
                        title: tampil,
                        showConfirmButton: false,
                        timer: 1500
                    });
                } 
            })
            // membersihkan scan area ketika sudah menjalankan 
            // action diatas
        }

        // render qr code scannernya
        html5QRCodeScanner.render(onScanSuccess);
    </script>
</body>
</html>