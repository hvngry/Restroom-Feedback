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
<body class="min-h-screen bg-[radial-gradient(circle_at_bottom,#2c519b_0,#18336b_100%)] bg-fixed">
    <section class="w-screen h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-xl shadow-lg w-full max-w-md text-center">
        <h2 class="text-3xl font-bold mb-12 text-BDark">Initialize Kiosk</h2>

        <form id="kioskSetupForm" class="flex flex-col gap-6">
        <input type="number" id="kioskNumber" placeholder="Kiosk Number" 
                class="border-1 border-BDark rounded-lg p-4 text-xl text-center" required>
        <input type="text" id="attendeeName" placeholder="Your Name" 
                class="border-1 border-BDark rounded-lg p-4 text-xl text-center" required>

        <button type="submit" 
                class="bg-BDark text-white rounded-xl p-4 text-2xl font-semibold w-44
                       block mx-auto hover:bg-BMain transition-colors duration-500">
            Initialize
        </button>
        </form>
    </div>
    </section>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("kioskSetupForm");

    // Check if kiosk already initialized
    if (localStorage.getItem("kioskInitialized")) {
        window.location.href = "/"; // redirect to smiley welcome page
        return;
    }

    form.addEventListener("submit", e => {
        e.preventDefault();
        const kioskNumber = document.getElementById("kioskNumber").value.trim();
        const attendeeName = document.getElementById("attendeeName").value.trim();

        if (!kioskNumber || !attendeeName) return;

        localStorage.setItem("kioskInitialized", "true");
        localStorage.setItem("kioskNumber", kioskNumber);
        localStorage.setItem("attendeeName", attendeeName);

        // Redirect to smiley welcome page
        window.location.href = "/";

    });
});
</script>
</body>
</html>
