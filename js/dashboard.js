// NAVBAR ACTIVE
document.querySelectorAll(".nav-link").forEach(link => {
    link.addEventListener("click", function () {
        document.querySelectorAll(".nav-link").forEach(l => l.classList.remove("active"));
        this.classList.add("active");
    });
});

// dropdown profile
const profile = document.getElementById("profileToggle");

if (profile) {
    profile.addEventListener("click", function () {
        this.classList.toggle("active");
    });
}

document.addEventListener("click", function (e) {
    if (profile && !profile.contains(e.target)) {
        profile.classList.remove("active");
    }
});

// filter calendar 

const filterBtn = document.querySelector(".filter-calendar");
const dateInput = document.getElementById("overviewDate");
const applicantCount = document.getElementById("applicantCount");
const clientCount = document.getElementById("clientCount");
const eventCount = document.getElementById("eventCount");

if (filterBtn && dateInput) {
    filterBtn.addEventListener("click", () => {
        if (typeof dateInput.showPicker === "function") {
            dateInput.showPicker();
        } else {
            dateInput.click();
        }
    });
}

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
        })
        .catch(err => {
            console.error('Failed to fetch dashboard stats:', err);
        });
}

// initialize with current selection (if any)
function initDashboardStats() {
    if (!dateInput) return;
    const initialDate = dateInput.value || new Date().toISOString().slice(0, 10);
    dateInput.value = initialDate;
    updateStatsForDate(initialDate);
}

initDashboardStats();

if (dateInput) {
    dateInput.addEventListener("change", () => {
        const selected = dateInput.value;
        console.log("Filter dashboard data for: " + selected);
        updateStatsForDate(selected);
    });
}

// CALENDAR
const monthYear = document.getElementById("monthYear");
const datesContainer = document.getElementById("dates");
const selectedDateHeading = document.getElementById("selectedDate");
const appointmentsList = document.getElementById("appointmentsList");
const appointmentTypeFilter = document.getElementById("appointmentTypeFilter");

let date = new Date();
let appointmentDates = new Set();
let selectedCalendarDate = null;

function pad(value) {
    return String(value).padStart(2, "0");
}

function formatDateLong(dateStr) {
    const [year, month, day] = dateStr.split("-").map(Number);
    const localDate = new Date(year, month - 1, day);
    return localDate.toLocaleDateString(undefined, { year: "numeric", month: "long", day: "numeric" });
}

function renderAppointments(items) {
    if (!appointmentsList) return;

    appointmentsList.innerHTML = "";

    if (!items.length) {
        const empty = document.createElement("div");
        empty.className = "meeting";
        empty.textContent = "No appointments for this date.";
        appointmentsList.appendChild(empty);
        return;
    }

    items.forEach((item) => {
        const row = document.createElement("div");
        row.className = "meeting";

        const status = item.status ? ` | ${item.status}` : "";
        const type = item.type ? ` | ${item.type}` : "";
        row.textContent = `${item.time_range} | ${item.full_name}${type}${status}`;

        appointmentsList.appendChild(row);
    });
}

async function loadAppointmentsForDate(dateStr) {
    if (!dateStr) return;

    if (selectedDateHeading) {
        selectedDateHeading.textContent = formatDateLong(dateStr);
    }

    if (appointmentsList) {
        appointmentsList.innerHTML = '<div class="meeting">Loading appointments...</div>';
    }

    try {
        const selectedType = appointmentTypeFilter ? appointmentTypeFilter.value : "all";
        const res = await fetch(`../php/get_dashboard_appointments_by_date.php?date=${encodeURIComponent(dateStr)}&type=${encodeURIComponent(selectedType)}`);
        const data = await res.json();

        if (!res.ok || data.error) {
            throw new Error(data.error || "Failed to fetch appointments.");
        }

        renderAppointments(Array.isArray(data.appointments) ? data.appointments : []);
    } catch (err) {
        console.error("Failed to load appointments:", err);
        if (appointmentsList) {
            appointmentsList.innerHTML = '<div class="meeting">Unable to load appointments.</div>';
        }
    }
}

async function refreshCalendarAppointments() {
    const monthParam = `${date.getFullYear()}-${pad(date.getMonth() + 1)}`;

    try {
        const selectedType = appointmentTypeFilter ? appointmentTypeFilter.value : "all";
        const res = await fetch(`../php/get_dashboard_appointment_dates.php?month=${encodeURIComponent(monthParam)}&type=${encodeURIComponent(selectedType)}`);
        const data = await res.json();

        if (!res.ok || data.error) {
            throw new Error(data.error || "Failed to fetch appointment dates.");
        }

        appointmentDates = new Set(Array.isArray(data.dates) ? data.dates : []);
    } catch (err) {
        console.error("Failed to load appointment dates:", err);
        appointmentDates = new Set();
    }

    renderCalendar();
}

function renderCalendar() {
    if (!datesContainer || !monthYear) return;

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
        const dateKey = `${year}-${pad(month + 1)}-${pad(i)}`;

        if (appointmentDates.has(dateKey)) {
            span.classList.add("has-appointment");
            span.title = "Has appointments";
        }

        span.addEventListener("click", () => {
            document.querySelectorAll(".dates span").forEach(s => s.classList.remove("active-date"));
            span.classList.add("active-date");
            selectedCalendarDate = dateKey;
            loadAppointmentsForDate(dateKey);
        });

        datesContainer.appendChild(span);
    }
}

const prevButton = document.getElementById("prev");
const nextButton = document.getElementById("next");

if (prevButton) {
    prevButton.onclick = () => {
        date.setMonth(date.getMonth() - 1);
        refreshCalendarAppointments();
    };
}

if (nextButton) {
    nextButton.onclick = () => {
        date.setMonth(date.getMonth() + 1);
        refreshCalendarAppointments();
    };
}

if (appointmentTypeFilter) {
    appointmentTypeFilter.addEventListener("change", async () => {
        await refreshCalendarAppointments();

        if (selectedCalendarDate) {
            loadAppointmentsForDate(selectedCalendarDate);
        } else if (appointmentsList) {
            appointmentsList.innerHTML = '<div class="meeting">Select a date to view appointments.</div>';
        }
    });
}

refreshCalendarAppointments().then(() => {
    const today = new Date();
    if (today.getFullYear() === date.getFullYear() && today.getMonth() === date.getMonth()) {
        const todayKey = `${today.getFullYear()}-${pad(today.getMonth() + 1)}-${pad(today.getDate())}`;
        const todayCell = Array.from(document.querySelectorAll(".dates span")).find(
            (cell) => Number(cell.textContent) === today.getDate()
        );

        if (todayCell) {
            todayCell.classList.add("active-date");
            selectedCalendarDate = todayKey;
            loadAppointmentsForDate(todayKey);
            return;
        }
    }

    if (selectedDateHeading) {
        selectedDateHeading.textContent = "Select a date";
    }
    if (appointmentsList) {
        appointmentsList.innerHTML = '<div class="meeting">Select a date to view appointments.</div>';
    }
});


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

// total applicant count js

document.addEventListener("DOMContentLoaded", () => {
    loadApplicantCount();
});

function loadApplicantCount() {

    fetch("../php/get_applicant_count.php")
        .then(response => response.json())
        .then(data => {

            if (data.success) {
                document.getElementById("applicantCount").innerText =
                    data.totalApplicants;
            } else {
                console.error("Failed to load applicant count");
            }

        })
        .catch(error => {
            console.error("Fetch Error:", error);
        });
}


//total clients js
document.addEventListener("DOMContentLoaded", () => {
    loadDashboardCounts();
});

function loadDashboardCounts() {

    fetch("../php/get_client_count.php")
        .then(response => response.json())
        .then(data => {

            if (data.success) {

                document.getElementById("applicantCount").innerText =
                    data.applicants;

                document.getElementById("clientCount").innerText =
                    data.clients;

            } else {
                console.error("Failed to load dashboard counts");
            }

        })
        .catch(error => {
            console.error("Fetch Error:", error);
        });
}

// get_upcoming events js

document.addEventListener("DOMContentLoaded", () => {
    loadDashboardCounts();
});

function loadDashboardCounts() {

    fetch("../php/get_upcoming_meeting.php")
        .then(response => response.json())
        .then(data => {

            if (data.success) {

                document.getElementById("applicantCount").innerText =
                    data.applicants;

                document.getElementById("clientCount").innerText =
                    data.clients;

                document.getElementById("meetingCount").innerText =
                    data.meetings;

            } else {
                console.error("Failed to load dashboard counts");
            }

        })
        .catch(error => {
            console.error("Fetch Error:", error);
        });
}


//download function of applicants info

const supabaseUrl = "https://ncsobcjlvytbivoxezfd.supabase.co";
const anonKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MTU2ODc3NiwiZXhwIjoyMDg3MTQ0Nzc2fQ.TLktUWOmr-iAZTy4Vm0F_ihUa2q_tQuP83RLTodPcEY";

async function exportApplicantsExcel() {

    const start = document.getElementById("startDate").value;
    const end = document.getElementById("endDate").value;

    if (!start || !end) {
        alert("Please select start and end date");
        return;
    }

    const startDate = start + "T00:00:00";
    const endDate = end + "T23:59:59";

    const url =
        `${supabaseUrl}/rest/v1/applicant_information?select=*`
        + `&created_at=gte.${startDate}`
        + `&created_at=lte.${endDate}`;

    try {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                apikey: anonKey,
                Authorization: `Bearer ${anonKey}`
            }
        });

        const data = await response.json();

        // ============================
        // FORMAT DATA (WITH ROW NUMBER)
        // ============================
        const rows = data.map((item, index) => ({
            "No.": index + 1,
            "Full Name": `${item.AI_LastName}, ${item.AI_FirstName}`,
            "Email": item.AI_Email,
            "Address": item.AI_Address,
            "Birthdate": item.AI_Birthdate,
            "Current Job": item.AI_CurrentJob,
            "School Graduated": item.AI_SchoolGraduated,
            "Contact Number": item.AI_ContactNum
        }));

        // ============================
        // CREATE WORKSHEET
        // ============================
        const ws = XLSX.utils.json_to_sheet(rows);

        // ============================
        // AUTO COLUMN WIDTH
        // ============================
        const colWidths = Object.keys(rows[0] || {}).map(key => ({
            wch: Math.max(
                key.length,
                ...rows.map(row =>
                    row[key] ? row[key].toString().length : 10
                )
            )
        }));

        ws["!cols"] = colWidths;

        // ============================
        // FREEZE HEADER ROW
        // ============================
        ws["!freeze"] = { ySplit: 1 };

        // ============================
        // BOLD HEADER STYLE
        // ============================
        const range = XLSX.utils.decode_range(ws["!ref"]);

        for (let C = range.s.c; C <= range.e.c; C++) {

            const cell = XLSX.utils.encode_cell({ r: 0, c: C });

            if (ws[cell]) {
                ws[cell].s = {
                    font: { bold: true },
                    alignment: { horizontal: "center" }
                };
            }
        }

        // ============================
        // CREATE WORKBOOK
        // ============================
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Applicants");

        // ============================
        // DOWNLOAD FILE
        // ============================
        XLSX.writeFile(wb, "Applicants_Report.xlsx");

    } catch (error) {
        console.error(error);
        alert("Failed to export data");
    }
}
