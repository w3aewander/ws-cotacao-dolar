
/**
 * Consumindo a API
 * @author Wanderlei Silva do Carmo
 * @version 20230926.01
 * 
 */



document.addEventListener( 'DOMContentLoaded', (evt) => {

    const froms=document.getElementsByName('opt_from');
    const tos=document.getElementsByName('opt_to');

    let valorDolar = 0;

    froms.forEach(el => {
        el.addEventListener('change', (e) =>{
            document.getElementById('convert-from').innerText = e.target.value;

            ;

            fetch('/dolar')
            .then( resp => resp.text())
            .then( resp => valorDolar = resp);

        })

        
    });
       
    tos.forEach(el => {
        el.addEventListener('change', (e) =>{
            document.getElementById('convert-to').innerText = e.target.value;
        })
    });
   
});