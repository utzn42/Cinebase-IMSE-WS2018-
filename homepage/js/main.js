function loginFailedErrorMessage(){
  window.alert("Wrong username or false password.");
}

function loginSuccess(username){
  window.alert("Welcome Back " + username + "!");
}

function registerSuccess(username){
  window.alert("You have been registered! Your username is: \'" + username + "\'.");
}

function setLoggedIn(username){
  document.getElementById("signIn").parentNode.removeChild(document.getElementById("signIn"));
  document.getElementById("register").parentNode.removeChild(document.getElementById("register"));

  var button = document.createElement("BUTTON");
  var t = document.createTextNode("Log Out");
  button.appendChild(t);
  document.getElementById("topLine").appendChild(button);
  button.classList.add("buttonLogOut");

  var userButton = document.createElement("BUTTON");
  t = document.createTextNode(username);
  userButton.appendChild(t);
  document.getElementById("topLine").appendChild(userButton);




  userButton.classList.add("buttonBig");
  userButton.style.backgroundColor="#d69524";
  userButton.onclick = function(){
    window.location="user.php";
  };

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

function hideFormInsertMovie(){
  var element =  document.getElementById('insertMovie');
  if (typeof(element) != 'undefined' && element != null)
  {
    document.getElementById("insertMovie").style.display="none";
  }
}

function hideFormInsertScreening(){
  var element =  document.getElementById('insertScreening');
  if (typeof(element) != 'undefined' && element != null)
  {
    document.getElementById("insertScreening").style.display="none";
  }
}

function setEmployeeMode(username){
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

  var element =  document.getElementById('insertMovie');
  if (typeof(element) != 'undefined' && element != null)
  {
    document.getElementById("insertMovie").style.display="block";
  }

  var element =  document.getElementById('insertScreening');
  if (typeof(element) != 'undefined' && element != null)
  {
    document.getElementById("insertScreening").style.display="block";
  }

  button.onclick = function(){
    window.location="logout.php";
  };
}

function reserveTicketSuccess(qty){
  window.alert(qty + " tickets have been set aside for you." + '\n' + "Discount eligibility will be checked during OTC purchase.");
}


function deleteAccount(customerID){
  if(window.confirm("Are you sure you want to delete your account?")){
    window.location="deleteAccount.php?id="+customerID;
  }


}
