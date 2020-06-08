document.addEventListener('readystatechange',loadEvent,false);


function loadEvent(){

	if(document.readyState=="interactive"){
		document.getElementById("butonNote").addEventListener("click",infoPanel,false);
	}
}


function confirmDelete(id){
	if(confirm("¿Estás seguro que deseas borrar la incidencia con ID\""+id+"\"?")){
		window.location.href = "adminPanel.php?confirmed="+id;
	}
}

  function infoPanel(){
    var panel = document.getElementById("panelNote");

    if (panel.style.display== "block") {
        panel.style.display = "none";
    }else{
      panel.style.display = "block";
    }
    document.getElementsByClassName("close")[0].onclick = function() {
      panel.style.display = "none";
    }
	
  }

