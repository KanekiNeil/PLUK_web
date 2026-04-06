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

// filter calendar 

const filterBtn = document.querySelector(".filter-calendar");
const dateInput = document.getElementById("overviewDate");
const applicantCount = document.getElementById("applicantCount");
const clientCount = document.getElementById("clientCount");
const eventCount = document.getElementById("eventCount");
const selectedDateLabel = document.getElementById("selectedDate");

filterBtn.addEventListener("click", () => {
    if (typeof dateInput.showPicker === 'function') {
        dateInput.showPicker();
    } else {
        dateInput.click();
    }
});

function updateStatsForDate(dateStr) {
    if (!dateStr) return;

    fetch(`../php/get_dashboard_stats.php?date=${encodeURIComponent(dateStr)}`)
        .then(response => response.json())
        .then(json => {
            if (json.error) {
                console.error('Dashboard stats error:', json.error);
                return;
            }
            if (applicantCount) applicantCount.textContent = json.applicants;
            if (clientCount) clientCount.textContent = json.clients;
            if (eventCount) eventCount.textContent = json.events;
            if (selectedDateLabel) {
                const formatted = new Date(dateStr).toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
                selectedDateLabel.textContent = formatted;
            }
        })
        .catch(err => {
            console.error('Failed to fetch dashboard stats:', err);
        });
}

// initialize with current selection (if any)
function initDashboardStats() {
    const initialDate = dateInput.value || new Date().toISOString().slice(0, 10);
    dateInput.value = initialDate;
    updateStatsForDate(initialDate);
}

initDashboardStats();

dateInput.addEventListener("change", () => {
    const selected = dateInput.value;
    console.log("Filter dashboard data for: " + selected);
    updateStatsForDate(selected);
    // Later you can fetch from database here using AJAX
});

// CALENDAR
const monthYear = document.getElementById("monthYear");
const datesContainer = document.getElementById("dates");
const selectedDateHeading = document.getElementById("selectedDate");

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
            if (selectedDateHeading) {
                selectedDateHeading.innerText = `${i} ${monthYear.innerText}`;
            }
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


async function loadDashboard() {
    const res = await fetch("../php/fetch_pie_and_bar_dashboard.php");
    const data = await res.json();

    console.log(data);

    renderPriorities(data.priorities);
    renderJobs(data.jobs);
}

// PIE
function renderPriorities(data) {
    const pie = document.querySelector(".pie");
    const legend = document.querySelector(".pie-legend");

    pie.innerHTML = "";
    legend.innerHTML = "";

    const total = data.reduce((a,b) => a + Number(b.count), 0) || 1;

    const colors = ["#4e73df", "#e74a3b", "#1cc88a", "#f6c23e", "#36b9cc"];

    // build gradient
    let gradient = "";
    let start = 0;

    data.forEach((item, index) => {
        const percent = (item.count / total) * 100;
        const end = start + percent;

        gradient += `${colors[index % colors.length]} ${start}% ${end}%`;
        if (index < data.length - 1) gradient += ", ";

        start = end;

        // LEGEND ITEM
        const legendItem = document.createElement("div");
        legendItem.className = "legend-item";

        legendItem.innerHTML = `
            <div class="legend-color" style="background:${colors[index % colors.length]}"></div>
            <span>${item.priority} (${item.count})</span>
        `;

        legend.appendChild(legendItem);
    });

    pie.style.background = `conic-gradient(${gradient})`;

    // optional center label
    const center = document.createElement("div");
    center.className = "pie-center";
    center.innerText = "Priorities";

    pie.appendChild(center);
}

// BAR
function renderJobs(data) {
    const bars = document.querySelector(".bars");
    const yAxis = document.querySelector(".bar-yaxis");

    bars.innerHTML = "";
    yAxis.innerHTML = "";

    const max = Math.max(...data.map(d => Number(d.count))) || 1;

    // =====================
    // CREATE Y AXIS LABELS
    // =====================
    const steps = 5;

    for (let i = steps; i >= 0; i--) {
        const value = Math.round((max / steps) * i);

        const label = document.createElement("div");
        label.innerText = value;

        yAxis.appendChild(label);
    }

    // =====================
    // CREATE BARS
    // =====================
    const colors = ["red", "blue", "teal", "orange", "yellow"];

    data.forEach((item, index) => {
        const bar = document.createElement("div");
        bar.className = "bar " + colors[index % colors.length];

        bar.style.height = (item.count / max) * 100 + "%";

        bar.innerHTML = `<span>${item.job}</span>`;

        bars.appendChild(bar);
    });
}

document.addEventListener("DOMContentLoaded", loadDashboard);