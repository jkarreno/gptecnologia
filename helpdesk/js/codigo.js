$(document).ready(main);

var contador = 1;

function main(){
	$('.menu_bar').click(function(){
		if(contador==1){
			$('nav').animate({
				left: '0'
			});
			contador=0;
		} else {
			contador = 1;
			$('nav').animate({
				left: '-100%'
			});
		}
	});
	
	$('.submenu').click(function(){
		$(this).children('.children').slideToggle();
	});
}

function calculo(cantidad,precio,inputtext){
// Calculo del subtotal
subtotal = precio*cantidad;
inputtext.value=subtotal;
}
//descuentos
function descuentos(cantidad,precio,descuento1,descuento2,inputtext){
	importe=cantidad*precio;
	subtotal1=importe - (importe*(descuento1/100));
	subtotal2=subtotal1 - (subtotal1*(descuento2/100));
	inputtext.value=subtotal2;
}
//reloj
function mueveReloj(){ 
   	momentoActual = new Date() 
   	hora = momentoActual.getHours() 
   	minuto = momentoActual.getMinutes() 
   	segundo = momentoActual.getSeconds() 

   	str_segundo = new String (segundo) 
   	if (str_segundo.length == 1) 
      	 segundo = "0" + segundo 

   	str_minuto = new String (minuto) 
   	if (str_minuto.length == 1) 
      	 minuto = "0" + minuto 

   	str_hora = new String (hora) 
   	if (str_hora.length == 1) 
      	 hora = "0" + hora 

   	horaImprimible=hora+":"+minuto+":"+segundo 

   	document.ffactura.reloj.value = horaImprimible 

   	setTimeout("mueveReloj()",1000) 
} 

function mueveRelojNC(){ 
   	momentoActual = new Date() 
   	hora = momentoActual.getHours() 
   	minuto = momentoActual.getMinutes() 
   	segundo = momentoActual.getSeconds() 

   	str_segundo = new String (segundo) 
   	if (str_segundo.length == 1) 
      	 segundo = "0" + segundo 

   	str_minuto = new String (minuto) 
   	if (str_minuto.length == 1) 
      	 minuto = "0" + minuto 

   	str_hora = new String (hora) 
   	if (str_hora.length == 1) 
      	 hora = "0" + hora 

   	horaImprimible=hora+":"+minuto+":"+segundo 

   	document.fnotacredito.reloj.value = horaImprimible 

   	setTimeout("mueveRelojNC()",1000) 
} 

