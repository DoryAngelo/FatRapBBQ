/* javascript for controlling the progress bar and appearance of payment section and 
displaying a message after clicking the submit button in the payment section*/

// DOM Elements
const circles = document.querySelectorAll(".circle"),
  stepsContainer = document.getElementById("stepsContainer"),
  progressBar = document.querySelector(".indicator"),
  buttons = document.querySelectorAll("button"),
  pstatus = document.getElementById("status").innerHTML,
  statusTitle = document.getElementById("order-status-title"),
  statusDesc = document.getElementById("order-status-desc"),
  availableDate = document.getElementById("available-date"),
  sectionToShowHide = document.getElementById("payment-section"),
  receiptButton = document.getElementById("generate-receipt-btn"),
  paymentRefForm = document.getElementById("payment-ref-form"),
  submitButton = document.getElementById("submit"),
  promptMessage = document.querySelector(".prompt");

let currentStep = 1;

// function that updates the current step and updates the DOM
const updateSteps = (e) => {
  // update current step based on the text of p tag that serves as a status
  switch (pstatus) {
    case "Placed":
      currentStep = 1;
      // statusTitle.textContent = "Your order has been placed";
      // console.log(dDate);
      // var today = new Date();
      // console.log(today);
      // if (dDate < today) {
      //   statusDesc.textContent = "Test";
      // } else {
      //   statusDesc.textContent = "Testttttt";
      // }
      statusDesc.textContent = "Please allot 5 to 10 minutes of waiting time for the confirmation of your order.\nOrders placed outside business hours will be checked when our operations resume.";
      break;
    case "Awaiting Payment":
      currentStep = 2;
      statusTitle.textContent = "Awaiting payment for your order";
      statusDesc.textContent = "Kindly settle your payment below and enter your GCash reference number for this transaction.";
      break;
    case "To Prepare":
      currentStep = 2;
      statusTitle.textContent = "Your order is confirmed.";
      statusDesc.textContent = "Order will be prepared before your specified pickup date and time.";
      break;
    case "Currently Preparing":
      currentStep = 2;
      statusTitle.textContent = "Your order is currently being prepared";
      statusDesc.textContent = "Regularly refresh this page to be notified when your order is ready to be picked up. \nEstimated waiting time for same-day orders is 30 minutes.";
      break;
    case "Packed":
      currentStep = 3;
      statusTitle.textContent = "Your order is ready to be picked up";
      statusDesc.textContent = "Please pick up your order at this address: \nSta. Ignaciana, Brgy. Kalusugan, Quezon City, Metro Manila, Philippines\n or book a third-party courier to pick up your order. (ex: Lalamove, Grab)";
      break;
    case "Completed":
      currentStep = 3;
      statusTitle.textContent = "Your order is delivered successfully";
      statusDesc.textContent = "Thank you for ordering at Fat Rap's Barbeque! You may now close this tab.";
      break;
    case "Cancelled":
      stepsContainer.style.display = "none";
      availableDate.style.display = "flex";
      statusTitle.textContent = "Your order has been cancelled.";
      statusDesc.textContent = "For more information, kindly contact 09178073760 or 09190873861.";
      // sectionToShowHide.style.display = "none";

      // // Display a message indicating that the order has been cancelled
      // const cancelMessage = document.createElement("p");
      // cancelMessage.textContent = "Your order has been cancelled. For more information, kindly contact 09178073760 or 09190873861.";
      // cancelMessage.classList.add("cancel-message");

      // // Replace the "Your order has been approved" text with the cancel message
      // const orderStatusDesc = document.querySelector(".order-status-desc");
      // orderStatusDesc.innerHTML = ''; // Clear existing content
      // orderStatusDesc.appendChild(cancelMessage);
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
  } else {
    sectionToShowHide.style.display = "none"; // Hide the section
  }

};

updateSteps();

// add click event listeners to all buttons
// buttons.forEach((button) => {
// button.addEventListener("click", updateSteps);
// });
