/* javascript for controlling the progress bar and appearance of payment section and 
displaying a message after clicking the submit button in the payment section*/

// DOM Elements
const circles = document.querySelectorAll(".circle"),
  stepsContainer = document.getElementById("stepsContainer"),
  progressBar = document.querySelector(".indicator"),
  buttons = document.querySelectorAll("button"),
  pstatus = document.getElementById("status").innerHTML,
  sectionToShowHide = document.getElementById("payment-section"),
  receiptButton = document.getElementById("generate-receipt-btn"),
  submitButton = document.getElementById("submit"),
  promptMessage = document.querySelector(".prompt");

let currentStep = 1;

// function that updates the current step and updates the DOM
const updateSteps = (e) => {
  // update current step based on the text of p tag that serves as a status
  switch (pstatus) {
    case "Placed":
      currentStep = 1;
      break;
    case "Awaiting Payment":
      currentStep = 2;
      break;
    case "Paid":
      currentStep = 3;
      break;
    case "Preparing":
      currentStep = 3;
      break;
    case "Packed":
      currentStep = 4;
      break;
    case "Shipped":
      currentStep = 5;
      break;
    case "Completed":
      currentStep = 6;
      break;
    case "Cancelled":
      stepsContainer.style.display = "none";
      sectionToShowHide.style.display = "none";

      // Display a message indicating that the order has been cancelled
      const cancelMessage = document.createElement("p");
      cancelMessage.textContent = "Your order has been cancelled. For more information, kindly contact 09____ or 09____";
      cancelMessage.classList.add("cancel-message");

      // Replace the "Your order has been approved" text with the cancel message
      const orderStatusDesc = document.querySelector(".order-status-desc");
      orderStatusDesc.innerHTML = ''; // Clear existing content
      orderStatusDesc.appendChild(cancelMessage);
      break;
  }
  // // update current step based on the button clicked
  // currentStep = e.target.id === "next" ? ++currentStep : --currentStep;

  // loop through all circles and add/remove "active" class based on their index and current step
  circles.forEach((circle, index) => {
    circle.classList[`${index < currentStep ? "add" : "remove"}`]("active");
  });

  // update progress bar width based on current step
  progressBar.style.width = `${((currentStep - 1) / (circles.length - 1)) * 100}%`;

  // check if current step is last step or first step and disable corresponding buttons
  // if (currentStep === circles.length) {
  //   buttons[1].disabled = true;
  // } else if (currentStep === 1) {
  //   buttons[0].disabled = true;
  // } else {
  //   buttons.forEach((button) => (button.disabled = false));
  // }

  // Show/hide the payment section based on the current step
  if (currentStep >= 3) {
    receiptButton.style.display = "block"; // Show the section
  } else {
    receiptButton.style.display = "none"; // Hide the section
  }


  // Show/hide the payment section based on the current step
  if (currentStep === 2) {
    sectionToShowHide.style.display = "block"; // Show the section

    // Add a click event listener to the submit button
    submitButton.addEventListener("click", function (event) {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Display the prompt message
      promptMessage.style.display = "block";

      // Hide the prompt message after 2000 milliseconds (adjust as needed)
      setTimeout(() => {
        promptMessage.style.display = "none";
      }, 2000);
    });
  } else {
    sectionToShowHide.style.display = "none"; // Hide the section
  }

};

updateSteps();

// add click event listeners to all buttons
// buttons.forEach((button) => {
// button.addEventListener("click", updateSteps);
// });
