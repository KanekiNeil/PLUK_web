import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm'

const supabase = createClient(
  'https://ncsobcjlvytbivoxezfd.supabase.co',
  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA'
)

let currentDate = new Date()
let availableDates = new Set()
let selectedDate = null
let editingSlotId = null
let currentAppointmentType = "client" // default

// ELEMENTS
const modal = document.getElementById("availabilityModal")
const closeBtn = document.querySelector(".close-btn")
const startTime = document.getElementById("startTime")
const endTime = document.getElementById("endTime")
const saveBtn = document.getElementById("saveAvailability")
const savedTimes = document.getElementById("savedTimes")

// SINGLE CALENDAR
const monthYear = document.getElementById("monthYear")
const calendarDates = document.getElementById("calendarDates")
const prevMonth = document.getElementById("prevMonth")
const nextMonth = document.getElementById("nextMonth")

// NAV TABS
document.querySelectorAll(".nav-link").forEach(link => {
  link.addEventListener("click", function () {
    document.querySelectorAll(".nav-link").forEach(l => l.classList.remove("active"))
    this.classList.add("active")
    
    currentAppointmentType = this.dataset.type
    loadAvailability(currentAppointmentType)
  })
})

// PROFILE DROPDOWN
const profile = document.getElementById("profileToggle")
if (profile) {
  profile.addEventListener("click", () => profile.classList.toggle("active"))
  document.addEventListener("click", e => {
    if (!profile.contains(e.target)) profile.classList.remove("active")
  })
}

// RENDER CALENDAR
function renderCalendar() {
  const year = currentDate.getFullYear()
  const month = currentDate.getMonth()
  const firstDay = new Date(year, month, 1).getDay()
  const lastDate = new Date(year, month + 1, 0).getDate()

  monthYear.innerText = `${currentDate.toLocaleString("default",{month:"long"})} ${year}`
  calendarDates.innerHTML = ""

  // Empty divs for alignment
  for (let i = 0; i < firstDay; i++) calendarDates.appendChild(document.createElement("div"))

  for (let day = 1; day <= lastDate; day++) {
    const dateDiv = document.createElement("div")
    dateDiv.classList.add("date")
    dateDiv.innerText = day

    const dateString = `${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`
    if (availableDates.has(dateString)) dateDiv.classList.add("available")

    dateDiv.addEventListener("click", () => {
      selectedDate = dateString
      loadSavedTimes(dateString)
      modal.style.display = "block"
    })

    calendarDates.appendChild(dateDiv)
  }
}

// LOAD SAVED TIMES
async function loadSavedTimes(date) {
  savedTimes.innerHTML = ""
  const { data, error } = await supabase
    .from("available_dates")
    .select("*")
    .eq("date", date)
    .eq("appointment_type", currentAppointmentType)
    .order("start_time")

  if (error) return console.error(error)

  data.forEach(row => {
    const div = document.createElement("div")
    div.classList.add("saved-time-item")
    const start = row.start_time.substring(0,5)
    const end = row.end_time.substring(0,5)
    div.innerHTML = `
      <span>${start} - ${end}</span>
      <button class="edit-slot">Edit</button>
      <button class="delete-slot">Delete</button>
    `

    div.querySelector(".edit-slot").addEventListener("click", () => {
      startTime.value = start
      endTime.value = end
      editingSlotId = row.id
    })

    div.querySelector(".delete-slot").addEventListener("click", async () => {
      if (!confirm("Delete this time slot?")) return
      const { error } = await supabase.from("available_dates").delete().eq("id", row.id)
      if (error) return alert("Delete failed")
      loadSavedTimes(selectedDate)
      loadAvailability(currentAppointmentType)
    })

    savedTimes.appendChild(div)
  })
}

// SAVE TIME SLOT
saveBtn.addEventListener("click", async () => {
  if (!startTime.value || !endTime.value) return alert("Select start and end time")
  if (startTime.value >= endTime.value) return alert("End time must be after start time")

  const { data: existingSlots } = await supabase.from("available_dates").select("*").eq("date", selectedDate).eq("appointment_type", currentAppointmentType)
  if (isOverlapping(startTime.value,endTime.value,existingSlots)) return alert("Time slot overlaps with existing slot")

  let response
  if (editingSlotId) {
    response = await supabase.from("available_dates").update({start_time:startTime.value,end_time:endTime.value}).eq("id",editingSlotId)
    editingSlotId = null
  } else {
    response = await supabase.from("available_dates").insert([{
      date:selectedDate,
      start_time:startTime.value,
      end_time:endTime.value,
      appointment_type: currentAppointmentType
    }])
  }

  if (response.error) return alert("Save failed")
  startTime.value = ""
  endTime.value = ""
  loadSavedTimes(selectedDate)
  loadAvailability(currentAppointmentType)
})

// LOAD AVAILABILITY
async function loadAvailability(type) {
  const { data, error } = await supabase.from("available_dates").select("date").eq("appointment_type", type)
  if (error) return console.error(error)
  availableDates = new Set(data.map(row => row.date))
  renderCalendar()
}

// CHECK OVERLAP
function isOverlapping(start, end, existingSlots) {
  return existingSlots.some(slot => {
    const s = slot.start_time, e = slot.end_time
    return (start >= s && start < e) || (end > s && end <= e) || (start <= s && end >= e)
  })
}

// MONTH NAVIGATION
prevMonth.addEventListener("click", () => { currentDate.setMonth(currentDate.getMonth()-1); loadAvailability(currentAppointmentType) })
nextMonth.addEventListener("click", () => { currentDate.setMonth(currentDate.getMonth()+1); loadAvailability(currentAppointmentType) })

// MODAL CLOSE
closeBtn.addEventListener("click", () => modal.style.display = "none")
window.addEventListener("click", e => { if(e.target === modal) modal.style.display = "none" })

// INITIAL LOAD
loadAvailability(currentAppointmentType)        