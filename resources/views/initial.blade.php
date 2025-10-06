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
            <select id="kioskNumber" class="border-1 border-BDark rounded-lg p-4 text-xl text-center" required>
                <option value="Prototype">Prototype</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
            <select id="restroomType" class="border-1 border-BDark rounded-lg p-4 text-xl text-center" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

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
        const restroomType = document.getElementById("restroomType").value.trim();

        if (!kioskNumber || !restroomType) return;

        localStorage.setItem("kioskInitialized", "true");
        localStorage.setItem("kioskNumber", kioskNumber);
        localStorage.setItem("restroomType", restroomType);

        // Redirect to smiley welcome page
        window.location.href = "/";

    });
});
</script>
</body>
</html>