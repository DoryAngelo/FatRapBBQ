const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

// Access the calendarData variable
console.log(calendarData);

let currentDate = new Date();

let selectedDate = null;
let selectedStatus = null;

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const today = new Date();
    var maxDate = new Date();
    var numberOfDaysToAdd = 30;
    var resultDate = maxDate.setDate(maxDate.getDate() + numberOfDaysToAdd);

    const firstDay = new Date(currentYear, currentMonth, 0);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString('default', { month: 'long', year: 'numeric' });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';
    const displayedMonthYear = monthYearElement.innerText.split(' ');

    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive ${currentDate.getMonth() - 1} ${prevDate.getDate()}">${prevDate.getDate()}</div>`;
    }

    for (let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        if (date.getFullYear() === today.getFullYear() && date.getMonth() === today.getMonth() && date.getDate() === today.getDate()) {
            datesHTML += `<button id="${getMonthName(currentDate.getMonth())} ${i} ${currentDate.getFullYear()}" class="date active available">${i}</button>`;
        } else if (date <= today || date > resultDate || (date < today && today.getHours() > -1)) {
            datesHTML += `<div class="date inactive ${currentDate.getMonth()} ${i}">${i}</div>`;
        } else {
            datesHTML += `<button id="${getMonthName(currentDate.getMonth())} ${i} ${currentDate.getFullYear()}" class="date active available">${i}</button>`;
        }
    }

    if (lastDayIndex != 0) {
        for (let i = 1; i <= 7 - lastDayIndex; i++) {
            const nextDate = new Date(currentYear, currentMonth + 1, i);
            datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
        }
    }

    datesElement.innerHTML = datesHTML;

    const displayedMonth = getMonthIndex(displayedMonthYear[0]);
    const displayedYear = parseInt(displayedMonthYear[1]);

    if (currentDate.getFullYear() === displayedYear && currentDate.getMonth() === displayedMonth) {
        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
            prevBtn.classList.add("disabled");
        }
    } else {
        prevBtn.classList.remove("disabled");
    }

    if (currentDate.getMonth() == maxDate.getMonth()) {
        nextBtn.classList.add("disabled");
    }
    else {
        nextBtn.classList.remove("disabled");
    }

    var sampleDivs = document.querySelectorAll('.date:not(.inactive)');
    for (var x = 0, sampleDivsLength = sampleDivs.length; x < sampleDivsLength; x++) {
        //console.log(sampleDivs[x]);
        sampleDivs[x].addEventListener("click", function () {
            const selectedDateString = getMonthName(currentDate.getMonth()) + ' ' + this.innerHTML + ' ' + currentDate.getFullYear();
            selectedDate = selectedDateString;
            selectedString = selectedDateString;
            selectedDateElement.innerHTML = '<h3>' + selectedString + '</h3>';
            // updateNumbers();
        });
    }
    calendarData.forEach(function (databasedate) {
        var month = databasedate.CALENDAR_DATE.split(' ');
        console.log(month);
        var settingDate;
        if (month[0] == getMonthName(currentDate.getMonth())) {
            settingDate = document.getElementById(databasedate.CALENDAR_DATE);
            console.log(settingDate)
            // if (databasedate.DATE_STATUS == "available") {
            //     settingDate.classList.add("available");
            //     settingDate.classList.remove("fullybooked");
            //     settingDate.classList.remove("closed");
            // // }
            // else 
            if (databasedate.DATE_STATUS == "fullybooked") {
                settingDate.classList.remove("available");
                settingDate.classList.add("fullybooked");
                settingDate.classList.remove("closed");
            }
            else if (databasedate.DATE_STATUS == "closed") {
                settingDate.classList.remove("available");
                settingDate.classList.remove("fullybooked");
                settingDate.classList.add("closed");
            }
        }
    });
    //updateNumbers();
}

const selectedDateElement = document.getElementById('selectedDate');
const availBtn = document.getElementById('availBtn');
const fullBtn = document.getElementById('fullBtn');
const closedBtn = document.getElementById('closedBtn');
const saveBtn = document.getElementById('saveBtn');
const clearBtn = document.getElementById('clearBtn');

availBtn.addEventListener('click', () => {
    selectedStatus = "available";
});
fullBtn.addEventListener('click', () => {
    selectedStatus = "fullybooked";
});
closedBtn.addEventListener('click', () => {
    selectedStatus = "closed";
});

saveBtn.addEventListener('click', () => {
    if (selectedDate && selectedStatus) {
        updateDatabase(selectedDate, selectedStatus);
        checkCount();
        //updateNumbers();
        updateSelected();
    } else {
        console.error("Date or status is missing");
    }
});

clearBtn.addEventListener('click', () => {
    selectedStatus = "available";
    if (selectedDate && selectedStatus) {
        updateDatabase(selectedDate, selectedStatus);
        //updateNumbers();
        updateSelected();
        checkCount();
    } else {
        console.error("Date or status is missing");
    }
});

function updateDatabase(date, status) {
    const formData = new FormData();
    formData.append("date", date);
    formData.append("status", status);

    fetch("update-calendar.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (response.ok) {
                console.log("Data saved successfully");
                checkCount();
            } else {
                console.error("Error saving data:", response.statusText);
            }
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}


function updateSelected() {
    if (selectedDate !== null && selectedStatus !== null) {
        const updateDate = document.getElementById(selectedString);
        if (updateDate.classList.contains("available") && selectedStatus !== "") {
            updateDate.classList.remove("available");
        }
        if (updateDate.classList.contains("fullybooked") && selectedStatus !== "") {
            updateDate.classList.remove("fullybooked");
        }
        if (updateDate.classList.contains("closed") && selectedStatus !== "") {
            updateDate.classList.remove("closed");
        }
        updateDate.classList.add(selectedStatus);
        selectedStatus = "";
    }
}

// const availCounter = document.getElementById('numAvail');
// const fbCounter = document.getElementById('numFB');
// const closedCounter = document.getElementById('numClosed');

// function updateNumbers() {
//     var availDates = document.querySelectorAll('.available');
//     var fbDates = document.querySelectorAll('.fullybooked');
//     var closedDates = document.querySelectorAll('.closed');

//     availCounter.innerHTML = '<h1>' + availDates.length + '</h1>';
//     fbCounter.innerHTML = '<h1>' + fbDates.length + '</h1>';
//     closedCounter.innerHTML = '<h1>' + closedDates.length + '</h1>';
// }

prevBtn.addEventListener('click', () => {
    if (!prevBtn.classList.contains("disabled")) {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    }
});

nextBtn.addEventListener('click', () => {
    if (!nextBtn.classList.contains("disabled")) {
        currentDate.setMonth(currentDate.getMonth() + 1);
        prevBtn.classList.remove("disabled");
        updateCalendar();
    }
});

function getMonthIndex(monthName) {
    const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    return months.indexOf(monthName);
}

function getMonthName(monthIndex) {
    const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    return months[monthIndex];
}


updateCalendar();