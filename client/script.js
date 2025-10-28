const btns = document.querySelectorAll(".btns");
btns.forEach((buttons) => {
  buttons.addEventListener("click", () => {
    btns.forEach((b) => b.classList.remove("active"));
    buttons.classList.add("active");
  });
});

var theme;
const messageContainer = document.querySelector("#messageContainer");
const loadMessage = async () => {
  try {
    const response = await fetch("/backend/getMessages.php");
    const data = await response.json();
    messageContainer.innerHTML = data
      .map((element) => {
        const { id, full_name, email, message, date } = element;
        return `<tr>
      <th scope="row">${id}</th>
      <td>${full_name}</td>
      <td>${email}</td>
      <td>${date}</td>
      <td>${message}</td>
    </tr>`;
      })
      .join("");
  } catch (err) {
    console.log("error: ", err.message);
  }
};

const reservationContainer = async () =>{
   try {
     const response = await fetch("/backend/getMessages.php");
     const data = await response.json();
     messageContainer.innerHTML = data
       .map((element) => {
         const { id, full_name, email, message, date } = element;
         return `<tr>
      <th scope="row">${id}</th>
      <td>${full_name}</td>
      <td>${email}</td>
      <td>${date}</td>
      <td>${message}</td>
    </tr>`;
       })
       .join("");
   } catch (err) {
     console.log("error: ", err.message);
   }
}
setInterval(loadMessage, 1000);
loadMessage();
setInterval(loadMessage, 1000);
loadMessage();
