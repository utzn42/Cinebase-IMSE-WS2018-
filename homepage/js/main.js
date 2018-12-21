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

  var a = document.createElement("A");
  t = document.createTextNode(username);
  a.appendChild(t);
  document.getElementById("topLine").appendChild(a);

  a.style.fontSize="10px";
  a.marginLeft="5px";

  button.onclick = function(){
    window.location="logout.php";
  };
}
