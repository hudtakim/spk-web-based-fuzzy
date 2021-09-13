
  var input_arr = document.querySelectorAll(".inputan");

  for (let i = 0; i < input_arr.length; i++) {
					if(input_arr.value == ""){
            input_arr.style.display = "none";
          }
	}
  var arr_bates = document.querySelectorAll(".batesin");
  var penghitung = arr_bates.length;
  var penghitung2 = arr_bates.length;



  function delkrit(idx){

    var input1 = document.getElementById("krit1");
		var input2 = document.getElementById("krit2");
		var input3 = document.getElementById("krit3");
		var input4 = document.getElementById("krit4");
		var input5 = document.getElementById("krit5");
    var input6 = document.getElementById("krit6");
    var sel1 = document.getElementById("sel1");
		var sel2 = document.getElementById("sel2");
		var sel3 = document.getElementById("sel3");
		var sel4 = document.getElementById("sel4");
		var sel5 = document.getElementById("sel5");
    var sel6 = document.getElementById("sel6");
    var btn1 = document.getElementById("btn1");
    var btn2 = document.getElementById("btn2");
    var btn3 = document.getElementById("btn3");
    var btn4 = document.getElementById("btn4");
    var btn5 = document.getElementById("btn5");
    var btn6 = document.getElementById("btn6");

    if(penghitung == 1){
        
          //sel1.value = "";
          if(penghitung2 == 6){
            sel1.required = true;
            input1.style.display = "";

            sel2.required = true;
            input2.style.display = "";
          
            sel3.required = true;
            input3.style.display = "";
        
            sel4.required = true;
            input4.style.display = "";
          
            sel5.required = true;
            input5.style.display = "";
        
            sel6.value = "";
            sel6.required = true;
            input6.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
            btn2.classList.remove('btn-success');
            btn2.classList.add('btn-danger');
            btn2.innerHTML = "X";
            btn3.classList.remove('btn-success');
            btn3.classList.add('btn-danger');
            btn3.innerHTML = "X";
            btn4.classList.remove('btn-success');
            btn4.classList.add('btn-danger');
            btn4.innerHTML = "X";
            btn5.classList.remove('btn-success');
            btn5.classList.add('btn-danger');
            btn5.innerHTML = "X";
            btn6.classList.remove('btn-success');
            btn6.classList.add('btn-danger');
            btn6.innerHTML = "X";
          }else if(penghitung2 == 5){
            sel1.required = true;
            input1.style.display = "";

            sel2.required = true;
            input2.style.display = "";
          
            sel3.required = true;
            input3.style.display = "";
        
            sel4.required = true;
            input4.style.display = "";
          
            sel5.required = true;
            input5.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
            btn2.classList.remove('btn-success');
            btn2.classList.add('btn-danger');
            btn2.innerHTML = "X";
            btn3.classList.remove('btn-success');
            btn3.classList.add('btn-danger');
            btn3.innerHTML = "X";
            btn4.classList.remove('btn-success');
            btn4.classList.add('btn-danger');
            btn4.innerHTML = "X";
            btn5.classList.remove('btn-success');
            btn5.classList.add('btn-danger');
            btn5.innerHTML = "X";
          }else if(penghitung2 == 4){
            sel1.required = true;
            input1.style.display = "";

            sel2.required = true;
            input2.style.display = "";
          
            sel3.required = true;
            input3.style.display = "";
        
            sel4.required = true;
            input4.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
            btn2.classList.remove('btn-success');
            btn2.classList.add('btn-danger');
            btn2.innerHTML = "X";
            btn3.classList.remove('btn-success');
            btn3.classList.add('btn-danger');
            btn3.innerHTML = "X";
            btn4.classList.remove('btn-success');
            btn4.classList.add('btn-danger');
            btn4.innerHTML = "X";
          } else if(penghitung2 == 3){
            sel1.required = true;
            input1.style.display = "";

            sel2.required = true;
            input2.style.display = "";
          
            sel3.required = true;
            input3.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
            btn2.classList.remove('btn-success');
            btn2.classList.add('btn-danger');
            btn2.innerHTML = "X";
            btn3.classList.remove('btn-success');
            btn3.classList.add('btn-danger');
            btn3.innerHTML = "X";
          }else if(penghitung2 == 2){
            sel1.required = true;
            input1.style.display = "";

            sel2.required = true;
            input2.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
            btn2.classList.remove('btn-success');
            btn2.classList.add('btn-danger');
            btn2.innerHTML = "X";
          }else{
            sel1.required = true;
            input1.style.display = "";
          
            btn1.classList.remove('btn-success');
            btn1.classList.add('btn-danger');
            btn1.innerHTML = "X";
          }
      //window.location.replace('index.php');
      penghitung = penghitung2;
      return true;
    }
    penghitung = penghitung-1;

    if(idx == 1){
      sel1.value = "";
      sel1.required = false;
      input1.style.display = "none";
    }
    if(idx == 2){
      sel2.value = "";
      sel2.required = false;
      input2.style.display = "none";
    }
    if(idx == 3){
      sel3.value = "";
      sel3.required = false;
      input3.style.display = "none";
    }
    if(idx == 4){
      sel4.value = "";
      sel4.required = false;
      input4.style.display = "none";
    }
    if(idx == 5){
      sel5.value = "";
      sel5.required = false;
      input5.style.display = "none";
    }
    if(idx == 6){
      sel6.value = "";
      sel6.required = false;
      input6.style.display = "none";
    }
    if(penghitung == 1){
        if(penghitung2 == 1){
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
        }else if(penghitung2 == 2){
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
          btn2.classList.remove('btn-danger');
          btn2.classList.add('btn-success');
          btn2.innerHTML = "+";
        }else if(penghitung2 == 3){
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
          btn2.classList.remove('btn-danger');
          btn2.classList.add('btn-success');
          btn2.innerHTML = "+";
          btn3.classList.remove('btn-danger');
          btn3.classList.add('btn-success');
          btn3.innerHTML = "+";
        }else if(penghitung2 == 4){
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
          btn2.classList.remove('btn-danger');
          btn2.classList.add('btn-success');
          btn2.innerHTML = "+";
          btn3.classList.remove('btn-danger');
          btn3.classList.add('btn-success');
          btn3.innerHTML = "+";
          btn4.classList.remove('btn-danger');
          btn4.classList.add('btn-success');
          btn4.innerHTML = "+";
        }else if(penghitung2 == 5){
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
          btn2.classList.remove('btn-danger');
          btn2.classList.add('btn-success');
          btn2.innerHTML = "+";
          btn3.classList.remove('btn-danger');
          btn3.classList.add('btn-success');
          btn3.innerHTML = "+";
          btn4.classList.remove('btn-danger');
          btn4.classList.add('btn-success');
          btn4.innerHTML = "+";
          btn5.classList.remove('btn-danger');
          btn5.classList.add('btn-success');
          btn5.innerHTML = "+";
        }else{
          btn1.classList.remove('btn-danger');
          btn1.classList.add('btn-success');
          btn1.innerHTML = "+";
          btn2.classList.remove('btn-danger');
          btn2.classList.add('btn-success');
          btn2.innerHTML = "+";
          btn3.classList.remove('btn-danger');
          btn3.classList.add('btn-success');
          btn3.innerHTML = "+";
          btn4.classList.remove('btn-danger');
          btn4.classList.add('btn-success');
          btn4.innerHTML = "+";
          btn5.classList.remove('btn-danger');
          btn5.classList.add('btn-success');
          btn5.innerHTML = "+";
          btn6.classList.remove('btn-danger');
          btn6.classList.add('btn-success');
          btn6.innerHTML = "+";
        }
      }
    return true;
  }  
