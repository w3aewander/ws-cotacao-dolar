
/**
 * Consumindo a API
 * @author Wanderlei Silva do Carmo
 * @version 20230926.01
 * 
 */



document.addEventListener( 'DOMContentLoaded', (evt) => {

    var  moedaFrom = 'dolar';
    var  moedaTo = 'real';
    var taxaFrom = 1;
    var taxaTo = 1;

    const froms=document.getElementsByName('opt_from');
    const tos=document.getElementsByName('opt_to');
    const btnConverter = document.querySelector('#btn-converter');

    froms.forEach(el => {
        el.addEventListener('change', (e) =>{
            document.getElementById('convert-from').innerText =  (e.target.value.split('_')[1]).toUpperCase()

            moedaFrom = `${(e.target.value.split('_')[1])}`;
            //alert(moedaFrom);
        })

        
    });
       
    tos.forEach(el => {
        el.addEventListener('change', (e) =>{
            document.getElementById('convert-to').innerText = (e.target.value.split('_')[1]).toUpperCase();
        
            moedaTo = `${(e.target.value.split('_')[1])}`;

        })
    });
   
    btnConverter.addEventListener('click', () => {


        var fromMoney = document.getElementById('convert-from');
        var toMoney = document.getElementById('convert-to');

        var toValue = document.getElementById('to_value');
        var fromValue = document.getElementById('from_value');

        toValue.value = '';
        
        if ( moedaFrom == 'real' && moedaTo == 'dolar'){
            
            fetch('/dolar')
            .then(resp=>resp.text())
            .then(resp=> {

                toValue.value = (parseFloat(fromValue.value)  / parseFloat(resp)).toFixed(2);
            });

        } else if ( moedaFrom == 'dolar' && moedaTo == 'real') {
            fetch('/dolar')
            .then(resp=>resp.text())
            .then(resp=> {               
                toValue.value = (parseFloat(fromValue.value)  * parseFloat(resp)).toFixed(2);
            });
            
        } else if ( moedaFrom == 'euro' && moedaTo == 'real') {
            fetch('/euro')
            .then(resp=>resp.text())
            .then(resp=> {
                toValue.value = (parseFloat(fromValue.value)  * parseFloat(resp)).toFixed(2);
            });
            
        } else if ( moedaFrom == 'real' && moedaTo == 'euro'){
            fetch('/euro')
            .then(resp=>resp.text())
            .then(resp=> {
               
                toValue.value = (parseFloat(fromValue.value)  / parseFloat(resp)).toFixed(2);
            });

        } else if ( moedaFrom == 'real' && moedaTo == 'bitcoin'){
          fetch('/bitcoin')
            .then(resp=>resp.text())
            .then(resp=> {
                
                toValue.value = (parseFloat(fromValue.value)  / parseFloat(resp)).toFixed(2);
            });
        } else if ( moedaFrom == 'bitcoin' && moedaTo == 'real'){
            fetch('/bitcoin')
            .then(resp=>resp.text())
            .then(resp=> {
 
                toValue.value = (parseFloat(fromValue.value)  * parseFloat(resp)).toFixed(2);
            });
        } else if ( moedaFrom == moedaTo) {
            
            toValue.setAttribute('placeholder', 'as moedas são iguais.');
        } else {
            toValue.setAttribute('placeholder', 'não implementado ainda.');
        }
    });

});