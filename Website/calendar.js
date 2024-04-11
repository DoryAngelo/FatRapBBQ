/* reference: https://www.youtube.com/watch?v=OcncrLyddAs */

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

    const firstDay = new Date(currentYear, currentMonth,0);
    const lastDay = new Date(currentYear, currentMonth +1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString
    ('default', {month: 'long', year: 'numeric'});
    monthYearElement.textContent = monthYearString;
  
    let datesHTML = '';
    const displayedMonthYear = monthYearElement.innerText.split(' ');

    for(let i = firstDayIndex; i > 0; i--) {
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);
        datesHTML += `<div class="date inactive ${currentDate.getMonth() - 1} ${prevDate.getDate()}">${prevDate.getDate()}</div>`;
    }


    for(let i = 1; i <= totalDays; i++) {
        const date = new Date(currentYear, currentMonth, i);      
        //console.log(new Date(date));
        if (date <= today || date > resultDate || (date<today&&today.getHour()>-1)){ //disables previous dates and disables dates that are beyond a month
            datesHTML += `<div class="date inactive ${currentDate.getMonth()} ${i}">${i}</div>`;
        }
        else{
            datesHTML += `<button id="${getMonthName(currentDate.getMonth())} ${i} ${currentDate.getFullYear()}" class="date active ">${i}</button>`;
        }
        //const activeClass = date.toDateString === new Date().toDateString() ? 'active' : '';
        
    }

    if(lastDayIndex != 0) {
        for(let i = 1; i <= 7 - lastDayIndex; i++) {
            const nextDate = new Date(currentYear, currentMonth + 1, i);
            datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
        }
    }

    datesElement.innerHTML = datesHTML;

    
    const displayedMonth = getMonthIndex(displayedMonthYear[0]); // Convert month name to index
    const displayedYear = parseInt(displayedMonthYear[1]);
    
    //Check if the displayed month and year match the current date's month and year
    if (currentDate.getFullYear() === displayedYear && currentDate.getMonth() === displayedMonth) {
        // Check if the current date is within the displayed month
        
        if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
            prevBtn.classList.add("disabled");
        }
    } else {
        prevBtn.classList.remove("disabled"); // Ensure the previous button is enabled
    }

    //put active dates into array
    var sampleDivs = document.querySelectorAll( '.date:not(.inactive)' );

    //Iterate over the sampleDivs node array
    for(var x=0, sampleDivsLength = sampleDivs.length; x<sampleDivsLength;x++){
    //Add an event listener for each DOM element

    sampleDivs[x].addEventListener("click",function(){
        selectedString = getMonthName(currentDate.getMonth()) +' '+ this.innerHTML +' '+currentDate.getFullYear();
        selectedDate.innerHTML = '<h3>' + selectedString +'</h3>';
    })

    //disable next button when reaches the max date
    if (currentDate.getMonth() == maxDate.getMonth())
        {
        nextBtn.classList.add("disabled");
        }
    else   
        {
        nextBtn.classList.remove("disabled");
        }
    }
    updateNumbers();
}

var selectedString;
const selectedDate = document.getElementById('selectedDate');
const availBtn = document.getElementById('availBtn');
const fullBtn = document.getElementById('fullBtn');
const closedBtn = document.getElementById('closedBtn');
const saveBtn = document.getElementById('saveBtn');

var storeStatus = "";

availBtn.addEventListener('click', () => {
    storeStatus = "available"; 
});
fullBtn.addEventListener('click', () => {
    storeStatus = "fullybooked";  
});
closedBtn.addEventListener('click', () => {
    storeStatus = "closed";
});

saveBtn.addEventListener('click', () => {
    updateSelected();
    updateNumbers();
});

function updateSelected(){
    const updateDate = document.getElementById(selectedString);
    if(updateDate.classList.contains("available") && storeStatus !=""){
        updateDate.classList.remove("available");
    }
    if(updateDate.classList.contains("fullybooked")&& storeStatus !=""){
        updateDate.classList.remove("fullybooked");
    }
    if(updateDate.classList.contains("closed")&& storeStatus !=""){
        updateDate.classList.remove("closed");
    }
    updateDate.classList.add(storeStatus);
    storeStatus = "";
}

const availCounter = document.getElementById('numAvail');
const fbCounter = document.getElementById('numFB');
const closedCounter = document.getElementById('numClosed');

function updateNumbers(){
    var availDates = document.querySelectorAll( '.available' );
    var fbDates = document.querySelectorAll( '.fullybooked' );
    var closedDates = document.querySelectorAll( '.closed' );

    availCounter.innerHTML = '<h1>'+availDates.length+'</h1>';
    fbCounter.innerHTML = '<h1>'+fbDates.length+'</h1>';
    closedCounter.innerHTML = '<h1>'+closedDates.length+'</h1>';
}


// prevBtn.addEventListener('click', () => {
//     const displayedMonthYear = monthYearElement.innerText.split(' ');
//     const displayedMonth = getMonthIndex(displayedMonthYear[0]); // Convert month name to index
//     const displayedYear = parseInt(displayedMonthYear[1]);
//     // if(
//     //     currentDate.getMonth() === displayedMonth &&
//     //     currentDate.getFullYear() === displayedYear
//     // ) {
//     //     prevBtn.classList.add("disabled");
//     // } else {
//     //     currentDate.setMonth(currentDate.getMonth() - 1);
//     //     updateCalendar(); // Call the function to update the calendar
//     // }
    
//     // Check if the displayed month and year match the current date's month and year
//     if (currentDate.getFullYear() === displayedYear && currentDate.getMonth() === displayedMonth) {
//         // Check if the current date is within the displayed month
//         const today = new Date();
//         if (currentDate.getMonth() === today.getMonth() && currentDate.getFullYear() === today.getFullYear()) {
//             prevBtn.classList.add("disabled");
//         }
//     } else {
//         currentDate.setMonth(currentDate.getMonth() - 1);
//         updateCalendar(); // Call the function to update the calendar
//         prevBtn.classList.remove("disabled"); // Ensure the previous button is enabled
//     }
// });

prevBtn.addEventListener('click', () => {

    if(!prevBtn.classList.contains("disabled")){
        currentDate.setMonth(currentDate.getMonth() - 1);
        //nextBtn.classList.remove("disabled");
        updateCalendar();
    }
     // Call the function to update the calendar
});

nextBtn.addEventListener('click', () => {
   
    if(!nextBtn.classList.contains("disabled")){
        currentDate.setMonth(currentDate.getMonth() + 1);
        prevBtn.classList.remove("disabled");
        //nextBtn.classList.add("disabled");
        updateCalendar(); 
    }// Call the function to update the calendar
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

function getMonthName(monthIndex) {
    const months = [
        'January', 'February', 'March', 'April',
        'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];
    return months[monthIndex];
}

updateCalendar();