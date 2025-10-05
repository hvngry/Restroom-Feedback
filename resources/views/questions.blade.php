<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('sm-logo.ico') }}" type="image/x-icon"/>

        <title>SM Restroom Feedback</title>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="overscroll-none bg-gradient-to-tr from-BMain to-BDark h-scr]] een font-sans">
        <section class="w-screen h-screen flex flex-col 2xl:justify-none xl:justify-center">
        <div class="flex flex-col p-8 mt-[-2%] 2xl:items-none xl:items-between">
            
            <!--Heading Div-->
            <div class="xl:absolute xl:top-0 xl:left-0 xl:p-[2%] 2xl:static 2xl:p-0 flex justify-between items-baseline w-full mt-2">
                <span id="datetime" class="text-[5vh] text-BLight font-semibold">
                    
                </span>
                <div id="kioskNumberHeading" class="text-[5vh] text-BLight font-bold">
                    
                </div>
            </div>

            <div class="flex-grow flex justify-center items-center">
            <div class="bg-gradient-to-br from-white to-BLight rounded-xl p-1 w-full 2xl:h-[85vh] xl:h-[70vh]">
            <form id="feedbackForm" class="p-10">
                <h2 id="title" class="text-[6vh] text-center text-BDark font-bold"></h2>

                <div id="questions" class="grid grid-cols-2 gap-12 w-full max-w-[90%] mx-auto 2xl:mt-[2%] xl:mt-[3%]"></div>

                <button id="nextBtn" type="submit"
                        class="block mx-auto bg-none 2xl:mt-[5%] xl:mt-[4%] border-4 border-BDark rounded-xl 2xl:p-6 xl:p-4 text-BDark
                        text-3xl font-semibold w-54 transition-[500ms] hover:bg-BMain hover:text-white">
                    Skip
                </button>
            </form>
            </div>
            </div>

            <!--Logo Div-->
            <div class="pointer-events-none h-full w-15/16 bottom-5 absolute z-2 flex items-end justify-end">
                <img class="w-[10%]" src="/img/sm-logo.png"></img>
            </div>
        <section>
    <script src="{{ asset('js/feedback.js') }}"></script>
    </body>
</html>
