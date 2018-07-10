<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Layouts - Auth - Cover</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="font-sans bg-white text-grey-darkest">
    <div id="app" class="flex items-center h-screen">
        <div class="w-1/3 flex flex-col h-screen px-12 border-t-4 border-blue justify-center">
            <div class="text-center text-4xl font-semibold mb-3 text-black">Sign In</div>
            <div class="text-center text-grey-dark text-sm mb-12">Free access to our dashboard</div>

            <div>
                <div>
                    <label class="block mb-3 text-black text-sm font-medium">Email Address</label>
                    <input type="email" name="" id="" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="name@example.com">
                </div>

                <div class="my-6">
                    <div class="flex items-center justify-between mb-3">
                        <label class="text-black text-sm font-medium">Password</label>
                        <a href="#" class="no-underline text-grey text-sm">Forgot password?</a>
                    </div>

                    <input type="password" name="" id="" class="block w-full rounded border p-3 bg-transparent focus:outline-none focus:border-blue" placeholder="Enter your password">
                </div>

                <a href="#" class="block w-full rounded bg-blue text-white py-4 no-underline text-center font-medium">Sign In</a>

                <div class="mt-6 text-grey-dark text-xs text-center">Don't have an account yet? <a href="#" class="no-underline text-blue">Sign up.</a></div>
            </div>
        </div>

        <div class="flex-1 h-screen bg-no-repeat bg-center bg-cover" style="background-image:url(/images/auth-side-cover.jpg)"></div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>