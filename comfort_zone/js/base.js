function openNav() {
  if(window.screen.width<768){
    document.getElementById("myNav").style.width = "100%";
  }else{
    document.getElementById("myNav").style.width = "60%";
  }
  
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}


function addTag(){

  if(document.getElementById("gsearch")["value"]=="" ){
    document.getElementById("add_tag_btn").setAttribute("disabled",true);

  }else{

    const form = document.getElementsByTagName("form")[0];
    const val=document.getElementById("gsearch");

    const button=`
    <input type="hidden" name="hidden-` + val["value"] + `" value="`+ val["value"] +`">
    <input type="button" name="button-` + val["value"] + `" value="`+ val["value"] +`" onclick='deleteTag("`+val["value"]+`")'>

    `;
    form.innerHTML += button;
    
    if(form.querySelectorAll("input[type='hidden']").length==5){
      document.getElementById("gsearch").setAttribute("disabled",true);
      document.getElementById("gsearch").setAttribute("value","");

      document.getElementById("add_tag_btn").setAttribute("disabled",true);
      document.getElementById("add_tag_btn").setAttribute("value", "aggiunti troppi tag");
    }      
  }
  document.getElementById("add_tag_btn").removeAttribute("disabled");
}

function deleteTag(name){
  const form = document.getElementsByTagName("form")[0];
  const tag=document.getElementsByName("hidden-" + name )[0];
  const bottone =document.getElementsByName("button-" + name )[0];
  form.removeChild(tag);
  form.removeChild(bottone);
  if(document.querySelectorAll("input[id='hsearch']").length<=4){
    document.getElementById("gsearch").removeAttribute("disabled");
    document.getElementById("add_tag_btn").setAttribute("value", "aggiungi tag");
  }
}



function myFunction()
{
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++)
{
  dropdown[i].classList.toggle("active");
  var dropdownContent =  dropdown[i].nextElementSibling;
  if (dropdownContent.style.display === "block")
  {
    dropdownContent.style.display = "none";
  } else
  {
    dropdownContent.style.display = "block";
  }
}
}


function check(action){
  const form = document.getElementsByTagName("form")[1];
  const arr = form.querySelectorAll("input");

    
    
    if(form.getElementsByTagName("textarea")[0].textLength ==0 ){
      arr[0].setCustomValidity("campo non valido");
    }
    if(!arr[0]["value"] || arr[i]["value"]== ""){
      arr[0].setCustomValidity("campo non valido");
    }
    
    if(!arr[1]["value"] || arr[1]["value"]== "" || isNaN(arr[2]["value"])|| arr[1]["value"]<0.01 ){
      arr[1].setCustomValidity("campo non valido");
    }

    if(!arr[2]["value"] || arr[2]["value"]== "" || isNaN(arr[2]["value"])|| arr[2]["value"]<1 || Number.isInteger(arr[2]["value"]) ){
      arr[2].setCustomValidity("campo non valido");
    }
    
    if(action==1 && !arr[3]["value"] ){
      arr[3].setCustomValidity("campo non valido");
    }

  const radio=document.querySelectorAll("input[type='radio']:checked");
  if(radio.length==0){
    document.querySelectorAll("input[type='radio']")[0].setCustomValidity("inserisci almeno un tag");
  }
  const a = document.querySelectorAll("input[type='checkbox']");
  if(document.querySelectorAll("input[type='checkbox']:checked").length==0){
    a[0].setCustomValidity("inserisci almeno un tag");
  }
}
