document.addEventListener("DOMContentLoaded", () => {
    // --- Get the stored kiosk number ---
    const kioskNumber = localStorage.getItem("kioskNumber") || "Unknown";

    // Update the heading
    const kioskHeading = document.getElementById("kioskNumberHeading");
    if (kioskHeading) {
        kioskHeading.textContent = `KIOSK ${kioskNumber}`;
    }
    // --- Show Date & Time ---
    function updateDateTime() {
        const now = new Date();
        const formatted = now.getFullYear() + "-" +
            String(now.getMonth() + 1).padStart(2, '0') + "-" +
            String(now.getDate()).padStart(2, '0') + " | " +
            String(now.getHours()).padStart(2, '0') + ":" +
            String(now.getMinutes()).padStart(2, '0') + ":" +
            String(now.getSeconds()).padStart(2, '0');
        const dt = document.getElementById("datetime");
        if (dt) dt.textContent = formatted;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // --- Mood mapping ---
    const moodMap = {
        "Overjoyed": 2,
        "Happy": 1,
        "Neutral": 0,
        "Sad": -1,
        "Angry": -2,
    };

    // --- Global feedback object ---
    let feedback = { mood: null };

    // --- Select smiley on homepage ---
    window.selectSmiley = function (label) {
        const expiryTime = Date.now() + 20000; // timeout after 20s
        const moodValue = moodMap[label]; // convert label to int
        feedback.mood = moodValue;

        // Store BOTH label (for Google Form) and value (for logic)
        sessionStorage.setItem("moodValue", moodValue); 
        sessionStorage.setItem("moodLabel", label);     
        sessionStorage.setItem("reasons", "");
        sessionStorage.setItem("expiry", expiryTime);

        window.location.href = "/questions"; // move to questions page
    };

    // --- If on the questions page ---
    if (window.location.pathname.includes("questions")) {
        const moodValue = parseInt(sessionStorage.getItem("moodValue"), 10);
        const moodLabel = sessionStorage.getItem("moodLabel");

        // No mood? Kick back to start
        if (!moodLabel) {
            window.location.href = "/";
            return;
        }

        // Check expiry
        setInterval(() => {
            const expiry = sessionStorage.getItem("expiry");
            if (expiry && Date.now() > parseInt(expiry)) {
                sendFeedback(moodLabel, ""); // auto-submit when expired
            }
        }, 1000);

        // --- Render questions ---
        const positiveQuestions = ["Clean", "No Bad Smell", "Cool Temperature", "With Soap", "With Tissue", "Dry Floor"];
        const negativeQuestions = ["Dirty", "Bad Smell", "Hot Temperature", "Without Soap", "Without Tissue", "Wet Floor"];
        
        const questionList = (moodValue >= 0) ? positiveQuestions : negativeQuestions;

        const title = document.getElementById("title");
        if (title) {
            title.innerText = (moodValue >= 0) ? "What did you like?" : "What didn’t you like?";
        }

        const container = document.getElementById("questions");
        if (container) {
            questionList.forEach((q, i) => {
                const id = `reason-${i}`;
                const wrapper = document.createElement("div");
                wrapper.className = "inline-block"; // keeps buttons inline instead of stacked

                wrapper.innerHTML = `
                    <input type="checkbox" id="${id}" name="reasons" value="${q}" class="hidden peer">
                    <label for="${id}" class="peer-checked:bg-BDark peer-checked:text-white
                            peer-disabled:bg-gray-300 peer-disabled:border-none peer-disabled:cursor-not-allowed
                            bg-BMain text-white border border-BDark
                            rounded-lg text-3xl font-bold 2xl:p-6 xl:p-4
                            flex items-center justify-center
                            cursor-pointer text-center
                            transition-colors duration-200 select-none 2xl:h-[10vh] xl:h-[8vh]">
                        ${q}
                    </label>
                `;

                container.appendChild(wrapper);
            });
        }


        // Refresh session on interaction
        function refreshSession() {
            sessionStorage.setItem("expiry", Date.now() + 30000);
        }

        document.addEventListener("change", e => {
            if (e.target.name === "reasons") {
                refreshSession();
                const checked = [...document.querySelectorAll('input[name="reasons"]:checked')];
                const allCheckboxes = document.querySelectorAll('input[name="reasons"]');

                // Disable unchecked boxes if 3 selected
                if (checked.length >= 3) {
                    allCheckboxes.forEach(cb => {
                        if (!cb.checked) cb.disabled = true;
                    });
                } else {
                    // Re-enable all if less than 3
                    allCheckboxes.forEach(cb => cb.disabled = false);
                }

                const btn = document.getElementById("nextBtn");
                if (btn) btn.innerText = checked.length > 0 ? "Submit" : "Skip";
            }
        });

        // Handle submit
        const form = document.getElementById("feedbackForm");
        if (form) {
            form.addEventListener("submit", e => {
                e.preventDefault();
                const selected = [...document.querySelectorAll('input[name="reasons"]:checked')].map(cb => cb.value);
                const reasons = selected.length > 0 ? selected.join(", ") : "";
                sendFeedback(moodLabel, reasons); // always send label to Google
            });
        }
    }

    // --- Function to send feedback ---
    function sendFeedback(mood, reasons, isTimeout = false) {
        const now = new Date();
        const hour = now.getHours(); // 0–23 (24-hour clock)

        // Block recording if time is between 9pm (21) and 9am (9)
        if (hour >= 21 || hour < 9) {
            alert("Kiosk is inactive from 9PM to 9AM. Please try again later.");
            sessionStorage.clear();
            // Just go straight back to the start
            window.location.href = "/";
            return;
        }

        // Retrieve kiosk info from localStorage
        const kioskNumber = localStorage.getItem("kioskNumber") || "Unknown";
        const attendeeName = localStorage.getItem("attendeeName") || "Unknown";

        const formData = new FormData();
        formData.append("entry.177420377", mood || "");   // mood = word (Happy)
        formData.append("entry.578363766", reasons || ""); // reasons = words list
        formData.append("entry.1770732915", kioskNumber); // attaches kiosk number from local
        formData.append("entry.1462498378", attendeeName); // attaches attendee from local

        fetch("https://docs.google.com/forms/u/0/d/e/1FAIpQLScpGH2FmZIz85OZCL6SmMzbE9VDp9j-xwXEy4aZIjR11rDCDw/formResponse", {
            method: "POST",
            mode: "no-cors",
            body: formData
        }).then(() => {
            console.log("Feedback sent:", { mood, reasons, kioskNumber, attendeeName });
            sessionStorage.clear();
            window.location.href = "/thanks";
        }).catch(err => {
            console.error("Error:", err);
            alert("Failed to send feedback. Please try again.");
            window.location.href = "/";
        });
    }

});

document.addEventListener("DOMContentLoaded", () => {
    // --- Thank-you page logic ---
    if (window.location.pathname.includes("thanks")) {
        // 10-second auto-redirect to welcome page
        setTimeout(() => {
            window.location.href = "/";
        }, 10000);
    }
});
