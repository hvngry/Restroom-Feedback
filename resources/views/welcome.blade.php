<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('sm-logo.ico') }}" type="image/x-icon"/>

        <title>SM Restroom Feedback</title>

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            const isInitialized = localStorage.getItem("kioskInitialized");
            if (!isInitialized) {
                window.location.href = "/initial";
            }
        </script>
    </head>

    <body class="overscroll-none bg-gradient-to-tr from-BMain to-BDark h-screen font-sans">
        <section class="w-screen h-screen flex flex-col 2xl:justify-none xl:justify-center">
        <div class="flex flex-col p-8 mt-[-2%] 2xl:items-none xl:items-between">
            
            <!--Heading Div-->
            <div class="xl:absolute xl:top-0 xl:left-0 xl:p-[2%] 2xl:static 2xl:p-0 flex justify-between items-baseline w-full mt-2">
                <span id="datetime" class="text-[5vh] text-BLight font-semibold">
                    
                </span>
                <div id="kioskNumberHeading" class="text-[5vh] text-BLight font-bold">
                    
                </div>
            </div>

            <!--Smiley Div-->
            <div class="flex-grow flex justify-center items-center">
            <div class="bg-gradient-to-br from-white to-BLight rounded-xl p-1">
                <h2 class="mt-24 text-[7vh] text-center text-BDark font-bold">How was your experience?</h2>
                <div class="flex justify-center mt-[-2px] 2xl:h-[64vh] xl:h-[50vh] rounded-3xl">
                    <!--Angry-->
                    <svg xmlns="http://www.w3.org/2000/svg" onclick="selectSmiley('Angry')" class="filter drop-shadow-[2px_2px_10px_rgba(222,222,222,1)] fill-red-600 w-[70%] transition-[700ms] ease-in-out active:w-[75%] active:-translate-y-2 active:fill-red-800" viewBox="0 0 640 640">
                        <!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                        <path d="M64 320C64 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320C576
                        461.4 461.4 576 320 576C178.6 576 64 461.4 64 320zM320 432C344.1 432 365.4 443.8 378.5 462C386.2
                        472.8 401.2 475.2 412 467.5C422.8 459.8 425.2 444.8 417.5 434C395.8 403.8 360.2 384 320 384C279.8
                        384 244.3 403.8 222.5 434C214.8 444.8 217.2 459.8 228 467.5C238.8 475.2 253.8 472.8 261.5 462C274.6
                        443.8 295.9 432 320 432zM240 336C257.7 336 272 321.7 272 304L272 303.7L281.7 306.9C292.2 310.4
                        303.5 304.7 307 294.3C310.5 283.9 304.8 272.5 294.4 269L198.4 237C187.9 233.5 176.6 239.2 173.1
                        249.6C169.6 260 175.3 271.4 185.7 274.9L214.6 284.5C210.5 289.9 208 296.6 208 303.9C208 321.6 222.3
                        335.9 240 335.9zM432 304C432 296.7 429.6 290 425.4 284.6L454.3 275C464.8 271.5 470.4 260.2 466.9
                        249.7C463.4 239.2 452.1 233.6 441.6 237.1L345.6 269.1C335.1 272.6 329.5 283.9 333 294.4C336.5 304.9
                        347.8 310.5 358.3 307L368 303.8L368 304.1C368 321.8 382.3 336.1 400 336.1C417.7 336.1 432 321.8 432 304.1z"/>
                    </svg>
                    <!--Sad-->
                    <svg xmlns="http://www.w3.org/2000/svg" onclick="selectSmiley('Sad')" class="filter drop-shadow-[2px_2px_10px_rgba(222,222,222,1)] fill-blue-500 w-[70%] transition-[700ms] ease-in-out active:w-[75%] active:-translate-y-2 active:fill-blue-700" viewBox="0 0 640 640">
                    <!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64
                    320C64 461.4 178.6 576 320 576zM410.6 462.1C390.2 434.1 357.2 416 320 416C282.8 416 249.8 434.1
                    229.4 462.1C221.6 472.8 206.6 475.2 195.9 467.4C185.2 459.6 182.8 444.6 190.6 433.9C219.7 394 266.8
                    368 320 368C373.2 368 420.3 394 449.4 433.9C457.2 444.6 454.8 459.6 444.1 467.4C433.4 475.2 418.4
                    472.8 410.6 462.1zM208 272C208 254.3 222.3 240 240 240C257.7 240 272 254.3 272 272C272 289.7 257.7 304
                    240 304C222.3 304 208 289.7 208 272zM400 240C417.7 240 432 254.3 432 272C432 289.7 417.7 304 400 304C382.3
                    304 368 289.7 368 272C368 254.3 382.3 240 400 240z"/>
                    </svg>
                    <!--Neutral-->
                    <svg xmlns="http://www.w3.org/2000/svg" onclick="selectSmiley('Neutral')" class="filter drop-shadow-[2px_2px_10px_rgba(222,222,222,1)] fill-yellow-500 w-[70%] transition-[700ms] ease-in-out active:w-[75%] active:-translate-y-2 active:fill-yellow-700" viewBox="0 0 640 640">
                    <!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6
                    64 64 178.6 64 320C64 461.4 178.6 576 320 576zM240 240C257.7 240 272 254.3 272 272C272 289.7
                    257.7 304 240 304C222.3 304 208 289.7 208 272C208 254.3 222.3 240 240 240zM368 272C368 254.3
                    382.3 240 400 240C417.7 240 432 254.3 432 272C432 289.7 417.7 304 400 304C382.3 304 368 289.7
                    368 272zM240 384L400 384C413.3 384 424 394.7 424 408C424 421.3 413.3 432 400 432L240 432C226.7
                    432 216 421.3 216 408C216 394.7 226.7 384 240 384z"/>
                    </svg>
                    <!--Happy-->
                    <svg xmlns="http://www.w3.org/2000/svg" onclick="selectSmiley('Happy')" class="filter drop-shadow-[2px_2px_10px_rgba(222,222,222,1)] fill-orange-500 w-[70%] transition-[700ms] ease-in-out active:w-[75%] active:-translate-y-2 active:fill-orange-700" viewBox="0 0 640 640">
                    <!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6
                    64 64 178.6 64 320C64 461.4 178.6 576 320 576zM229.4 385.9C249.8 413.9 282.8 432 320 432C357.2
                    432 390.2 413.9 410.6 385.9C418.4 375.2 433.4 372.8 444.1 380.6C454.8 388.4 457.2 403.4 449.4
                    414.1C420.3 454 373.2 480 320 480C266.8 480 219.7 454 190.6 414.1C182.8 403.4 185.2 388.4 195.9
                    380.6C206.6 372.8 221.6 375.2 229.4 385.9zM208 272C208 254.3 222.3 240 240 240C257.7 240 272 254.3
                    272 272C272 289.7 257.7 304 240 304C222.3 304 208 289.7 208 272zM400 240C417.7 240 432 254.3 432
                    272C432 289.7 417.7 304 400 304C382.3 304 368 289.7 368 272C368 254.3 382.3 240 400 240z"/>
                    </svg>
                    <!--Overjoyed-->
                    <svg xmlns="http://www.w3.org/2000/svg" onclick="selectSmiley('Overjoyed')" class="filter drop-shadow-[2px_2px_10px_rgba(222,222,222,1)] fill-green-600 w-[70%] transition-[700ms] ease-in-out active:w-[75%] active:-translate-y-2 active:fill-green-800" viewBox="0 0 640 640">
                    <!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320
                    64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM229.4 385.9C249.8 413.9 282.8
                    432 320 432C357.2 432 390.2 413.9 410.6 385.9C418.4 375.2 433.4 372.8 444.1 380.6C454.8
                    388.4 457.2 403.4 449.4 414.1C420.3 454 373.2 480 320 480C266.8 480 219.7 454 190.6 414.1C182.8
                    403.4 185.2 388.4 195.9 380.6C206.6 372.8 221.6 375.2 229.4 385.9zM240 244C224.5 244 212
                    256.5 212 272L212 280C212 291 203 300 192 300C181 300 172 291 172 280L172 272C172 234.4
                    202.4 204 240 204C277.6 204 308 234.4 308 272L308 280C308 291 299 300 288 300C277 300 268
                    291 268 280L268 272C268 256.5 255.5 244 240 244zM372 272L372 280C372 291 363 300 352 300C341
                    300 332 291 332 280L332 272C332 234.4 362.4 204 400 204C437.6 204 468 234.4 468 272L468
                    280C468 291 459 300 448 300C437 300 428 291 428 280L428 272C428 256.5 415.5 244 400 244C384.5
                    244 372 256.5 372 272z"/>
                    </svg>
                </div>
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
