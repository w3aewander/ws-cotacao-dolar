<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Wanderlei Silva do Carmo">
    <meta name="email" content="wander.silva@gmail.com">
    <meta name="copyright" content="GPL 3.5">

    <title>Cotação de moeda</title>

    <style type="text/css">
        <?php
        ob_start();
        $css = file_get_contents(__DIR__ . '/../node_modules/components-bootstrap/css/bootstrap.min.css');
        ob_end_flush();

        echo $css;
        ?>
    </style>

    <script>
        ob_start();
        $js = file_get_contents(__DIR__. '/../node_modules/components-bootstrap/js/bootstrap.min.js');
        ob_end_flush();

        echo $js;
    </script>

    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>


</head>

<body>

    <div class="container">
        <div class="card">
          
            <div class="card-img">
                <img src="https://blogs.ifas.ufl.edu/wakullaco/files/2019/04/banner-coins.jpg" class="img-thumbnail">
            </div>
            
            <div class="card-header">
                <div class="card-title">
                    <h2>Conversor de moedas</h2>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <div class="p-2 mb-2 bg-primary text-white">De</div>
                        
                        <div>
                            <input type="radio" name="opt_from" value="from_real"> Real
                        </div>
                        <div>
                            <input type="radio" name="opt_from" value="from_dolar"> Dolar
                        </div>
                        <div>
                            <input type="radio" name="opt_from" value="from_euro"> Euro
                        </div>
                        <div>
                            <input type="radio" name="opt_from" value="from_bitcoin"> BTC - BitCoin
                        </div>

                    </div>


                    <div class="col">
                        <div class="p-2 mb-2 bg-primary text-white">Para</div>

                        <div>
                            <input type="radio" name="opt_to" value="to_real"> Real
                        </div>
                        <div>
                            <input type="radio" name="opt_to" value="to_dolar"> Dolar
                        </div>
                        <div>
                            <input type="radio" name="opt_to" value="to_euro"> Euro
                        </div>
                        <div>
                            <input type="radio" name="opt_to" value="to_bitcoin"> BTC - BitCoin
                        </div>
                    </div>

                </div>

                <div class="row my-2">
                    <div class="col-3 boder-1">
                        <div class="p-2"><strong>Converter de:</strong></div>
                        <div class="p-2" id='convert-from'></div>                      
                    </div>

                    <div class="col-3 boder-1">
                        <div class="p-2"><strong>Para:</strong></div>
                        <div class="p-2" id='convert-to'></div>                      
                    </div>
                        
                </div>

                <div class="row my-3">
                    <div class="form-group col">
                        <label for="from_value">Valor para converter:</label>
                        <input class="form-control" type="number" name="from_value" id="from_value">
                    </div>
                    <div class="form-group col">
                        <label for="to_value">Valor convertido:</label>
                        <input class="form-control" type="number" name="to_value" id="to_value">
                    </div>
                </div>

                <div class="card-footer">


                    <div class="btn-group">

                        <button class="btn btn-danger" id="btn-converter">Converter</button>

                    </div>

                    <small>Usando ao API do Banco Central</small>

                </div>

            </div>
               
            <div class="p-5 text-center">
                PHP Fácil - Acesse o canal no Youtube <a
                    href='https://youtube.com/w3ae'>@wanderleisilvadocarmo</a><br>
                Aplicação didática para o curso de lógica de programação<br>
                <?= date('Y') ?> - Wanderlei Silva do Carmo <wander.silva@gmail.com>
            </div>

        </div>

    </div>
</div>

</body>

</html>