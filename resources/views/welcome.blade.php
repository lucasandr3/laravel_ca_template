<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme:{
                extend: {
                    colors:{
                        azul:{
                            claro: '#FFFFFF',
                            escuro: '#061E3C',
                            hover: '#1057B0'
                        },
                    },

                    fontFamily:{
                        inter: ['Inter', 'sans-serif']
                    },

                    keyframes:{
                        sino_kf:{
                            '0%, 100%':{transform: 'rotate(-15deg)' },
                            '50%': {transform:'rotate(15deg)'}
                        }
                    },

                    animation: {sino:'sino_kf 0.31s ease-in-out infinite'}
                }
            }
        }
    </script>
</head>

<body class="bg-azul-claro font-inter flex justify-center items-center h-screen">
<main class="flex px-6 drop-shadow-2xl lg:w-3/4 justify-center">
    <section class="bg-white p-10 gap-6 flex flex-col rounded-lg lg:w-1/2 justify-center lg:rounded border-solid border-2 border-black-900">

        <div class="text-center">
            <h1 class="text-4xl mb-2 font-bold">Login</h1>
        </div>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                @foreach ($errors->all() as $error)
                    <span class="block sm:inline">{{$error}}</span><br>
                @endforeach
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
              </span>
            </div>
        @endif
        <form method="POST" action="{{route('login.auth')}}">
            @csrf
            <label class="text-sm font-bold text-gray-700 mb-3" for="email">Email</label>
            <input class="text-sm w-full mb-6 pl-3 rounded border py-2 shadow-md focus:outline-none hover:border-azul-claro hover:ring-1 hover:ring-azul-escuro focus:border-azul-escuro focus:ring-1 focus:ring-azul-escuro" id="email" type="email" name="email" value="{{old('email') ?? ''}}" placeholder="Digite seu endereço de email" />
            <label class="text-sm font-bold text-gray-700 mb-2" for="email">Senha</label>
            <input class="text-sm w-full mb-6 pl-3 rounded border py-2 shadow-md focus:outline-none hover:border-azul-claro hover:ring-1 hover:ring-azul-escuro focus:border-azul-escuro focus:ring-1 focus:ring-azul-escuro" id="email" type="password" name="password" placeholder="Digite sua senha" />
            <button class="font-bold text-white bg-azul-escuro w-full py-2 rounded-full shadow-2xl hover:bg-azul-hover duration-150" type="submit">Entrar</button>
        </form>
    </section>
</main>
</body>
</html>
