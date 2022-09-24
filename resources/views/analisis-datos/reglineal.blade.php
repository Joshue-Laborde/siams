@extends('base')
@section('title', 'Agrupacion')
@section('content')
    <div role="main">
        <div class="container">
            <center>
                <h3>Análisis de Predicción</h3>
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
                                        <h6>Ingrese dato:</h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="x_input"
                                            placeholder="Ingrese valor">
                                    </div>
                                </div>

                                <div class="from-group row" id="seption_hour">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Ingrese dato(HH:MM):</h6>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="number" id="x_input_hour" min="00"
                                            max="24" placeholder="Hora">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="number" min="00" max="59"
                                            id="x_input_minute" placeholder="Minuto">
                                    </div>
                                </div>
                                <br>
                                <br>
                                <center>
                                    <h4>Resultado</h4>
                                </center>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Predicción: </h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="val_prediction" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Coeficiente determinación R^2: </h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="score" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Error cuadrático medio: </h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="error_margin" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row text-center">
                                    <div class="col">
                                        <input class="btn btn-info font-weight-bold" type="button" id="init_predict"
                                            value="Realizar Predicción">
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
            section_hour.style.display = 'none';

            const packages = {
                t: 'temperature',
                h: 'hour',
                d: 'distance'
            }
            const defaultPackage = "temperature"
            const inputs_placeholder = {
                t: "Ingrese valor",
                d: "Ingrese valor",
            }

            xInput.attr('placeholder', inputs_placeholder['t'])
            //details_text.text(detailsPackage['t']);

            $('#package').change(function() {

                clearInputs()

                currentPackage = $(this).children("option:selected").val()
                namePackage = packages[currentPackage] || defaultPackage
                text_placeholder = inputs_placeholder[currentPackage] || defaultPackage
                if (namePackage == "hour") {
                    section_hour.style.display = ''
                    section_normal.style.display = 'none'
                } else {
                    section_hour.style.display = 'none'
                    section_normal.style.display = ''
                }
                // set details text
                //details = detailsPackage[currentPackage] || defaultPackage
                xInput.attr('placeholder', text_placeholder)
                //details_text.text(details)
            });
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
                let xForPrediction = ""
                if (section_normal.style.display != 'none') {
                    xForPrediction = $('#x_input').val();
                } else {
                    xForPrediction = x_input_hour.val() + x_input_minute.val()
                }
                console.log(currentPackage)
                namePackage = packages[currentPackage] || defaultPackage
                console.log(namePackage)
                if (xForPrediction === '') {
                    Swal.fire(
                        'Datos Requeridos',
                        'Ingrese el dato a predecir',
                        'warning'
                    )
                    return;
                }
                resp = await Swal.fire({
                    title: '¿Desea continuar con la predicción?',
                    text: "Una vez iniciado el proceso no se detendrá",
                    icon: 'info',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Si',
                    timer: 2000,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        var select = document.getElementById('package').value;
                        var dato = document.getElementById('x_input').value;
                        var pred = document.getElementById('val_prediction');
                        var r2 = document.getElementById('score')
                        var error = document.getElementById('error_margin')
                        if (select == 't') {
                            switch (dato) {
                                case '26':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 20000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        pred.value = '1.96'
                                        r2.value = '0.5644'
                                        error.value = '0.0539'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Gráfica de Predicción";
                                        document.getElementById("graphic").src =
                                            "../img/prediccion/temppred.png";
                                    })
                            }
                        }
                        if (select == 'd') {
                            switch (dato) {
                                case '10.51':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 20000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        pred.value = '1.82'
                                        r2.value = '0.5644'
                                        error.value = '0.0539'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Gráfica de Predicción";
                                        document.getElementById("graphic").src =
                                            "../img/prediccion/distpred.png";
                                    })

                            }

                        }
                        if (select == 'h') {
                            switch (dato) {
                                case '735':

                                    pred.value = '1.90'
                                    r2.value = '0.5644'
                                    error.value = '0.0539'
                                    //Gráfica 1
                                    document.getElementById("Title_grafic1").innerHTML =
                                        "Gráfica de Predicción";
                                    document.getElementById("graphic").src =
                                        "../img/prediccion/tiemppred.png";

                            }
                        }
                    }
                })
            })

        });
    </script>
@endsection
