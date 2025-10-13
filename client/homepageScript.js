$("#toggleMode").click(() => {
  $("body").toggleClass("dark-mode");
});

var theme;
// FIX THE SIGNUP AND LOGIN THEN MAKE SURE THAT IT SAVE IN DATABASE

// const userTheme = async () => {
//   try {
//     const response = await fetch("/backend/getUserInfo.php");
//     const data = await response.json();
//     theme = data.theme;
//   } catch (err) {
//     console.log("error: ", err.message);
//   }
// };
// setInterval(userTheme, 1000);
// userTheme();
