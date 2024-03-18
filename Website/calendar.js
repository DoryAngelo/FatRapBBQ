/* reference: https://www.youtube.com/watch?v=OcncrLyddAs */

const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth,0);
    const lastDay = new Date(currentYear, currentMonth +1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString
    ('default', {month: 'long', year: 'numeric'});
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    for(let i = firstDayIndex; i >0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    for(let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);
        const activeClass = date.toDateString === new Date().toDateString() ? 'active' : '';
        datesHTML += `<div class="date ${activeClass}">${i}</div>`;
    }

    if(lastDayIndex != 0) {
        for(let i = 1; i <= 7 - lastDayIndex; i++) {
            const nextDate = new Date(currentYear, currentMonth + 1, i);
            datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
        }
    }

    datesElement.innerHTML = datesHTML;
}

prevBtn.addEventListener('click', () => {
    const displayedMonthYear = monthYearElement.innerText.split(' ');
    const displayedMonth = getMonthIndex(displayedMonthYear[0]); // Convert month name to index
    const displayedYear = parseInt(displayedMonthYear[1]);
    // if(
    //     currentDate.getMonth() === displayedMonth &&
    //     currentDate.getFullYear() === displayedYear
    // ) {
    //     prevBtn.classList.add("disabled");
    // } else {
    //     currentDate.setMonth(currentDate.getMonth() - 1);
    //     updateCalendar(); // Call the function to update the calendar
    // }
    
    // Check if the displayed month and year match the current date's month and year
    if (currentDate.getFullYear() === displayedYear && currentDate.getMonth() === displayedMonth) {
        // Check if the current date is within the displayed month
        const today = new Date();
        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
            prevBtn.classList.add("disabled");
        }
    } else {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar(); // Call the function to update the calendar
        prevBtn.classList.remove("disabled"); // Ensure the previous button is enabled
    }
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar(); // Call the function to update the calendar
});

// Function to get the month index from its name
function getMonthIndex(monthName) {
    const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    return months.indexOf(monthName);
}

updateCalendar();