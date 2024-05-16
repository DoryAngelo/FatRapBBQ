/* js for calendar and quantity buttons in customer home page and input validation for track order section */

/* for calendar section */
/* reference: https://www.youtube.com/watch?v=OcncrLyddAs */

// Access the calendarData variable
console.log(calendarData);

const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();

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
            // }
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

    var availableDates = document.querySelectorAll('.available');
    for (var x = 0, availableDatesLength = availableDates.length; x < availableDatesLength; x++) {
        //console.log(sampleDivs[x]);
        availableDates[x].addEventListener("click", function () {
             const selectedDateString = getMonthName(currentDate.getMonth()) + ' ' + this.innerHTML + ' ' + currentDate.getFullYear();
             console.log(selectedDateString);
            // selectedDate = selectedDateString;
            // selectedString = selectedDateString;
            // selectedDateElement.innerHTML = '<h3>' + selectedString + '</h3>';
            // updateNumbers();
            document.location.href = 'menu.php?DATE_SELECTED='+ selectedDateString;
        });
    }

    // var availableDates = document.querySelectorAll('.available');
    // for (var x = 0, availableDatesLength = availableDates.length; x < availableDatesLength; x++) {
    //     availableDates[x].addEventListener("click", function () {
    //         const selectedDateString = getMonthName(currentDate.getMonth()) + ' ' + this.innerHTML + ' ' + currentDate.getFullYear();
    //         console.log(selectedDateString);

    //         Swal.fire({
    //             title: 'Select Time',
    //             html: '<input type="time" id="time" min="10:00" max="17:00">',
    //             showCancelButton: true,
    //             confirmButtonText: 'Submit',
    //             cancelButtonText: 'Cancel',
    //             cancelButtonColor: '#d33',
    //             icon: 'info',
    //             iconColor: '#007bff',
    //             confirmButtonColor: '#28a745',
    //             preConfirm: () => {
    //                 var selectedTime = document.getElementById("time").value;
    //                 // Set selected date and time into a session
    //                 var xhr = new XMLHttpRequest();
    //                 xhr.open("POST", "menu.php", true);
    //                 xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    //                 xhr.onreadystatechange = function () {
    //                     if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
    //                         // Redirect to menu.php
    //                         window.location.href = "menu.php";
    //                     }
    //                 };
    //                 xhr.send("DATE_SELECTED=" + encodeURIComponent(selectedDateString) + "&TIME_SELECTED=" + encodeURIComponent(selectedTime));
    //             }
    //         });
    //     });
    // }

    var fbDates = document.querySelectorAll('.fullybooked');
    for (var x = 0, fbDatesLength = fbDates.length; x < fbDatesLength; x++) {
        //console.log(sampleDivs[x]);
        fbDates[x].addEventListener("click", function () {
            // const selectedDateString = getMonthName(currentDate.getMonth()) + ' ' + this.innerHTML + ' ' + currentDate.getFullYear();
            // selectedDate = selectedDateString;
            // selectedString = selectedDateString;
            // selectedDateElement.innerHTML = '<h3>' + selectedString + '</h3>';
            // updateNumbers();
            alert('Date is Fully Booked');
        });
    }
    var closedDates = document.querySelectorAll('.closed');
    for (var x = 0, closedDatesLength = closedDates.length; x < closedDatesLength; x++) {
        //console.log(sampleDivs[x]);
        closedDates[x].addEventListener("click", function () {
            // const selectedDateString = getMonthName(currentDate.getMonth()) + ' ' + this.innerHTML + ' ' + currentDate.getFullYear();
            // selectedDate = selectedDateString;
            // selectedString = selectedDateString;
            // selectedDateElement.innerHTML = '<h3>' + selectedString + '</h3>';
            // updateNumbers();
            alert('Date is Closed');
        });
    }
    //updateNumbers();
}

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

// //input validation for order tracking section
// const form = document.getElementById("form"),
//         number = document.getElementById("number");

// form.addEventListener('submit', e => {
//     e.preventDefault();

//     validateInputs();
// });

// const setError = (element, message) => {
//     const inputControl = element.parentElement; //element should have input-control as its parent, with div.error as its sibling
//     const errorDisplay = inputControl.querySelector('.error');

//     errorDisplay.innerText = message;
//     inputControl.classList.add('error');
//     inputControl.classList.remove('success')
// }

// const setSuccess = element => {
//     const inputControl = element.parentElement;
//     const errorDisplay = inputControl.querySelector('.error');

//     errorDisplay.innerText = '';
//     inputControl.classList.add('success');
//     inputControl.classList.remove('error');
// };

// const validateInputs = () => {
//     const numberValue = number.value.trim();

//     //Regular expressions for input validation
//     const numberRegex = /^09\d{9}$/; //numbers only

//     if (numberValue === '') {
//         setError(number, 'Please enter your number');
//     } else if (!numberRegex.test(numberValue)) {
//         setError(number, 'Invalid numberrrrrrr');
//     } else {
//         setSuccess(number);
//     }
// };




