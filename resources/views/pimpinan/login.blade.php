<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
</head>

<body class="d-flex align-items-center justify-content-center bg-light" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/PKMPOLBAN.png') }}" alt="PKM POLBAN" class="img-fluid"
                        style="max-width: 350px;">
                </div>

                <div class="card">
                    <div class="card-body">
                        @if ($errors->has('auth'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Gagal!',
                                    text: '{{ $errors->first('auth') }}',
                                    confirmButtonColor: '#003c72',
                                });
                            </script>
                        @endif
                        @if (session('timeout_message'))
                            <script>
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Sesi Berakhir',
                                    text: '{{ session('timeout_message') }}',
                                    confirmButtonColor: '#003c72',
                                });
                            </script>
                        @endif
                        <form id="login-form" action="{{ route('perguruan-tinggi.login') }}" method="post"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" value="{{ old('username') }}" required>
                                <div class="invalid-feedback">
                                    Username wajib diisi.
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                                <div class="invalid-feedback">
                                    Password wajib diisi.
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <p id="math-question"></p>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="math-answer" class="form-control"
                                        placeholder="Hasil Penjumlahan" inputmode="numeric" required>
                                    <div class="invalid-feedback">
                                        Isi hasil penjumlahan.
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary btn-block" value="Login">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms)
                    .forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            if (!form.checkValidity()) {
                                event.preventDefault();
                                event.stopPropagation();
                            } else {
                                const answer = parseInt(document.getElementById('math-answer')
                                    .value, 10);
                                if (answer !== correctAnswer) {
                                    event.preventDefault();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Jawaban salah!',
                                        text: 'Silakan masukkan hasil penjumlahan yang benar.',
                                        confirmButtonColor: '#003c72',
                                        timer: 3000,
                                        timerProgressBar: true,
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        }
                                    });
                                }
                            }

                            form.classList.add('was-validated');
                        }, false);
                    });
            })();

            document.getElementById('math-answer').addEventListener('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
            let correctAnswer;

            function generateMathQuestion() {
                const num1 = Math.floor(Math.random() * 10) + 1;
                const num2 = Math.floor(Math.random() * 10) + 1;
                document.getElementById('math-question').innerText = `${num1} + ${num2} = `;
                correctAnswer = num1 + num2;
            }

            generateMathQuestion();
        })
    </script>
</body>