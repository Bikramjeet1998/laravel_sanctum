{{-- <!-- resources/views/crypto.blade.php --> --}}
{{-- <!DOCTYPE html> --}}
{{-- <html> --}}
{{-- <head> --}}
{{--    <title>Crypto Example</title> --}}
{{-- </head> --}}
{{-- <body> --}}
{{-- <h1>Crypto Example</h1> --}}
{{-- <h2>Original Data:</h2> --}}
{{-- <pre>{{ json_encode($originalValue) }}</pre> --}}
{{-- <h2>Encrypted Data:</h2> --}}
{{-- <pre>{{ $encrypted }}</pre> --}}
{{-- <h2>Decrypted Data:</h2> --}}
{{-- <pre>{{ json_encode($decrypted) }}</pre> --}}
{{-- </body> --}}
{{-- </html> --}}


<html>

<head>
    <title>Form</title>

</head>

<body>
    <div style=" text-align: center ">
        <h1>Enter Your Mobile Number</h1>



        <form id="mobileForm">

            @csrf

            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" required>

            <button type="submit">Submit</button>
        </form>
    </div>
    <script src="dist/cryptojs-aes.min.js"></script>
    <script src="dist/cryptojs-aes-format.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // function hide_value(){
        //     let valueToEncrypt = document.getElementById("mobile_number").value;
        //     let password = '123456'
        //     let encrypted = CryptoJSAesJson.encrypt(valueToEncrypt, password)
        //     console.log('Encrypted:', encrypted)
        // }

        //emplement the brainfoolong/cryptojs-aes- package in jsfor encription and decription
        $(document).ready(function() {

            $("#mobileForm").submit(function(e) {

                e.preventDefault(); // Prevent the form from submitting normally

                let valueToEncrypt = $("#mobile_number").val();
                let password = '123456';
                let encrypted = CryptoJSAesJson.encrypt(valueToEncrypt, password);

                // Send an Ajax POST request to the 'check' route with the encrypted data
                $.ajax({
                    type: "POST",
                    url: "{{ route('check') }}",
                    data: {
                        encrypted_data: encrypted,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // Decrypt the response
                        console.log(response.re_encrypted_data);
                        let decrypted = CryptoJSAesJson.decrypt(response.re_encrypted_data,
                            password);

                        // Display the decrypted response in the console
                        console.log('Decrypted Response:', decrypted);
                    },
                    error: function(xhr, status, error) {
                        console.error('Ajax Request Failed:', error);
                    }
                });
            });
        });
    </script>

</body>

</html>
