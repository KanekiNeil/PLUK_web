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

// CALENDAR
const monthYear = document.getElementById("monthYear");
const datesContainer = document.getElementById("dates");
const selectedDate = document.getElementById("selectedDate");

let date = new Date();

function renderCalendar() {
    datesContainer.innerHTML = "";

    const year = date.getFullYear();
    const month = date.getMonth();

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    monthYear.innerText = date.toLocaleString("default", { month: "long" }) + " " + year;

    for (let i = 0; i < firstDay; i++) {
        datesContainer.innerHTML += "<span></span>";
    }

    for (let i = 1; i <= lastDate; i++) {
        let span = document.createElement("span");
        span.innerText = i;

        span.addEventListener("click", () => {
            document.querySelectorAll(".dates span").forEach(s => s.classList.remove("active-date"));
            span.classList.add("active-date");
            selectedDate.innerText = `${i} ${monthYear.innerText}`;
        });

        datesContainer.appendChild(span);
    }
}

document.getElementById("prev").onclick = () => {
    date.setMonth(date.getMonth() - 1);
    renderCalendar();
};

document.getElementById("next").onclick = () => {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
};

renderCalendar();


// LINE CHART (empty dataset)
const ctx = document.getElementById("lineChart").getContext("2d");

new Chart(ctx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "No Data Yet",
            data: [],
            borderColor: "#8b0000",
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});