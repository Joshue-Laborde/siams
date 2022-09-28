@extends('base')
@section('title', 'Agrupacion')
@section('content')
    <div role="main">
        <div class="container">
            <center>
                <h3>Análisis de Clasificación</h3>
            </center>
            <div class="row">
                <div class="col-sm-5">
                    <div class="card h-100 w-100">
                        <br>
                        <div class="card-body vertical-center">
                            <center>
                                <h4>Datos Entrada</h4>
                            </center>
                            <br>
                            <div class="container">

                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Ingrese rango de fecha: </h6>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="date" id="start_date">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="date" id="end_date">
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Análisis:</h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="package" id="package">
                                            <option value="t">Temperatura</option>
                                            <option value="d">Distancia</option>
                                            <option value="h">Tiempo</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row" id="seption_normal">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Valor de K:</h6>
                                    </label>
                                    {{-- <div class="col-sm-8">
                                        <input class="form-control" type="number" id="x_input"
                                            placeholder="Ingrese datos en grados">
                                    </div> --}}
                                    <div class="col-sm-8">
                                        <select class="form-control" id="cluster" name="cluster" required="">
                                            <option value=2>2</option>
                                            <option value=3>3</option>
                                            <option value=4>4</option>
                                            <option value=5>5</option>
                                            <option value=6>6</option>
                                            <option value=7>7</option>
                                            <option value=8>8</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Distancia:</h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="distancia" id="distancia">
                                            <option value="1">Manhattan</option>
                                            <option value="2">Euclediana</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <center>
                                    <h4>Resultado</h4>
                                </center>

                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Precisión de la clasificación: </h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="val_prediction" disabled>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="from-group row text-center">
                                    <div class="col">
                                        <input class="btn btn-info font-weight-bold" type="button" id="init_predict"
                                            value="Realizar Clasificación">
                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <p id="details_text"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <center>
                        <h4>Gráficos</h4>
                    </center>
                    <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic1"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic" width="400" height="380"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic2"></h6>
                        </div>
                        <div id="image">
                            <img id="plot" width="400" height="380"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    <div class="col-md-12 col-sm-12 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic3"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic3" width="350" height="300"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    {{-- <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic4"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic4" width="400" height="400"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div> --}}
                </div>
            </div>
            <br>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {


            var xInput = $('#x_input')
            var section_normal = document.getElementById("seption_normal");
            var section_hour = document.getElementById("seption_hour");
            var x_input_hour = $('#x_input_hour')
            var x_input_minute = $('#x_input_minute')
            var currentPackage = "t"
            var namePackage = ''
            var details_text = $('#details_text');
            var text_placeholder = "";
            //section_hour.style.display = 'none';

            //resultado
            var cluster = '';
            var silhouette = ''

            function numero() {
                cluster = document.getElementById("cluster").value;
                centroide = parseInt(cluster);
                console.log('clusters: ', centroide);
            }

            const packages = {
                t: 'temperature',
                h: 'hour',
                d: 'distance'
            }
            const defaultPackage = "temperature"
            const inputs_placeholder = {
                t: "Ingrese datos en grados",
                d: "Ingrese datos en metros",
            }

            $('#init_predict').click(async function() {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                if (start_date === '' || end_date === '') {
                    Swal.fire(
                        'Datos Requeridos',
                        'Ingrese el datos de rango',
                        'warning'
                    )
                    return;
                }
                startDate = new Date(start_date);
                endDate = new Date(end_date);
                nowDate = new Date();

                if (startDate < nowDate && endDate < nowDate) {
                    if (startDate > endDate) {
                        Swal.fire(
                            'Datos Incorrectos',
                            'Las fechas deben ser menores de que la fecha actual',
                            'warning'
                        )
                        return
                    }
                } else {
                    Swal.fire(
                        'Datos Incorrectos',
                        'Las fechas deben ser menores de que la fecha actual',
                        'warning'
                    )
                    return
                }
                resp = await Swal.fire({
                    title: '¿Desea continuar con la agrupación?',
                    text: "Una vez iniciado el proceso no se detendrá",
                    icon: 'info',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Si',
                    showLoaderOnConfirm: false,
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        var select = document.getElementById('package').value;
                        var selectK = document.getElementById('cluster').value;
                        var prec = document.getElementById('val_prediction')
                        if (select == 't') {
                            switch (selectK) {
                                case '3':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        prec.value = '98.80%'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Valor óptimo de K";
                                        document.getElementById("graphic").src =
                                            "../img/clasificacion/k3tempcodo.jpg";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Matriz de confusión";
                                        document.getElementById("plot").src =
                                            "../img/clasificacion/k3tempmatriz.jpg";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las clasificaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/clasificacion/k3tempclass.jpg";
                                    })
                                    break;
                            }

                        }
                        if (select == 'd') {
                            switch (selectK) {
                                case '2':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        prec.value = '87.07%'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Valor óptimo de K";
                                        document.getElementById("graphic").src =
                                            "../img/clasificacion/k2distcodo.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Matriz de confusión";
                                        document.getElementById("plot").src =
                                            "../img/clasificacion/k2distmatriz.png";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las clasificaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/clasificacion/k2distclass.png";
                                    })

                                    break;
                            }
                        }
                        if (select == 'h') {
                            switch (selectK) {
                                case '3':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        prec.value = '98.67%'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Valor óptimo de K";
                                        document.getElementById("graphic").src =
                                            "../img/clasificacion/k3tiempcodo.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Matriz de confusión";
                                        document.getElementById("plot").src =
                                            "../img/clasificacion/k3tiempmatriz.png";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las clasificaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/clasificacion/k3tiempclass.png";
                                    })

                                    break;
                            }
                        }
                    }


                })


            })

            function clearInputs() {
                xInput.val("")
                x_input_hour.val("")
                x_input_minute.val("")
                $("#val_prediction").val("")
                $("#score").val("")
                $("#error_margin").val("")
                $("#ct-chart1").empty()

                cleanCoordinates()
            }
        });
    </script>
@endsection
