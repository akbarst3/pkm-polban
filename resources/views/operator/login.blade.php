<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center justify-content-center bg-light" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/PKMPOLBAN.png') }}" alt="PKM POLBAN" class="img-fluid" style="max-width: 350px;">
                </div>

                <div class="card">
                    <div class="card-body">
                        <form id="login-form" action="{{ route('operator.login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label id="math-question"></label>
                                <input type="number" id="math-answer" class="form-control"
                                    placeholder="Hasil Penjumlahan" required>
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
        let correctAnswer;

        function generateMathQuestion() {
            const num1 = Math.floor(Math.random() * 10) + 1;
            const num2 = Math.floor(Math.random() * 10) + 1;
            document.getElementById('math-question').innerText = `${num1} + ${num2} = `;
            correctAnswer = num1 + num2;
        }

        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const answer = parseInt(document.getElementById('math-answer').value, 10);
            if (answer === correctAnswer) {
                alert("Login berhasil!");
                event.target.submit();
            } else {
                alert("Jawaban penjumlahan salah!");
            }
        });

        generateMathQuestion();
    </script>

</body>

</html>
