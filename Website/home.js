/* js for calendar and quantity buttons in customer home page and input validation for track order section */

/* for calendar section */
/* reference: https://www.youtube.com/watch?v=OcncrLyddAs */

const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth, 0);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString
        ('default', { month: 'long', year: 'numeric' });
    monthYearElement.textContent = monthYearString;

    let datesHTML = '';

    for (let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive">${prevDate.getDate()}</div>`;
    }

    for (let i = 1; i <= totalDays; i++) {
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
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar(); // Call the function to update the calendar
});

nextBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar(); // Call the function to update the calendar
});

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





