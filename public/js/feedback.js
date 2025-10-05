// Google Form: https://docs.google.com/forms/u/0/d/e/1FAIpQLScpGH2FmZIz85OZCL6SmMzbE9VDp9j-xwXEy4aZIjR11rDCDw/formResponse

document.addEventListener("DOMContentLoaded", () => {
    // Gets stored kiosk number and restroom type
    const kioskNumber = localStorage.getItem("kioskNumber") || "Unknown";
    const restroomType = localStorage.getItem("restroomType") || "Unknown";

    // Update page heading
    const kioskHeading = document.getElementById("kioskNumberHeading");
    if (kioskHeading) {
        kioskHeading.textContent = `KIOSK ${kioskNumber} | ${restroomType}`;
    }
    // Date and time
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

    // Mood mapping
    const moodMap = {
        "Overjoyed": 2,
        "Happy": 1,
        "Neutral": 0,
        "Sad": -1,
        "Angry": -2,
    };

    // Global feedback object
    let feedback = { mood: null };

    // If Smiley page
    window.selectSmiley = function (label) {
        const expiryTime = Date.now() + 20000; // 20s Timeout
        const moodValue = moodMap[label]; // Converts label into int
        feedback.mood = moodValue;

        sessionStorage.setItem("moodValue", moodValue); 
        sessionStorage.setItem("moodLabel", label);     
        sessionStorage.setItem("reasons", "");
        sessionStorage.setItem("expiry", expiryTime);

        window.location.href = "/questions"; // Redirect to Questions page
    };

    // If Questions page
    if (window.location.pathname.includes("questions")) {
        const moodValue = parseInt(sessionStorage.getItem("moodValue"), 10);
        const moodLabel = sessionStorage.getItem("moodLabel");

        // Back to start if no mood was selected
        if (!moodLabel) {
            window.location.href = "/";
            return;
        }

        // Check expiry and auto-submit
        let autoSubmitted = false; // Prevent multiple submissions
        setInterval(() => {
            const expiry = sessionStorage.getItem("expiry");
            if (expiry && Date.now() > parseInt(expiry) && !autoSubmitted) {
                autoSubmitted = true;

                // Get selected reasons at this moment
                const selected = [...document.querySelectorAll('input[name="reasons"]:checked')]
                    .map(cb => cb.value);
                const reasons = selected.length > 0 ? selected.join(", ") : "";

                sendFeedback(moodLabel, reasons, true); // Auto-submit
            }
        }, 1000);

        // Questionnaire
        const positiveQuestions = ["Clean", "No Bad Smell", "Cool Temperature", "With Soap", "With Tissue", "Dry Floor"];
        const negativeQuestions = ["Dirty", "Bad Smell", "Hot Temperature", "Without Soap", "Without Tissue", "Wet Floor"];
        
        const questionList = (moodValue >= 0) ? positiveQuestions : negativeQuestions;

        const title = document.getElementById("title");
        if (title) {
            title.innerText = (moodValue >= 0) ? "What did you like?" : "What didn’t you like?";
        }
        // Questions formatting
        const container = document.getElementById("questions");
        if (container) {
            questionList.forEach((q, i) => {
                const id = `reason-${i}`;
                const wrapper = document.createElement("div");
                wrapper.className = "inline-block";

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
            sessionStorage.setItem("expiry", Date.now() + 20000); // 20s Refresh
        }

        document.addEventListener("change", e => {
            if (e.target.name === "reasons") {
                refreshSession();
                const checked = [...document.querySelectorAll('input[name="reasons"]:checked')];
                const allCheckboxes = document.querySelectorAll('input[name="reasons"]');

                // Max 3 selected
                if (checked.length >= 3) {
                    allCheckboxes.forEach(cb => {
                        if (!cb.checked) cb.disabled = true;
                    });
                } else {
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
                sendFeedback(moodLabel, reasons);
            });
        }
    }

    // Sending feedback
    function sendFeedback(mood, reasons, isTimeout = false) {
        const now = new Date();
        const hour = now.getHours(); // 0–23 (24-hour clock)

        // Don't record if time is between 9pm and 9am
        if (hour >= 21 || hour < 9) {
            alert("Kiosk is inactive from 9PM to 9AM. Please try again later.");
            sessionStorage.clear();
            // Just go straight back to the start
            window.location.href = "/";
            return;
        }

        const formData = new FormData();
        formData.append("entry.177420377", mood || "");   // Data sent: ("Angry", "Sad", "Neutral", "Happy", "Overjoyed")
        formData.append("entry.578363766", reasons || ""); // Data sent: List of provided reason options
        formData.append("entry.1770732915", kioskNumber); // Kiosk number from local
        formData.append("entry.1462498378", restroomType); // Restroom type from local

        fetch("https://docs.google.com/forms/u/0/d/e/1FAIpQLScpGH2FmZIz85OZCL6SmMzbE9VDp9j-xwXEy4aZIjR11rDCDw/formResponse", {
            method: "POST",
            mode: "no-cors",
            body: formData
        }).then(() => {
            console.log("Feedback sent:", { mood, reasons, kioskNumber, restroomType });
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
    // Thank you page timeout
    if (window.location.pathname.includes("thanks")) {
        setTimeout(() => {
            window.location.href = "/";
        }, 10000); // 10s Timeout
    }
});
