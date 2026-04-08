import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js/+esm'

const supabase = createClient(
  'https://ncsobcjlvytbivoxezfd.supabase.co',
  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im5jc29iY2psdnl0Yml2b3hlemZkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzE1Njg3NzYsImV4cCI6MjA4NzE0NDc3Nn0.LWELQVNAh5GzjU-YUSrO5O3b3Gj-lP7pUB3A_D-vNfA'
)

let currentDate = new Date()
let availableDates = new Set()
let selectedDates = new Set()
let previewDate = null
let editingSlotId = null
let currentAppointmentType = "client" // default

// ELEMENTS
const modal = document.getElementById("availabilityModal")
const closeBtn = document.querySelector(".close-btn")
const modalDateTitle = document.getElementById("modalDateTitle")
const startTime = document.getElementById("startTime")
const endTime = document.getElementById("endTime")
const saveBtn = document.getElementById("saveAvailability")
const savedTimes = document.getElementById("savedTimes")

const meetingLink = document.getElementById("meetingLink")

// SINGLE CALENDAR
const monthYear = document.getElementById("monthYear")
const calendarDates = document.getElementById("calendarDates")
const prevMonth = document.getElementById("prevMonth")
const nextMonth = document.getElementById("nextMonth")

function animateCalendarSwitch() {
  calendarDates.classList.remove("switching")
  void calendarDates.offsetWidth
  calendarDates.classList.add("switching")
  setTimeout(() => calendarDates.classList.remove("switching"), 280)
}

function getSortedSelectedDates() {
  return [...selectedDates].sort()
}

function toMinutes(timeValue) {
  const [hours, minutes] = timeValue.split(":").map(Number)
  return (hours * 60) + minutes
}

function toTimeString(totalMinutes) {
  const hours = Math.floor(totalMinutes / 60)
  const minutes = totalMinutes % 60
  return `${String(hours).padStart(2, "0")}:${String(minutes).padStart(2, "0")}`
}

function overlapsLunchBreak(startTimeValue, endTimeValue) {
  const lunchStart = 12 * 60
  const lunchEnd = 13 * 60
  const start = toMinutes(startTimeValue)
  const end = toMinutes(endTimeValue)
  return start < lunchEnd && end > lunchStart
}

function buildClientHourlySlots(startTimeValue, endTimeValue) {
  const start = toMinutes(startTimeValue)
  const end = toMinutes(endTimeValue)
  const slots = []

  for (let current = start; current + 60 <= end; current += 60) {
    const next = current + 60
    const slotStart = toTimeString(current)
    const slotEnd = toTimeString(next)

    if (overlapsLunchBreak(slotStart, slotEnd)) continue

    slots.push({ start_time: slotStart, end_time: slotEnd })
  }

  return slots
}

function updateModalDateTitle() {
  const selectedList = getSortedSelectedDates()
  if (!selectedList.length) {
    modalDateTitle.innerText = "Select date(s)"
    return
  }

  if (selectedList.length === 1) {
    modalDateTitle.innerText = `Availability for ${selectedList[0]}`
    return
  }

  modalDateTitle.innerText = `${selectedList.length} dates selected`
}

// NAV TABS
document.querySelectorAll("#calendarTabs .nav-link").forEach(link => {
  link.addEventListener("click", function () {
    document.querySelectorAll("#calendarTabs .nav-link").forEach(l => {
      l.classList.remove("active")
      l.setAttribute("aria-selected", "false")
    })
    this.classList.add("active")
    this.setAttribute("aria-selected", "true")
    
    currentAppointmentType = this.dataset.type
    selectedDates.clear()
    previewDate = null
    editingSlotId = null
    savedTimes.innerHTML = ""
    updateModalDateTitle()
    modal.style.display = "none"
    animateCalendarSwitch()
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
    if (selectedDates.has(dateString)) dateDiv.classList.add("selected")

    dateDiv.addEventListener("click", () => {
      if (selectedDates.has(dateString)) {
        selectedDates.delete(dateString)
        if (previewDate === dateString) previewDate = getSortedSelectedDates()[0] || null
      } else {
        selectedDates.add(dateString)
        previewDate = dateString
      }

      renderCalendar()
      updateModalDateTitle()

      if (!selectedDates.size) {
        savedTimes.innerHTML = ""
        modal.style.display = "none"
        return
      }

      if (previewDate) loadSavedTimes(previewDate)
      modal.style.display = "block"
    })

    calendarDates.appendChild(dateDiv)
  }
}

// LOAD SAVED TIMES
async function loadSavedTimes(date) {
  savedTimes.innerHTML = ""
  if (!date) return

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
      meetingLink.value = row.meeting_link || ""  // ⭐ THIS FIXES IT
      editingSlotId = row.id
    })

    div.querySelector(".delete-slot").addEventListener("click", async () => {
      if (!confirm("Delete this time slot?")) return
      const { error } = await supabase.from("available_dates").delete().eq("id", row.id)
      if (error) return alert("Delete failed")
      loadSavedTimes(previewDate)
      loadAvailability(currentAppointmentType)
    })

    savedTimes.appendChild(div)
  })
}

// SAVE TIME SLOT
saveBtn.addEventListener("click", async () => {
  const selectedList = getSortedSelectedDates()
  if (!selectedList.length) return alert("Select at least one date")
  if (!startTime.value || !endTime.value) return alert("Select start and end time")
  if (startTime.value >= endTime.value) return alert("End time must be after start time")

  if (editingSlotId && selectedList.length > 1) {
    return alert("Edit is only available when one date is selected")
  }

  const slotsToSave = (!editingSlotId && currentAppointmentType === "client")
    ? buildClientHourlySlots(startTime.value, endTime.value)
    : [{ start_time: startTime.value, end_time: endTime.value }]

  if (!slotsToSave.length) {
    return alert("No valid 1-hour slots found in selected range")
  }

  const overlapDates = []
  for (const date of selectedList) {
    const { data: existingSlots, error } = await supabase
      .from("available_dates")
      .select("*")
      .eq("date", date)
      .eq("appointment_type", currentAppointmentType)

    if (error) return alert("Failed to validate selected dates")

    const slotsToCheck = editingSlotId
      ? existingSlots.filter(slot => slot.id !== editingSlotId)
      : existingSlots

    const hasOverlap = slotsToSave.some(slot =>
      isOverlapping(slot.start_time, slot.end_time, slotsToCheck)
    )

    if (hasOverlap) {
      overlapDates.push(date)
    }
  }

  if (overlapDates.length) {
    return alert(`Time slot overlaps on: ${overlapDates.join(", ")}`)
  }

  let response
  if (editingSlotId) {
    response = await supabase
      .from("available_dates")
      .update({ start_time: startTime.value, end_time: endTime.value,  meeting_link: meetingLink.value })
      .eq("id", editingSlotId)
    editingSlotId = null
  } else {
    const rowsToInsert = selectedList.flatMap(date =>
      slotsToSave.map(slot => ({
        date,
        start_time: slot.start_time,
        end_time: slot.end_time,
        appointment_type: currentAppointmentType,
         meeting_link: meetingLink.value   // ✅ ADD THIS
      }))
    )

    response = await supabase.from("available_dates").insert(rowsToInsert)
  }

  if (response.error) return alert("Save failed")
  startTime.value = ""
  endTime.value = ""
  meetingLink.value = ""   // ✅ ADD THIS
  loadSavedTimes(previewDate)
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
updateModalDateTitle()
loadAvailability(currentAppointmentType)        