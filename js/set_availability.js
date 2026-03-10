const monthYear = document.getElementById("monthYear");
const calendarDates = document.getElementById("calendarDates");
const prevMonthBtn = document.getElementById("prevMonth");
const nextMonthBtn = document.getElementById("nextMonth");

const modal = document.getElementById("availabilityModal");
const closeBtn = document.querySelector(".close-btn");
const modalDateTitle = document.getElementById("modalDateTitle");
const saveBtn = document.getElementById("saveAvailability");
const startTime = document.getElementById("startTime");
const endTime = document.getElementById("endTime");
const savedTimes = document.getElementById("savedTimes");

let currentDate = new Date();
let selectedDateKey = null;
let availability = {};

// NAVBAR ACTIVE
document.querySelectorAll(".nav-link").forEach(link => {
    link.addEventListener("click", function () {
        document.querySelectorAll(".nav-link").forEach(l => l.classList.remove("active"));
        this.classList.add("active");
    });
});

// dropdown profile
const profile = document.getElementById("profileToggle");

profile.addEventListener("click", function () {
    this.classList.toggle("active");
});

document.addEventListener("click", function (e) {
    if (!profile.contains(e.target)) {
        profile.classList.remove("active");
    }
});

function renderCalendar() {

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    monthYear.innerText =
        currentDate.toLocaleString("default", { month: "long" }) +
        " " + year;

    calendarDates.innerHTML = "";

    for (let i = 0; i < firstDay; i++) {
        calendarDates.appendChild(document.createElement("div"));
    }

    for (let day = 1; day <= lastDate; day++) {

        const dateDiv = document.createElement("div");
        dateDiv.classList.add("date");
        dateDiv.innerText = day;

        const key = `${year}-${month}-${day}`;

        if (availability[key]) {
            dateDiv.classList.add("available");
        }

        dateDiv.addEventListener("click", function() {

            selectedDateKey = key;

            modalDateTitle.innerText =
                "Set Availability for " +
                day + " " +
                currentDate.toLocaleString("default", { month: "long" }) +
                " " + year;

            loadSavedTimes();
            modal.style.display = "block";
        });

        calendarDates.appendChild(dateDiv);
    }
}

function loadSavedTimes() {

    savedTimes.innerHTML = "";

    if (!availability[selectedDateKey]) return;

    availability[selectedDateKey].forEach(time => {
        const div = document.createElement("div");
        div.classList.add("saved-time-item");
        div.innerText = time;
        savedTimes.appendChild(div);
    });
}

saveBtn.addEventListener("click", () => {

    if (!startTime.value || !endTime.value) {
        alert("Please select start and end time.");
        return;
    }

    const timeRange = startTime.value + " - " + endTime.value;

    if (!availability[selectedDateKey]) {
        availability[selectedDateKey] = [];
    }

    availability[selectedDateKey].push(timeRange);

    startTime.value = "";
    endTime.value = "";

    renderCalendar();
    loadSavedTimes();
});

closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});

prevMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

renderCalendar();