function loginFailedErrorMessage(){
  window.alert("Wrong username or false password.");
}

function loginSuccess(username){
  window.alert("Welcome Back " + username + "!");
}

function setLoggedIn(username){
  document.getElementById("signIn").parentNode.removeChild(document.getElementById("signIn"));
  document.getElementById("register").parentNode.removeChild(document.getElementById("register"));

  var button = document.createElement("BUTTON");

  var t = document.createTextNode("Log Out");
  button.appendChild(t);
  document.getElementById("topLine").appendChild(button);
  button.classList.add("buttonLogOut");

  var a = document.createElement("A");
  t = document.createTextNode("   "+ username);
  a.appendChild(t);
  document.getElementById("topLine").appendChild(a);

  a.style.fontSize="17px";
  a.marginLeft="5px";

  button.onclick = function(){
    window.location="logout.php";
  };
}

function signUpFailedErrorMessagePasswords(){
  window.alert("Not the same passwords! Try Again!");
}

function signUpFailedErrorMessage(){
  window.alert("Couldn't register! Try Again!");
}

function setAdminMode(){
  document.getElementById("signIn").parentNode.removeChild(document.getElementById("signIn"));
  document.getElementById("register").parentNode.removeChild(document.getElementById("register"));

  var employees = document.createElement("BUTTON");
  var te = document.createTextNode("Administration");
  employees.appendChild(te);
  document.getElementById("topLine").appendChild(employees);
  employees.classList.add("buttonBig");

  var button = document.createElement("BUTTON");

  var t = document.createTextNode("Log Out");
  button.appendChild(t);
  document.getElementById("topLine").appendChild(button);
  button.classList.add("buttonLogOut");

  var a = document.createElement("A");
  t = document.createTextNode("   ADMIN");
  a.appendChild(t);
  document.getElementById("topLine").appendChild(a);

  a.style.fontSize="17px";
  a.marginLeft="5px";

  button.onclick = function(){
    window.location="logout.php";
  };
}