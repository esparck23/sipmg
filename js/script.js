
$(document).ready(function(){

    $('#modalVerEgresoDetencion').modal();

    // LLAMADO A LA FUNCION DE PERMISOS
    Permisos($('#r_usuario_id').val());

    // al iniciar la aplicación (para registro.php)
    //se oculta combo de la documentacion de ingreso de interno
    // junto con el boton que contiene el submit para el backend
    $('#registar_dinamico_btn').hide();
    $('#registrarDatosf_btn').show();
    $('.sidenav').sidenav();
    $('.collapsible').collapsible();
    $('select').formSelect();


    // VALIDACION DE TODOS LOS FORMULARIOS DE LA APLICACION
    $('#form_login').valida(); // formulario de Login (index.php)
    $('#form_consulta_cedula').valida(); // formulario de consulta de datos (consulta.php)
    $('#form_guardar_cambios_datos_detenido').valida(); // formulario de edicion de datos (consulta.php)
    $('#form_datosinternodetenido').valida(); // formulario de edicion de datos interno detenido (consulta.php)
    $('#form_documentar').valida(); // formulario documentar un nuevo ingreso de interno detenido (consulta.php)
    $('#form_registro_datosf').valida(); // formulario documentar un nuevo dato filiatorio (registro.php)
    $('#form_doc_interno_detenido').valida(); // formulario documentar interno detenido (registro.php)

    $('.tooltipped').tooltip();

    function obtenerDatosUrl() {
        var datos = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?')+1).split('&');
        for (var i = 0; i < hashes.length; i++){
            hash = hashes[i].split('=');
            datos.push(hash[0]);
            datos[hash[0]] = hash[1];
        }
        return hashes;
    }

    // validando que nos encontramos en la pagina registro.php
    var registro = "registro";
    if (location.pathname.search(registro) >= 0) {
        var url = obtenerDatosUrl()[0];
        var detenido = url.split('=');
    // validamos la URL si contiene ID del detenido, significa que proviene de consulta.php > registrar detencion
        if (detenido[0] == 'detenido_id') {
            //
            $('#registro_detencion_from_consulta_panel').show();
            $('#registro_datos_detenidos_panel').hide();
        }
        else {
            $('#registro_detencion_from_consulta_panel').hide();
            $('#registro_datos_detenidos_panel').show();
        }
        
    }

    // MENU DINAMICO PARA ASIGNAR LA PROPIEDAD "ACTIVA"
    var currentURL = window.location.href;
    var urlParts = currentURL.split('/'); // Dividir la URL en partes usando '/' como separador
    var lastPartOfURL = urlParts[urlParts.length - 1]; // Obtener la última parte del arreglo

    if (lastPartOfURL == "consulta.php") {
        var consulta = $('.collapsible').children('li').eq(0);
        consulta.addClass('active');
    }
    else if (lastPartOfURL == "registro_detenido.php" || lastPartOfURL == "registro_detenidos.php") {
         // MANTENER ACTIVA LA OPCION DEL REGISTRO MIENTRAS SE ESTÁ EN LA PAGINA
         var registro_detenido = $('.collapsible').children('li').eq(0);
         var red = $(registro_detenido).find("div:eq(0)");
         red.attr('style','display:block');
         registro_det = red.children().children('li').eq(1);
         registro_det.attr('class','active');
    } 
    else if (lastPartOfURL == "lista_detenciones.php") {
        var lista_detenciones = $('.collapsible').children('li').eq(1);
        lista_detenciones.addClass('active');
    }
    else if (lastPartOfURL == "registro_detencion.php" || lastPartOfURL == "registro_detenciones.php") {
        // MANTENER ACTIVA LA OPCION DEL REGISTRO MIENTRAS SE ESTÁ EN LA PAGINA
        var registro_detencion = $('.collapsible').children('li').eq(1);
        var reg = $(registro_detencion).find("div:eq(0)");
        reg.attr('style','display:block');
        regis_dete = reg.children().children('li').eq(1);
        regis_dete.attr('class','active');
   }
   else if (lastPartOfURL == "delitos.php") {
        var delitos = $('.collapsible').children('li').eq(2);
        delitos.addClass('active');
    }
    else if (lastPartOfURL == "registro_delito.php") {
        // MANTENER ACTIVA LA OPCION DEL REGISTRO MIENTRAS SE ESTÁ EN LA PAGINA
        var registro_delito = $('.collapsible').children('li').eq(2);
        var reede = $(registro_delito).find("div:eq(0)");
        reede.attr('style','display:block');
        re_deli = reede.children().children('li').eq(1);
        re_deli.attr('class','active');
   }
   else if (lastPartOfURL == "organismos.php") {
        var delitos = $('.collapsible').children('li').eq(3);
        delitos.addClass('active');
    }
    else if (lastPartOfURL == "registro_organismo.php") {
         var registro_organismo = $('.collapsible').children('li').eq(3);
         var reorg = $(registro_organismo).find("div:eq(0)");
         reorg.attr('style','display:block');
         re_o = reorg.children().children('li').eq(1);
         re_o.attr('class','active');
    }
    else if (lastPartOfURL == "lista_egresos.php") {
         var delitos = $('.collapsible').children('li').eq(4);
         delitos.addClass('active');
    }
    else if (lastPartOfURL == "registro_egreso.php") {
        var registro_egreso = $('.collapsible').children('li').eq(4);
        var re_eg = $(registro_egreso).find("div:eq(0)");
        re_eg.attr('style','display:block');
        re_egres = re_eg.children().children('li').eq(1);
        re_egres.attr('class','active');
    }



    // #####

    var MunicipiosPorEstado = {
        "Amazonas": ["Alto Orinoco","Atures","Autana","Manapiare","San Fernando de Atabapo","Casiquiare","Maroa","Río Negro"],
        "Anzoátegui": ["Anaco","Aragua","Manuel Ezequiel Bruzual","Diego Bautista Urbaneja","Fernando Peñalver","Francisco Del Carmen Carvajal","General Sir Arthur McGregor","Guanta","Independencia","José Gregorio Monagas","Juan Antonio Sotillo","Juan Manuel Cajigal","Libertad","Francisco de Miranda","Pedro María Freites","Píritu","San José de Guanipa","San Juan de Capistrano","Santa Ana","Simón Bolívar","Simón Rodríguez"],
        "Apure": ["Achaguas","Biruaca","Muñóz","Páez","Pedro Camejo","Rómulo Gallegos","San Fernando"],
        "Aragua": ["Bolívar","Camatagua","Francisco Linares Alcántara","Girardot","José Ángel Lamas","José Félix Ribas","Libertador","Mario Briceño Iragorry","Ocumare de la Costa de Oro","San Casimiro","San Sebastián","Santiago Mariño","Santos Michelena","Sucre","Tovar","Urdaneta","Zamora"],
        "Barinas": ["Alberto Arvelo Torrealba","Andrés Eloy Blanco","Antonio José de Sucre","Arismendi","Barinas","Bolívar","Cruz Paredes","Ezequiel Zamora","Obispos","Pedraza","Rojas","Sosa"],
        "Bolívar": ["Angostura del Orinoco","Caroní","Cedeño","El Callao","Gran Sabana","Heres",,"La Gran Sabana","Libertador","Piar","Roscio","Sifontes","Sucre","Upata","Padre Pedro Chien"],
        "Carabobo": ["Bejuma","Carlos Arvelo","Diego Ibarra","Guacara","Juan José Mora","Libertador","Los Guayos","Miranda","Montalbán","Naguanagua","Puerto Cabello","San Diego","San Joaquín","Valencia"],
        "Cojedes": ["Anzoátegui","Ezequiel Zamora","Girardot","Lima Blanco","Pao de San Juan de los Morros","Ricaurte","Romulo Gallegos","San Carlos","Tinaquillo","Tinaquillo","Tinaco"],
        "Delta Amacuro": ["Antonio Díaz","Casacoima","Pedernales"," Tucupita"],
        "Distrito Capital": ["Libertador"],
        "Falcón": ["Acosta","Bolívar","Buchivacoa","Cacique Manaure","Carirubana","Colina","Dabajuro","Democracia","Falcón","Federación","Jacura","José Laurencio Silva","Los Taques","Mauroa","Miranda","Monseñor Iturriza","Palmasola","Petit","Píritu","San Francisco de Macaira","San Martín","Silva","Sucre","Tocópero","Unión","Urumaco","Zamora"],
        "Guárico": ["Camaguán","Chaguaramas","El Socorro","José Félix Ribas","Juan Germán Roscio","José Tadeo Monagas","Juan José Rondón","Julián Mellado","Las Mercedes","Leonardo Infante","Pedro Zaraza","Ortiz","Palo Negro","San Gerónimo de Guayabal","San José de Guaribe","Santa María de Ipire","Sebastián Francisco de Miranda","Valle de la Pascua"],
        "Lara": ["Andrés Eloy Blanco","Crespo","Iribarren","Jiménez","Morán","Palavecino","Simón Planas","Torres","Urdaneta"],
        "Mérida": ["Alberto Adriani","Andrés Bello","Antonio Pinto Salinas","Aricagua","Arzobispo Chacón","Campo Elías","Caracciolo Parra Olmedo","Cardenal Quintero","Guaraque","Chama","Ejido","Espejo","Francisco de Miranda","Guaicaipuro","Jacinto Plaza","Julio César Salas","Libertador","Libertador","Miranda"," Obispo Ramos de Lora","Padre Noguera","Pueblo Llano","Rangel","Rivas Dávila","Santos Marquina","Sucre","Tovar","Tulio Febres Cordero","Zea"],
        "Miranda": ["Acevedo","Andrés Bello","Baruta","Brión","Buroz","Carrizal","Chacao","Cristóbal Rojas","El Hatillo","Guaicaipuro","Independencia","Lander","Los Salias","Páez","Paz Castillo","Pedro Gual","Plaza","Simón Bolívar","Sucre","Urdaneta","Zamora"],
        "Monagas": ["Acosta","Aguasay","Bolívar","Caripe","Cedeño","Ezequiel Zamora","Libertador","Maturín","Piar","Punceres","Santa Bárbara","Sotillo","Uracoa"],
        "Nueva Esparta": ["Antolín del Campo","Arismendi","Díaz","García","Gómez","Maneiro","Mariño","Península de Macanao","Tubores","Villalba","Díaz"],
        "Portuguesa": ["Agua Blanca","Araure","Esteller","Guanare","Guanarito","Monseñor José Vicente de Unda","Ospino","Páez","Papelón","San Genaro de Boconoíto","San Rafael de Onoto","Santa Rosalía","Sucre","Turén"],
        "Sucre": ["Andrés Eloy Blanco","Andrés Mata","Arismendi","Benítez","Bermúdez","Bolívar","Cajigal","Cruz Salmerón Acosta","Carúpano","Cumaná","Libertador","Mariño","Mejía","Montes","Ribero","Sucre","Valdéz"],
        "Táchira": ["Andrés Bello","Antonio Rómulo Costa","Ayacucho","Bolívar","Cárdenas","Córdoba","Fernández Feo","Francisco de Miranda","García de Hevia","Guásimos","Independencia","Jáuregui","José María Vargas","Junín","Libertad","Libertador","Lobatera","Michelena","Panamericano","Pedro María Ureña","Rafael Urdaneta","Samuel Darío Maldonado","San Cristóbal","San Judas Tadeo","Seboruco","Simón Rodríguez","Sucre","Torbes","Uribante"],
        "Trujillo": ["Andrés Bello","Boconó","Bolívar","Candelaria","Carache","Carvajal","Escuque","Francisco de Miranda","José Felipe Márquez Cañizales","Juan Vicente Campos Elías","La Ceiba","La Paz","Libertad","Monte Carmelo","Motatán","Pampán","Pampanito","Rafael Rangel","San Rafael de Carvajal","Santa Ana","Trujillo","Urdaneta","Valera"],
        "La Guaira": ["Caraballeda","La Guaira","Macuto","Vargas"],
        "Yaracuy": ["Arístides Bastidas","Bolívar","Bruzual","Cocorote","Independencia","José Antonio Páez","José Joaquín Veroes","La Trinidad","Manuel Monge","Nirgua","Peña","San Felipe","Urachiche","Yaritagua"],
        "Zulia": ["Almirante Padilla","Baralt","Cabimas","Catatumbo","Colón","Francisco Javier Pulgar","Guajira","Jesús Enrique Lossada","Jesús María Semprún","La Cañada de Urdaneta","Lagunillas","Machiques de Perijá","Mara","Maracaibo","Miranda","Páez","Rosario de Perijá","San Francisco","Santa Rita","Simón Bolívar","Sucre","Valmore Rodríguez","Zulia"],
        "Dependencias Federales": ["Dependencias Federales"]
        };

    if (lastPartOfURL == "registro_detenido.php" || "registro_detencion.php") {
         TraerEstadosVenezuela();
    }

    function TraerEstadosVenezuela() {
        $.ajax({
            url: "estados_ven.php",
            method: "POST",
            success: function(data){
                var estados = JSON.parse(data); // Se parsea la respuesta JSON
                
                // Se recorren los estados y se agregan al combo box
                for (var i = 0; i < estados.length; i++) {
                    var estadosVen = [estados[i].nombre];
                
                    var $selectEstado = $('#estado');
                    var $selectMunicipio = $('#municipio');
                    
                    estadosVen.forEach(function(estado) {
                        var option = $('<option>', {
                            value: estado,
                            text: estado
                        });
                        $selectEstado.append(option);
                        $selectEstado.formSelect();
                    });
                }
            

                // Desencadena el evento change para cargar los municipios
                $selectEstado.trigger('change');

                $selectEstado.on('change', function() {
                    var estadoSeleccionado = $(this).val();
                    var municipios_estado = MunicipiosPorEstado[estadoSeleccionado] || [];

                    // Limpia el select de municipios y agrega las opciones
                    $selectMunicipio.empty();
                    $selectMunicipio.append('<option value="" disabled selected>Seleccione un Municipio</option>');

                    $.each(municipios_estado, function(index, municipio) {
                        $selectMunicipio.append('<option value="' + municipio + '">' + municipio + '</option>');
                    });

                    // Activa o desactiva el select de municipioes según la elección del estado
                    if (municipios_estado.length > 0) {
                        $selectMunicipio.prop('disabled', false);
                    } else {
                        $selectMunicipio.prop('disabled', true);
                    }

                    //Actualiza el diseño del select con Materialize CSS
                        $selectMunicipio.formSelect();
                }); 
            }
        });
    }



    // ######################################### PAGINA CONSULTA.PHP - BUSQUEDA DE DETENIDO ####################

    // Manejar la búsqueda en tiempo real para detenidos DETENIDO
    $('#buscarActivoBtn').on('click', function () {
        var query = $('#query').val();

        if (query > 0 || query !== "") {
            realizarBusquedaCedulaDetenidos(query);
        } else{
            M.toast({html: 'Debe indicar un valor de búsqueda.'});
        }
    });

    function realizarBusquedaCedulaDetenidos(query) {
        // Realizar una solicitud AJAX para buscar en la base de datos
        $.ajax({
            url: 'consulta_detenido.php', // Crea este archivo para manejar la búsqueda en la base de datos
            method: 'POST',
            data: { query: query },
            success: function (data) {
                $('#tabla_busqueda_detenidos').html(data); //llena post consulta detenidos_listado.php
                $('#refrescar_consulta').attr('style','display:inline;padding-left:5%');
                $('#paginador_detenidos_listado').empty(); //limpia el paginador que se genera en detenidos_listado.php
            }
        });
    }

    //Ejecuta boton refrescar DETENIDOS
    $("#refrescar_consulta").click(function() {
        refreshConsulta();
    });

    function refreshConsulta() {
        var url = '../php/consulta.php';
        location.assign(url, 'consulta');
    }

    
    // ######################################### PAGINA LISTA_EGRESOS.PHP - BUSQUEDA DE EGRESADO ####################

    
    // Manejar la búsqueda en tiempo real para EGRESADOS
    $('#buscarEgresadoBtn').on('click', function () {
        var query = $('#query').val();

        if (query > 0 || query !== "") {
            realizarBusquedaCedulaEgresados(query);
        } else{
            M.toast({html: 'Debe indicar un valor de búsqueda.'});
        }
    });

    function realizarBusquedaCedulaEgresados(query) {
        // Realizar una solicitud AJAX para buscar en la base de datos
        $.ajax({
            url: 'consulta_detenido_egreso.php', // Crea este archivo para manejar la búsqueda
            method: 'POST',
            data: { query: query },
            success: function (data) { //llena post consulta egresos_listado.php
                $('#tabla_busqueda_egresado').html(data);
                $('#refrescar_consulta_egresados').attr('style','display:inline;padding-left:5%');
                $('#paginador_detenidos_egresados_listado').empty(); //limpia el paginador que se genera en egresos_listado.php
            }
        });
    }

    //Ejecuta boton refrescar EGRESADOS
    $("#refrescar_consulta_egresados").click(function() {
        refreshConsultaEgreso();
    });

    function refreshConsultaEgreso() {
        var url = '../php/lista_egresos.php';
        location.assign(url, 'lista_egresos');
    }

    // ############################# GENERAL PARA LOS CUADROS DE BUSQUEDA (DETENIDOS/EGRESADOS)




    // ######################################### PAGINA LISTA_DETENCIONES.PHP - BUSQUEDA DE DETENCIONES ####################

    // Manejar la búsqueda en tiempo real para detenidos DETENIDO
    $('#buscarDetencionBtn').on('click', function () {
        var query = $('#query').val();

        if (query > 0 || query !== "") {
            realizarBusquedaDetencion(query);
        } else{
            M.toast({html: 'Debe indicar un valor de búsqueda.'});
        }
    });

    function realizarBusquedaDetencion(query) {
        // Realizar una solicitud AJAX para buscar en la base de datos
        $.ajax({
            url: 'consulta_lista_detencion.php', // SE TUVO QUE HACER UN ARCHIVO NUEVO PARA QUE NO CHOCARA CON EL CREADO
            method: 'POST',
            data: { query: query },
            success: function (data) {
                $('#tabla_busqueda_detenciones').html(data); //llena post consulta detenciones_listado.php
                $('#refrescar_consulta_detencion').attr('style','display:inline;padding-left:5%');
                $('#paginador_detenciones_listado').empty(); //limpia el paginador que se genera en detenciones_listado.php
            }
        });
    }

    //Ejecuta boton refrescar DETENIDOS
    $("#refrescar_consulta_detencion").click(function() {
        var url = '../php/lista_detenciones.php';
        location.assign(url, 'lista_detenciones');
    });

    
    // #################




    // ################################################## CODIGOS

    var codigosDelito = [
        "D001","D002","D003","D004","D005","D006","D007","D008","D009","D010","D011","D012","D013","D014","D015","D016","D017","D018","D019","D020","D021","D022",
        "D023","D024","D025","D026","D027","D028","D029","D030","D031","D032","D033","D034","D035","D036","D037","D038","D039","D040","D041","D042","D043","D044",
        "D045","D046","D047","D048","D049","D050","D051","D052","D053","D054","D055","D056","D057","D058","D059","D060","D061","D062","D063","D064","D065","D066",
        "D067","D068","D069","D070","D071","D072","D073","D074","D075","D076","D077","D078","D079","D080","D081","D082","D083","D084","D085","D086","D087","D088",
        "D089","D090","D091","D092","D093","D094","D095","D096","D097","D098","D099","D100"
    ];

    var codigosOrganismo = [
        "OR001","OR002","OR003","OR004","OR005","OR006","OR007","OR008","OR009","OR010","OR011","OR012","OR013","OR014","OR015","OR016","OR017","OR018","OR019","OR020","OR021","OR022",
        "OR023","OR024","OR025","OR026","OR027","OR028","OR029","OR030","OR031","OR032","OR033","OR034","OR035","OR036","OR037","OR038","OR039","OR040","OR041","OR042","OR043","OR044",
        "OR045","OR046","OR047","OR048","OR049","OR050","OR051","OR052","OR053","OR054","OR055","OR056","OR057","OR058","OR059","OR060","OR061","OR062","OR063","OR064","OR065","OR066",
        "OR067","OR068","OR069","OR070","OR071","OR072","OR073","OR074","OR075","OR076","OR077","OR078","OR079","OR080","OR081","OR082","OR083","OR084","OR085","OR086","OR087","OR088",
        "OR089","OR090","OR091","OR092","OR093","OR094","OR095","OR096","OR097","OR098","OR099","OR100"
    ];


    var $selectCodigo = $('#codigo_delito');
    var $selectOrganismo = $('#codigo_organismo');


    codigosDelito.forEach(function(codigo) {
        var option = $('<option>', {
            value: codigo,
            text: codigo
        });
        $selectCodigo.append(option);

        $selectCodigo.formSelect();
    });


    codigosOrganismo.forEach(function(codigo) {
        var option = $('<option>', {
            value: codigo,
            text: codigo
        });
        $selectOrganismo.append(option);

        $selectOrganismo.formSelect();
    });

            
            // ############################## PANEL DE FECHAS DE LA APLICACION ###################################################
            // ###################################################################################################################
            // ###################################################################################################################
            // ###################################################################################################################
            // ###################################################################################################################


            //############################## INGRESOS: DETENIDOS
            var currYear = (new Date()).getFullYear();
            $('#fecha_nacimiento').datepicker({
                format: 'dd/mm/yyyy',
                maxDate: new Date(currYear-18,12,31),
                defaultDate: new Date(currYear-18,1,31),
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                    selectMonths: true,
                    selectYears: true, 
                yearRange: [1930, currYear-18] // Establece el rango de años desde 1930 hasta el año actual
            });


            // SE LLENA AUTOMATICAMENTE EL CAMPO "EDAD" AL SELECCIONAR LA FECHA DE NACIMIENTO HACIENDO UN CALCULO CONTRA LA FECHA ACTUAL (SISTEMA)
            $('#fecha_nacimiento').change(function () {

                let dateObj = new Date();
                let month = dateObj.getUTCMonth() + 1; //months from 1-12
                let day = dateObj.getUTCDate();
                let year = dateObj.getUTCFullYear();
                newdate = year + "/" + month + "/" + day;
                fechaActual = day + "/" + month + "/" + year;

                dateStart = $('#fecha_nacimiento').val();
                dateEnd = fechaActual;

                function numDayInDates(dateStart, dateEnd){
                    var arrayDateStart = dateStart.split('/'); 
                    var arrayDateEnd = dateEnd.split('/'); 
                    var msegDateStart = Date.UTC(arrayDateStart[2], arrayDateStart[1]-1, arrayDateStart[0]); 
                    var msegDateEnd = Date.UTC(arrayDateEnd[2], arrayDateEnd[1]-1, arrayDateEnd[0]); 
                    var diff = msegDateEnd - msegDateStart;
                    var days = Math.floor(diff / (1000 * 60 * 60 * 24)); 
                    return days;
                }

                function daysInMonth(month, year) {
                    return new Date(year, month, 0).getDate();
                }

                function sumDaysToDate(numDays, date){
                    var arrayDate = date.split('/');
                    var newDate = new Date(arrayDate[2]+'/'+arrayDate[1]+'/'+arrayDate[0]);
                    newDate.setDate(newDate.getDate()+parseInt(numDays));        
                    return newDate.getDate() + '/' + (newDate.getMonth()+1) + '/'+ newDate.getFullYear();
                }

                function daysMonthsYearsInDates(dateStart, dateEnd){
                    var daysTotals = numDayInDates(dateStart, dateEnd);
                    var daysCal = 0;
                    var cantDays = 0;
                    var cantMonths = 0;
                    var cantYears = 0;
                    while(daysCal < daysTotals){
                         var arrayDateStart = dateStart.split('/');
                         var daysOfMonth = daysInMonth(arrayDateStart[1], arrayDateStart[2]);
                         daysCal = daysCal + daysOfMonth;
                         if(daysCal <= daysTotals){
                        cantMonths ++;
                        if(cantMonths == 12){
                           cantYears++;
                           cantMonths = cantMonths - 12;
                        }
                        }else{
                           cantDays = Math.abs(numDayInDates(dateStart, dateEnd));
                        }
                        dateStart = sumDaysToDate(daysOfMonth, dateStart);
                    }
                   
                    var msg = '';
                    if (cantYears > 0)
                        msg = cantYears;
                    // if (cantMonths > 0) {
                    //     if (cantYears > 0) msg += ' y ';
                    //     msg += cantMonths + ' meses';
                    // }
                       
                    // if (cantDays > 0) {
                    //    if (cantMonths > 0) msg += ' y ';         
                    //    msg += cantDays + ' días';
                    // }
                    $('#edad').val(msg);
                    $('.label_edad').attr('style','display:none');
                }
                
                daysMonthsYearsInDates(dateStart, dateEnd);

            })

            //############################## EDITAR: DETENIDO
            
            // FECHA DE EDITAR DETENIDO
            let currentDate = new Date();
            let currentYear = currentDate.getFullYear();

             $('#fecha_nacimiento_actual').datepicker({
                 format: 'dd/mm/yyyy',
                 maxDate: new Date(currentYear-18,12,31),
                 defaultDate: new Date(currentYear-18,1,31),
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                    selectMonths: true,
                    selectYears: true, 
                yearRange: [1930, currYear] // Establece el rango de años desde 1980 hasta el año actual
             });

            //############################## INGRESOS: DETENCIONES 
            // FECHA DE INGRESO
            $('#f_ingreso').datepicker({
                format: 'dd/mm/yyyy',
                maxDate: new Date(),
                defaultDate: new Date(),
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                    selectMonths: true,
                    selectYears: true, 
                yearRange: [2000, currYear] // Establece el rango de años desde 1980 hasta el año actual
            });

            //############################## EGRESOS: DETENCIONES
            
            // FECHA DE EGRESO
            $('#fecha_egreso').datepicker({
                format: 'dd/mm/yyyy',
                maxDate: new Date(),
                defaultDate: new Date(),
                i18n: {
                    months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                    weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                    weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                    weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                    selectMonths: true,
                    selectYears: true, 
                yearRange: [2000, currYear] // Establece el rango de años desde 1980 hasta el año actual
            });
            
            
            // ############################## FIN PANEL DE FECHAS DE LA APLICACION ###############################################
            // ###################################################################################################################
            // ###################################################################################################################
            // ###################################################################################################################
            // ###################################################################################################################            


        // ################################################### PAGINADORES JQUERY ###########################################



        // ############################################## LLAMAR A LISTADO DE DETENIDOS
        cargarDatosDetenidos();

        function cargarDatosDetenidos(page){ // trae lista de detenidos
            $.ajax({  
                url:"detenidos_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_datos_detenido').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarDatosDetenidos(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarDatosDetenidos(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarDatosDetenidos(page);
        });
        // ############################################## FIN LLAMAR A LISTADO DE DETENIDOS





        // ######################################## LISTADO DETENCIONES
        // ######################################## LISTADO DETENCIONES
        cargarListadoDetenciones();

        function cargarListadoDetenciones(page){ // trae lista de detenidos
            $.ajax({  
                url:"detenciones_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_detenciones').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarListadoDetenciones(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarListadoDetenciones(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarListadoDetenciones(page);
        });


        // ########################################  FIN LISTADO DETENCIONES
        // ########################################  FIN LISTADO DETENCIONES




        // ######################################## LISTADO EGRESOS
        // ######################################## LISTADO EGRESOS
        cargarListadoEgresos();

        function cargarListadoEgresos(page){ // trae lista de egresos
            $.ajax({  
                url:"egresos_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_egresos').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarListadoEgresos(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarListadoEgresos(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarListadoEgresos(page);
        });


        // ########################################  FIN LISTADO EGRESOS
        // ########################################  FIN LISTADO EGRESOS


        
        // LLAMAR A LISTADO DE DETENCIONES
        load_dataDetenciones();

        function load_dataDetenciones(page){
            $.ajax({  
                url:"consulta_detencion.php?detenido_id="+$('#detenido_id').val()+ "&pg="+$('#pg').val(),  

                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#pagination_data_detenciones').html(data);
                }  
            })  
        }

        $(document).on('click', '.pagination_link_detencion > a', function(){  
            var page = $(this).attr("id");
            load_dataDetenciones(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda_detencion', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                load_dataDetenciones(page); 
            }
        });
        
        $(document).on('click', '.derecha_detencion', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            load_dataDetenciones(page);
        });



        
        // ######################################## LISTADO DELITOS
        // ######################################## LISTADO DELITOS
        cargarListadoDelitos();

        function cargarListadoDelitos(page){ // trae lista
            $.ajax({  
                url:"delitos_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_delitos').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarListadoDelitos(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarListadoDelitos(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarListadoDelitos(page);
        });


        // ########################################  FIN LISTADO DELITOS
        // ########################################  FIN LISTADO DELITOS




        // ######################################## LISTADO ORGANISMOS
        // ######################################## LISTADO ORGANISMOS
        cargarListadoOrganismos();

        function cargarListadoOrganismos(page){ // trae lista
            $.ajax({  
                url:"organismos_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_organismos').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarListadoOrganismos(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarListadoOrganismos(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarListadoOrganismos(page);
        });


        // ########################################  FIN LISTADO ORGANISMOS
        // ########################################  FIN LISTADO ORGANISMOS




        // ######################################## LISTADO TIPOEGRESO
        // ######################################## LISTADO TIPOEGRESO
        cargarListadoTipoEgreso();
        $('#modalRegistrarTipoEgreso').modal();

        function cargarListadoTipoEgreso(page){ // trae lista
            $.ajax({  
                url:"tipoegreso_listado.php",  
                method:"POST",  
                data:{page:page},
                success:function(data){ 
                    $('#listado_tipoegreso').html(data);
                }  
            })  
        }

        // INCIO DE LA PROGRAMACION DE LOS PAGINADORES 
        $(document).on('click', '.pagination_link > a', function(){  
            var page = $(this).attr("id");
            cargarListadoTipoEgreso(page);  
            $('#izquierda').val(page);  
        });
        
        $(document).on('click', '.izquierda', function(){  
            var page = $(this).attr("id");
            if (page > 1){
                var page = page-1;
                cargarListadoTipoEgreso(page); 
            }
        });
        
        $(document).on('click', '.derecha', function(){  
            var page = $(this).attr("id");
            var page = ++page;
            cargarListadoTipoEgreso(page);
        });


        // ########################################  FIN LISTADO TIPOEGRESO
        // ########################################  FIN LISTADO TIPOEGRESO


        // ################################################### FIN PAGINADOR JQUERY ###########################################

        $('#foto').change( function() {
            if(this.files[0].size > 512000) { // 512 bytes = 500 Kb
                    $(this).val('');
              $('#errores').html("El archivo supera el límite del peso permitido.");
            } else { //ok
               var formato = (this.files[0].name).split('.').pop();
              //alert(formato);
                   if(formato.toLowerCase() == 'jpg' || formato.toLowerCase() == 'png' || formato.toLowerCase() == 'jpeg') {
                      $('#errores').html("Foto válida");
                } else {
                  $(this).val('');
                  $('#errores').html("Formato no soportado");
                }
               }
        });
        $("img").css('pointer-events','none');
        $("img").bind("contextmenu", function(){
                return false;   
            });


}); // ################################################### FIN DEL DOCUMENT READY





// TIPO DE USUARIO - FUNCION PARA OCULTAR ELEMENTOS Y URLS SEGUN EL ROL DE INGRESO
function Permisos(t_usuario) {
    if (t_usuario == '2') {
        // CAMPOS DEL NAV
        $('.revocarAccesoPorPermisosDenegados').empty();
        $('.revocarAccesoPorPermisosDenegadosElemento').remove();

        // REDIRECCION CUANDO ACCEDEN POR URL
        var re = "registro_detenido";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_detenidos";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_detenido";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "eliminar_detenido";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_detencion";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_detenciones";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_detencion";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "eliminar_detencion";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_delito";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_delito";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_organismo";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_organismo";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "registro_egreso";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_egreso";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "eliminar_egreso";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "editar_tipoegreso";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
        var re = "eliminar_tipoegreso";
        if (location.pathname.search(re) >= 0) {
            capturarURL()
        }
    }

    // HREF . REDIRECCIONAR POR ACCESO INDEBIDO A LAS URLS
    function capturarURL() {
        var url = '../php/consulta.php';
        location.assign(url, 'consulta');
    }
    return false;
}
    
// BLOQUEO DE FUNCIONES ESPECIFICAS POR NO ESTAR DENTRO DEL ROL
function BloqueoBtnPermisos() {
    $('#editar_datos_detenido').remove();
    $('#mostrar_registrar_detencion').remove();
    return false;
} 





// FUNCION PARA BUSCAR LOS DATOS DEL DETENIDO EN BASE A LA CEDULA SUMISTRADA
// LA FUNCION TAMBIEN EDITA ALGUNOS CAMPOS HTML PARA MOSTRAR INFORMACION
// ASI MISMO, LA FUNCION TAMBIEN PERMITE LA EDICION DE LOS CAMPOS PREVIAMENTE CARGADOS CON DATOS
$('#consultar').click(function() {

    if ($('#cedula').val() != "" && $('#cedula').val() > 0) {
        Busqueda($('#cedula').val()); // Llamado a la función luego de la validación del campo "cedula"
    } return false;
});

function Busqueda (cedula) {
    var parametros = {"ced":cedula,"tipo":'buscar'};
    $.ajax({
    data:parametros,
    url:'../php/backend.php',
    type: 'post',
        success: function (response) {
            var json = $.parseJSON(response);
            if (json != 'no existe') {
                $("#datos_general").attr('style','display:inline');
                $("#consultar").hide();
                $("#refrescar1").attr('style','display:inline');
                $("#cedula_div").html('<span class="helper-text">Cédula de Identidad</span><input Disabled id="cedula" type="text" class="validate" value="'+json.cedula+'">');
                $("#ciudadano_div").html('<span class="helper-text">Ciudadanía</span><input Disabled id="ciudadano" type="text"  class="validate"  value="'+json.ciudadano+'"><input id="ciudadano_id" style="display:none" type="text" value="'+json.ciudadano_idfk+'">');
                $("#p_nombre_div").html('<span class="helper-text">Primer nombre*</span><input Disabled id="p_nombre" type="text"  class="validate" value="'+json.primer_nombre+'" required="true" filter="text"></input>');
                $("#s_nombre_div").html('<span class="helper-text">Segundo nombre</span><input Disabled id="s_nombre" type="text"  class="validate" value="'+json.segundo_nombre+'" required="true" filter="text"></input>');
                $("#p_apellido_div").html('<span class="helper-text">Primer apellido*</span><input Disabled id="p_apellido" type="text"  class="validate" value="'+json.primer_apellido+'" required="true" filter="text"></input>');
                $("#s_apellido_div").html('<span class="helper-text">Segundo apellido</span><input Disabled id="s_apellido" type="text"  class="validate" value="'+json.segundo_apellido+'" required="true" filter="text"></input>');
                $("#fecha_n_div").html('<span class="helper-text">Fecha de nacimiento*</span><input Disabled id="fecha_n" type="text"  class="validate" value="'+json.fecha_nacimiento+'" required="true" filter="text"></input>');
                $("#edad_div").html('<span class="helper-text">Edad*</span><input Disabled id="edad" type="text" class="validate" value="'+json.edad+'"></input><input id="datof_id" style="display:none" type="text" value="'+json.detenido_id+'"></input>');
                //direccion
                $("#direccion_info_div").html('<p class="info">Dirección:</p><div class="input-field col s6 m3"><span class="helper-text">Estado*</span><input Disabled id="dir_estado" type="text" value="'+json.estado+'" required="true"  class="validate" filter="text"></input></div><div class="input-field col s6 m3"><span class="helper-text">Ciudad*</span><input Disabled id="dir_ciudad" type="text" value="'+json.ciudad+'" required="true"  class="validate" filter="text"></input></div><div class="input-field col s6 m3"><span class="helper-text">Código postal*</span><input Disabled id="dir_codigo" type="text" value="'+json.codigo_postal+'" required="true"  class="validate" filter="text"></input></div><div class="input-field col s6 m12"><span class="helper-text">Dirección*</span><input Disabled id="dir_direccion" type="text" value="'+json.direccion+'" required="true"  class="validate" filter="text"></input></div>');
                //muestra el botón para editar datos del detenido
                $("#editar_datos_detenido").attr('style','display:inline');
                //muestra botón para registrar una detención (redireccion a registro.php con el id del consultado)
                $("#mostrar_registrar_detencion").css('display','inline');
    

                // Ejecuta editar DATOS DEL DETENIDO 
                $("#editar_datos_detenido").click(function() {
                    $(this).attr('style','display:none');
                    $("#p_nombre").removeAttr("Disabled");
                    $("#s_nombre").removeAttr("Disabled");
                    $("#p_apellido").removeAttr("Disabled");
                    $("#s_apellido").removeAttr("Disabled");
                    $("#edad").removeAttr("Disabled");
                    $("#dir_estado").removeAttr("Disabled");
                    $("#dir_ciudad").removeAttr("Disabled");
                    $("#dir_codigo").removeAttr("Disabled");
                    $("#dir_direccion").removeAttr("Disabled");
                    
                    // boton para guardar cambios en datos del detenido
                    $("#guardar_cambios_datos_detenido").attr('style','display:inline');

                });

            //     // Llamar a funcion que ejecuta buscar_interno
            //     BuscarInterno(json.datof_id,0);
                
            } else{
                // Ejecuta un anuncio con datos no encontrados y refresca la pantalla
                M.toast({html: 'No se encontraron datos asociados'});
            }
        }
    })
    return false;
}

// FUNCION QUE ES INVOCADA POR UN BOTON QUE DISPARA UN MODAL CON UNA PREGUNTA
// SI DESEA REGISTRAR UNA DOCUMENTACION DE INGRESO DE INTERNO DETENIDO 
// EN CASO AFIRMATIVO SE MUESTRAN CAMPOS ADICIONALES PARA LA DOCUMENTACION
// EN CASO NEGATIVO SE ACTIVA SUBMIT PARA REGISTRAR LOS DATOS SUMINISTRADOS HASTA EL MOMENTO


$('#cedula').blur(function () { // valida la cedula en el momento que deja de presionar el campo "Cédula de Identidad"
    var cedula = $('#cedula').val();
     if(cedula > 0 && cedula != ""){
        var cedula = {"cedula":cedula};
        $.ajax({
            data: cedula,
            url:'../php/validar_existencia_cedula.php',
            type: 'post',
            success: function (response) {
                if (response === "exito") {
                    $('#mensaje_cedula').html("Cédula registrada");
                    $('#mensaje_cedula').css("color","red");
                    $('#mensaje_cedula').fadeIn(500);
                    $('#contador').val("1");
                } else {
                    $('#mensaje_cedula').fadeIn(500);
                    $('#mensaje_cedula').html("Cédula válida");
                    $('#mensaje_cedula').css("color","green");
                    $('#contador').val("0");
                }
            }
        })
     } return false;
})

 function preguntarRegistroDatosf() {

    // validacion de campo nacionalidad
    var nac = $('#nacionalidad').find(":selected").val();
    var ced = $('#cedula').val();
    var p_nombre = $('#p_nombre').val();
    var p_apellido = $('#p_apellido').val();
    var fecha_n = $('#fecha_nacimiento').val();
    var estado = $('#estado').find(":selected").val();
    var municipio = $('#municipio').find(":selected").val();
    var direccion = $('#direccion').val();
    var sexo = $('#sexo').find(":selected").val();
    $('#tipo').val("registro_datosf");

    if ($('#contador').val() == 0) { // valida que la cédula no se encuentre registrada de nuevo para evitar registrar

        if (nac > 0 && ced != "" && p_nombre != "" && p_apellido != "" && fecha_n != "" && direccion != "" && estado != "" && municipio != "" && sexo > 0) {

            $('#modalRegistrarDatosf').modal();
            $('#documentar_si').addClass('modal-close');
        }
        else{
            $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        }
    } else{
        $('#mensaje_cedula').text("Verifique el número de Cédula");
        $('#mensaje_cedula').fadeIn(500);
    }
    return false;
}

// EN CASO NEGATIVO (SE PROCEDE A REGISTRAR LOS DATOS DEL DETENIDO SOLAMENTE)
$('#no_modal_registrar').click(function () {
    
        $('#documentar_si').attr('disabled','disabled');
        $('#no_modal_registrar').attr('disabled','disabled');

        // A partir de edad la calculada por funcion activa al campo EDAD, se añade su valor al formulario
        var edad = (document.getElementById('edad')||{}).value;
        $('#edad_calculada').val(edad);
        
        M.toast({html: 'Registrado exitosamente', classes: 'rounded', completeCallback: function() {
            $('#form_registro_datosf').submit();
        }});
})

// // EN CASO AFIRMATIVO (SE PROCEDE A REGISTRAR LOS DATOS DEL DETENIDO Y A DOCUMENTAR LA DETENCION)
$('#documentar_si').click(function() {
    $('#mensaje_campos').hide();

    // A partir de la edad calculada por funcion, activa al campo EDAD. Se añade su valor al formulario
    var edad = (document.getElementById('edad')||{}).value;
    $('#edad_calculada').val(edad);

    // LOS DATOS DEL FORMULARIO SE ENVIAN A OTRO REGISTRADOR PHP DEBIDO A QUE HABRÁ REDIRECCION A LLENAR FORMULARIO DE DETENCION
    $("#form_registro_datosf").attr('action','backend_detenidoydetencion.php');

    M.toast({html: 'Registrado exitosamente. Documente la Detención a continuación.', classes: 'rounded', completeCallback: function() {
        $('#form_registro_datosf').submit();
    }});
});


// DETENCIONES DETENCIONES DETENCIONES ##################################################################
// DETENCIONES DETENCIONES DETENCIONES ##################################################################
// DETENCIONES DETENCIONES DETENCIONES ##################################################################



$('#expediente').blur(function () { // valida el n. de expediente en BD al dejar el campo "Expediente".
    var expediente = $('#expediente').val();
    if (expediente > 0 && expediente != "") {
        
        $.ajax({
            data: {'expediente':expediente},
            url:'../php/validar_existencia_expediente.php',
            type: 'post',
            success: function (info) {
                if (info == 1) {
                    $('#mensaje_expediente').html("Expediente registrado, ingrese otro.");
                    $('#mensaje_expediente').css("color","red");
                    $('#mensaje_expediente').fadeIn(500);
                    $('#contador_expediente').val("1");
                } else{
                    $('#mensaje_expediente').fadeIn(500);
                    $('#mensaje_expediente').html("Expediente válido, puede continuar.");
                    $('#mensaje_expediente').css("color","green");
                    $('#mensaje_expediente').fadeOut(4000);
                    $('#contador_expediente').val("0");
                    
                }
            }
        })
    } else {
        $('#mensaje_expediente').fadeOut(500);
    } return false;
})


    // Manejo del clic en el botón
    $('#btnEnviar').click(function() {

        // DETENCION
        var expediente = $('#expediente').val();
        var f_ingreso = $('#f_ingreso').val();
        var lugar_detencion = $('#lugar_detencion').val();
        var descripcion_detencion = $('#descripcion_detencion').val();
        var direccion_detencion = $('#direccion_detencion').val();
        var estado_detencion = $('#estado').find(":selected").val();
        var municipio_detencion = $('#municipio').find(":selected").val();

        if ($('#contador_expediente').val() == 0) { // valida que el expediente no se encuentre registrado, para evitar problemas de incosistencias

            if (expediente != "" && f_ingreso != "" && lugar_detencion != "" && descripcion_detencion != "" && descripcion_detencion != "" && direccion_detencion != "" && estado_detencion != "" && municipio_detencion != "")  {
                
                M.toast({html: 'Registrado exitosamente.', classes: 'rounded', completeCallback: function() {
                    $('#form_doc_interno_detenido').submit();
            }});
            }
            else{
                $('#mensaje_campos_in_detenido').text("Debe completar todos los campos requeridos *");
                
            }
        } else{
            $('#mensaje_campos_in_detenido').text("Verifique el Número de Expediente para continuar.");
        }
        return false;
    });

        // Manejo del clic en el botón CUANDO PROVIENE CON LISTA DE DETENIDOS
        $('#btnEnviarPorLista').click(function() {

            // DETENIDO
            var detenido = $('#detenido').find(":selected").val();
            // DETENCION
            var expediente = $('#expediente').val();
            var f_ingreso = $('#f_ingreso').val();
            var lugar_detencion = $('#lugar_detencion').val();
            var descripcion_detencion = $('#descripcion_detencion').val();
            var direccion_detencion = $('#direccion_detencion').val();
            var estado_detencion = $('#estado').find(":selected").val();
            var municipio_detencion = $('#municipio').find(":selected").val();

            if ($('#contador_expediente').val() == 0) { // valida que el expediente no se encuentre registrado, para evitar problemas de incosistencias
    
                if (detenido > 0 && expediente != "" && f_ingreso != "" && lugar_detencion != "" && descripcion_detencion != "" && descripcion_detencion != "" && direccion_detencion != "" && estado_detencion != "" && municipio_detencion != "")  {
                    
                    M.toast({html: 'Registrado exitosamente.', classes: 'rounded', completeCallback: function() {
                        $('#form_doc_interno_detenido').submit();
                }});
                }
                else{
                    $('#mensaje_campos_in_detenido').text("Debe completar todos los campos requeridos *");
                    
                }
            } else{
                $('#mensaje_campos_in_detenido').text("Verifique el Número de Expediente para continuar.");
            }
            return false;
        });


// Función para enviar ambos formularios mediante AJAX
function enviarFormularios() {
    var formulario1 = $('#form_registro_datosf')[0]; // Obtén el formulario como un objeto nativo de JavaScript
    var formulario2 = $('#form_doc_interno_detenido');

    var formData1 = new FormData(formulario1);

    $.ajax({
        type: 'POST',
        url: formulario1.action,
        data: formData1,
        processData: false,  // No procesar datos
        contentType: false,  // No configurar contentType
        success: function(response1) {
            // Manejar la respuesta del servidor para el formulario 1
        }
    });

    $.ajax({
        type: formulario2.attr('method'),
        url: formulario2.attr('action'),
        data: formulario2.serialize(),
        success: function(response2) {
             // Manejar la respuesta del servidor para el formulario 2
        }
    });
}



// FUNCION PARA GUARDAR LOS DATOS DEL DETENIDO EDITADOS
$('#guardar_cambios_datos_detenido').click(function() {
    if ($('#p_nombre').val() != "" && $('#p_apellido').val() != "" && $('#fecha_n').val() != "" && $('#edad').val() != "" && $('#dir_estado').val() != "" && $('#dir_municipio').val() != "" && $('#dir_codigo').val() != "" && $('#dir_direccion').val() != "") {
        datof_id = $('#datof_id').val();
        p_nombre = $('#p_nombre').val();
        s_nombre = $('#s_nombre').val();
        p_apellido = $('#p_apellido').val();
        s_apellido = $('#s_apellido').val();
        fecha_n = $('#fecha_n').val();
        edad = $('#edad').val();
        dir_estado = $('#estado').val();
        dir_municipio = $('#municipio').val();
        dir_codigo = $('#dir_codigo').val();
        dir_direccion = $('#dir_direccion').val();
        // si todo coincide llama funcion para guardar los cambios
        GuardarDatosEditadosDetenido(datof_id,p_nombre,s_nombre,p_apellido,s_apellido,fecha_n,edad,dir_estado,dir_municipio,dir_codigo,dir_direccion);
    } else {
         $('#mensaje_campos').fadeIn(500);
         $('#mensaje_campos').text("Debe completar todos los campos requeridos (*)");
         $('#mensaje_campos').fadeOut(10000);
    }

    function GuardarDatosEditadosDetenido(datof_id,p_nombre,s_nombre,p_apellido,s_apellido,fecha_n,edad,dir_estado,dir_municipio,dir_codigo,dir_direccion) {
        var par = {'id':datof_id,'p_nombre':p_nombre,'s_nombre':s_nombre,'p_apellido':p_apellido,'s_apellido':s_apellido,'dir_estado':dir_estado,'dir_municipio':dir_municipio,'dir_codigo':dir_codigo,'dir_direccion':dir_direccion,'fecha_n':fecha_n,'edad':edad,'tipo':'editar'};
        $.ajax({
            data:par,
            url:'../php/backend.php',
            type: 'post',
            success: function (response) {

            //Ejecuta un anuncio con cambios guardados y refresca la pantalla, esconder boton
                $("#guardar_cambios_datos_detenido").attr('disabled','disabled');
                M.toast({html: 'Cambios guardados exitosamente', classes: 'rounded', completeCallback: function() {
                location.reload(); 
                }});
            }
        })
    } return false;
});



// FUNCION DE BUSCAR LA INFORMACION DE INTERNO DETENIDO ASOCIADO A CEDULA SUMINISTRADA
// ADICIONALMENTE LA FUNCION LLENA DESDE PHP UNA TABLA DINAMICA CON LA INFORMACION
// EN JQUERY SOLO SE MUESTRA EN PANTALLA Y SE VISUALIZAN LOS BOTONES DE IMPRESION Y REGISTRO
function BuscarInterno (datof_id, inicio) {
    var p = {'id':datof_id,'tipo':'buscar_interno','inicio':inicio};
    $.ajax({
        data:p,
        url:'../php/backend_interno.php',
        type: 'post',
        success: function (response) {
            if (response != '"error"') {
                $("#data_interno_detenido").html(response);
                $("#mostrar_imprimir_detenido ").css('display','inline');
                if ($('#r_usuario_id').val() == 2) {
                    BloqueoBtnPermisos(); // se bloquean algunos botones por el tipo de usuario logueado
                }
                // INICIO PAGINACION
                var nro_enlaces = Math.ceil($("#num_reg").val()/5); // PAGINACION: SE DIVIDE LA LISTA TOTAL ENTRE LA CANTIDAD DE PAGINAS 
                if ($("#num_reg").val() >= 5) {
                    
                    var paginador ='<ul class="pagination">';
                    if (inicio > 1) {
                        paginador+='<li class="waves-effect"><a href="javascript:void(0)" onclick="BuscarInterno('+datof_id+','+0+')">&laquo;</a></li>';
                        paginador+='<li class="waves-effect"><a href="javascript:void(0)" onclick="BuscarInterno('+datof_id+','+(inicio-1)+')">&lsaquo;</a></li>';
                    } else{
                        paginador+='<li class="waves-effect disabled"><a href="javascript:void(0)">&laquo;</a></li>';
                        paginador+='<li class="waves-effect disabled"><a href="javascript:void(0)">&lsaquo;</a></li>';
        
                    }
                    for (i = 0; i <= nro_enlaces; i++) {
                        if (i == inicio) {
                            paginador+='<li class="waves-effect active"><a href="javascript:void(0)">'+(i+1)+'</a></li>'
                        } else{
                            paginador+='<li class="waves-effect"><a href="javascript:void(0)" onclick="BuscarInterno('+datof_id+','+i+')">'+(i+1)+'</a></li>';
                        }                            
                    }
                    if (inicio < nro_enlaces) {
                        paginador+='<li class="waves-effect"><a href="javascript:void(0)" onclick="BuscarInterno('+datof_id+','+(inicio+1)+')">&rsaquo;</a></li>';
                        paginador+='<li class="waves-effect"><a href="javascript:void(0)" onclick="BuscarInterno('+datof_id+','+(nro_enlaces)+')">&raquo;</a></li>';
                        
                    }
                    else{
                        paginador+='<li class="waves-effect disabled"><a href="javascript:void(0)">&rsaquo;</a></li>';
                        paginador+='<li class="waves-effect disabled"><a href="javascript:void(0)">&raquo;</a></li>';
        
                    }
                    paginador+='</ul>'; 
                    $("#paginador").html(paginador);
                    // FINAL PAGINACION 
                }
            }
        } 
    }) 
    return false;
}
// FUNCION ONCLICK PARA VALIDAR ALGUNOS CAMPOS AL DOCUMENTAR UN NUEVO INGRESO DESDE CONSULTA
$('#registrar_general').click(function() {
    var de = $('#delito').find(":selected").val();
    var or = $('#organismo').find(":selected").val();
    if (de > 0 && or > 0) {
        $('#registrar_general').attr('disabled','disabled'); // se bloquea evitando volver a registrar
        M.toast({html: 'Registrado exitosamente', classes: 'rounded', completeCallback: function() {
            $('#registrar_general').attr('disabled','disabled');
            $('#form_documentar').submit();    
        }});
    }
    else{
        $('#mensaje_documetarinterno').text("Debe completar todos los campos requeridos *");
    }
})


// FUNCION DE REGISTRAR EDICION-MOSTRAR EL DETALLE- EDITAR Y ELIMINAR DOCUMENTACION DE INTERNO DETENIDO
// LLAMADO AL MODAL Y ASIGNACION DE VARIABLES A CAMPOS OCULTOS
function RegistrarDetencion(detenido_id) {
    location.assign('../php/registro.php?detenido_id='+detenido_id);
    //$('#modalRegistro').modal();
    //$('#datosf_id').val(detenido_id); //asignacion de variable oculta
    //$('#tipo_registro').attr('id','tipo'); //asignacion del tipo registro
}

function DetalleInterno(interno_id) {
    $('#titulo_dinamico').text('Detalle');
    $('#eliminar_datos_internodetenido').hide();
    $('#editar_datos_internodetenido').hide();
    $('#consultar_datos_internodetenido').show();
    $('#modalGeneral').modal();
    
    var p = {'id':interno_id,'tipo':'detalle_interno'};
    $.ajax({
        data:p,
        url:'../php/backend_interno.php',
        type: 'post',
        success: function (response) {
            var json = $.parseJSON(response);
             $('#f_ingreso_div').html('<span class="helper-text">Fecha de ingreso</span><input id="f_ingreso" type="date" disabled value="'+json.fecha_ingreso+'">');
             $('#f_egreso_div').html('<span class="helper-text">Fecha de egreso</span><input id="f_egreso" type="date" disabled value="'+json.fecha_egreso+'">');
             $('#descripcion_egreso_div').html('<span class="helper-text">Descripción de egreso</span><textarea id="descripcion_egreso" class="materialize-textarea" disabled>'+json.descripcion_egreso+'</textarea>');
             $('#l_detencion_div').html('<span class="helper-text">Lugar de detención</span><input id="lugar_detencion" type="text" disabled value="'+json.lugar_detencion+'">');
             $('#descripcion_div').html('<span class="helper-text">Descripción</span><textarea id="descripcion_interno" class="materialize-textarea" disabled>'+json.descripcion+'</textarea>');
             $('#delito_div').html('<span class="helper-text">Delito</span><input id="delito" type="text" disabled value="'+json.codigo_delito+'- '+json.nombreDelito+'">');
             $('#descripcion_delito_div').html('<span class="helper-text">Descripción del delito</span><textarea id="descripcion_delito" class="materialize-textarea" disabled>'+json.detalleDelito+'</textarea>');
             $('#descripcion_delito_div').css('display','inline');
             $('#organismo_div').html('<span class="helper-text">Código del organismo</span><input id="codigo_organismo" type="text" disabled value="'+json.codigo_organismo+'">');
             $('#descripcion_organismo_div').html('<span class="helper-text">Descripción de organismo</span><textarea id="descripcion_organismo_div" class="materialize-textarea" disabled>'+json.detalleOrganismo+'</textarea>');
             $('#descripcion_organismo_div').css('display','inline');
             $('#persona_contacto_div').html('<span class="helper-text">Representante del organismo</span><input id="persona_contacto" type="text" disabled value="'+json.PersonaOrganismo+'">');
             $('#persona_contacto_div').css('display','inline');
        }
    })
    return false;
}


function EditarInterno(interno_id) {
    $('#modalGeneral').modal();
    $('#titulo_dinamico').text('Editar información');
    $('#consultar_datos_internodetenido').hide();
    $('#eliminar_datos_internodetenido').hide();
    $('#editar_datos_internodetenido').show();
    

    var p = {'id':interno_id,'tipo':'detalle_interno'};
    $.ajax({
        data:p,
        url:'../php/backend_interno.php',
        type: 'post',
        success: function (response) {
            var json = $.parseJSON(response);
            $('#f_ingreso_div_edit').html('<span class="helper-text">Fecha de ingreso</span><input id="f_ingreso_e" type="date" value="'+json.fecha_ingreso+'" required="true" class="validate">');
            $('#f_egreso_div_edit').html('<span class="helper-text">Fecha de egreso</span><input id="f_egreso_e" type="date" value="'+json.fecha_egreso+'">');
            $('#descripcion_egreso_div_edit').html('<span class="helper-text">Descripción de egreso</span><textarea id="descripcion_egreso_interno" class="materialize-textarea validate" required="true">'+json.descripcion_egreso+'</textarea>');
            $('#l_detencion_div_edit').html('<span class="helper-text">Lugar de detención</span><input id="lugar_detencion_e" class="validate" type="text" required="true" value="'+json.lugar_detencion+'">');
            $('#descripcion_div_edit').html('<span class="helper-text">Descripción</span><textarea id="descripcion_interno_e" class="materialize-textarea validate" required="true">'+json.descripcion+'</textarea>');
            $('#delito_div_edit').html('<span class="helper-text">Cambiar delito</span><select id="delito_e" class="browser-default validate" name="delito" required="true"><option value="'+json.delito_id+'" disabled selected>'+json.codigo_delito+'- '+json.nombreDelito+'</option></select>');
            $('#organismo_div_edit').html('<span class="helper-text">Cambiar organismo</span><select id="organismo_e" class="browser-default validate" name="organismo" required="true"><option value="'+json.organismo_id+'" disabled selected>'+json.codigo_organismo+'- '+json.detalleOrganismo+'</option></select><input id="datof_id_edit" type="text" style="display:none" value="'+json.datof_id+'"><input id="interno_id_edit" type="text" style="display:none" value="'+interno_id+'">');  
         }
    })
    return false;
}

$('#guardar_general').click(function() { // guardar LOS DATOS EDITADOS
        var fi = $('#f_ingreso_e').val();
        var fe = $('#f_egreso_e').val();
        var dese = $('#descripcion_egreso_interno').val();
        var ld = $('#lugar_detencion_e').val();
        var di = $('#descripcion_interno_e').val();
        var i_id = $('#interno_id_edit').val();
        var df_id = $('#datof_id_edit').val();
        var de = $('#delito_div_edit > select > option').val();
        var or = $('#organismo_div_edit > select > option').val();
        
        if (fi != "" && ld != "" && di != "" && de != "" && or != "") {
            $('#mensaje_camposinterno').hide();
            var u = {'id':i_id,'fi':fi,'fe':fe,'dese':dese,'ld':ld,'di':di,'de':de,'or':or,'df_id':df_id,'tipo':'editar_interno'};
            $.ajax({
            data:u,
            url:'../php/backend_interno.php',
            type: 'post',
                success: function (response) {
                    if (response == "exito") {
                        //Cerrar el modal y ejecuta un anuncio con cambios guardados y refresca la pantalla
                        $("#guardar_general").attr('disabled','disabled');
                        M.toast({html: 'Cambios guardados exitosamente', classes: 'rounded', completeCallback: function() {
                            location.reload();     
                        }});
                    }
                }   
            }) 
            return false;
        } else {
            $('#mensaje_camposinterno').text("Debe completar todos los campos requeridos *");
        }
})


function EliminarInterno(interno_id) {
    $('#titulo_dinamico').text('Eliminar');
    $('#consultar_datos_internodetenido').hide();
    $('#editar_datos_internodetenido').hide();
    $('#eliminar_datos_internodetenido').show();
    $('#modalGeneral').modal();

    $('#eliminar_general').click(function() {
        var p = {'id':interno_id,'tipo':'eliminar_interno'};
        $.ajax({
            data:p,
            url:'../php/backend_interno.php',
            type: 'post',
            success: function (response) {
                if (response == "exito") {
                    //Cerrar el modal y ejecuta un anuncio con cambios guardados y refresca la pantalla
                    M.toast({html: 'Eliminado correctamente', classes: 'rounded', completeCallback: function() {
                        var instance = M.Modal.getInstance($('#modalGeneral').modal());
                        instance.close();
                        location.reload(); 
                    }});
                }
            }
        })
    })
    return false;
}

// IMPRIMIR INTERNO -ACCIONES EN JAVASCRIPT-
// Se llama a la función click para asignar url de impresión al boton
$('#mostrar_imprimir_detenido').click(function() {
    $('#mostrar_imprimir_detenido > a').attr('href','../pdf/reporte_datos.php?id='+$('#datof_id').val());
}) 


// ##################################### DELITOS ####################################################

$("#registrarDelito").on( "click", function() {

    // validacion de campos
    var codigo_delito = $('#codigo_delito').find(":selected").val();
    var nombre = $('#nombre').val();
    var descripcion = $('#descripcion').val();
    var contador = 0;

        if (codigo_delito != "" && nombre != "" && descripcion != "") {
            // validamos la existencia del codigo para delito
            $.ajax({
            data: {'codigo':codigo_delito},
            url:'../php/validar_existencia_codigodelito.php',
            type: 'post',
                success: function (response) {
                    if (response == "exito") {
                        $('#mensaje_delito').html("Código registrado, seleccione otro.");
                        $('#mensaje_delito').attr("style","color:red");
                        contador = 1;
                    } else {
                        contador = 0;
                    }
                    if (contador == 0) {
                        $('#mensaje_delito').html("Código válido");
                        $('#mensaje_delito').attr("style","color:green"); //certifica que el codigo no existe en base de datos
                        M.toast({html: 'Registrado correctamente', classes: 'rounded', completeCallback: function() {
                            $('#formRegistroDelito').submit();
                        }});
                    }
                }
            })
        }
        else{
            $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        }
    });


$("#editarDelito").on( "click", function() {

        // validacion de campos
        var edit_codigo_delito = $('#codigo_delito').find(":selected").val();
        var codigo_hidden = $('#codigo_delito_hidden').val();
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        var contador = 0;

        if (edit_codigo_delito != "" && nombre != "" && descripcion != "") {

            if (edit_codigo_delito != codigo_hidden) { // si el codigo elegido es diferente al registro de BD; se valida que no esté ya asignado a otro organismo
                $.ajax({
                    data: {'codigo':edit_codigo_delito},
                    url:'../php/validar_existencia_codigodelito.php',
                    type: 'post',
                        success: function (response) {
                            if (response == "exito") {
                                $('#mensaje_delito').html("Código registrado, seleccione otro.");
                                $('#mensaje_delito').attr("style","color:red");
                                contador = 1;
                            } else {
                                contador = 0;
                            }
                            if (contador == 0) {
                                $('#mensaje_delito').html("Código válido");
                                $('#mensaje_delito').attr("style","color:green"); //certifica que el codigo no existe en base de datos
                                M.toast({html: 'Editado correctamente', classes: 'rounded', completeCallback: function() {
                                    $('#formEditarDelito').submit();
                                    
                                }});
                            }
                        }
                    })
            } else {
                $('#mensaje_delito').html("");
                 // eligiendo su propio codigo
                M.toast({html: 'Editado correctamente', classes: 'rounded', completeCallback: function() {
                    $('#formEditarDelito').submit();
                    
                }});
            }
        }
        else{
            $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        }

  });
  
  // ##################################### ORGANISMOS ####################################################

$("#registrarOrganismo").on( "click", function() {

    // validacion de campos
    var codigo_organismo = $('#codigo_organismo').val();
    var nombre = $('#nombre').val();
    var descripcion = $('#descripcion').val();
    var telefono = $('#telefono').val();
    var correo = $('#correo').val();
    var estado = $('#estado').find(":selected").val();
    var municipio = $('#municipio').find(":selected").val();
    var direccion = $('#direccion').val();

    var contador = 0;
    if (codigo_organismo != "" && nombre != "" && descripcion != "" && telefono > 0  && correo != "" && estado != "" && municipio != "" && direccion != "") {
        // validamos la existencia del codigo para organismo
        $.ajax({
        data: {'codigo':codigo_organismo},
        url:'../php/validar_existencia_codigorganismo.php',
        type: 'post',
            success: function (response) {
                if (response == "exito") {
                    $('#mensaje_organismo').html("Código registrado");
                    $('#mensaje_organismo').attr("style","color:red");
                    contador = 1;
                } else {
                    contador = 0;
                }
                if (contador == 0) {
                    $('#mensaje_organismo').html("Código válido");
                    $('#mensaje_organismo').attr("style","color:green"); //certifica que el codigo no existe en base de datos
                    $("#registrarOrganismo").attr('disabled','disabled');
                    M.toast({html: 'Registrado correctamente', classes: 'rounded', completeCallback: function() {
                        $('#formRegistrOrganismo').submit();
                    }});
                }
            }
        })
    }
    else{
        $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
    }
});


  $("#editarOrganismo").on( "click", function() {

        // validacion de campos
        var edit_codigo_organismo = $('#codigo_organismo').find(":selected").val();
        var codigo_hidden = $('#codigo_organismo_hidden').val();
        var nombre = $('#nombre').val();
        var descripcion = $('#descripcion').val();
        var telefono = $('#telefono').val();
        var correo = $('#correo').val();
        var estado = $('#estado').find(":selected").val();
        var municipio = $('#municipio').find(":selected").val();
        var direccion = $('#direccion').val();
        var contador = 0;

        if (edit_codigo_organismo != "" && nombre != "" && descripcion != "" && telefono != "" && correo != "" && estado != "" && municipio != "" && direccion != "") {

            if (edit_codigo_organismo != codigo_hidden) { // si el codigo elegido es diferente al registro de BD; se valida que no esté ya asignado a otro organismo
                $.ajax({
                    data: {'codigo':edit_codigo_organismo},
                    url:'../php/validar_existencia_codigorganismo.php',
                    type: 'post',
                        success: function (response) {
                            if (response == "exito") {
                                $('#mensaje_organismo').html("Código registrado");
                                $('#mensaje_organismo').attr("style","color:red");
                                contador = 1;
                            } else {
                                contador = 0;
                            }
                            if (contador == 0) {
                                $('#mensaje_organismo').html("Código válido");
                                $('#mensaje_organismo').attr("style","color:green"); //certifica que el codigo no existe en base de datos
                                $("#editarOrganismo").attr('disabled','disabled');
                                M.toast({html: 'Editado correctamente', classes: 'rounded', completeCallback: function() {
                                    $('#formEditarOrganismo').submit();
                                }});
                            }
                        }
                    })
            } else {
                $('#mensaje_organismo').html("");
                 // eligiendo su propio codigo
                 $("#editarOrganismo").attr('disabled','disabled');
                M.toast({html: 'Editado correctamente', classes: 'rounded', completeCallback: function() {
                    $('#formEditarOrganismo').submit();
                }});
            }
        }
        else{
            $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        }
  } );



  // ############################################ TIPO DE EGRESO
  $("#editarTipoEgreso").on( "click", function() {

    // validacion de campos
    var nombre = $('#nombre').val();

    if (nombre != "") {
        $("#editarTipoEgreso").attr('disabled','disabled');
        M.toast({html: 'Editado correctamente', classes: 'rounded', completeCallback: function() {
            $('#formEditarTipoEgreso').submit();
        }});
    }
    else{
        $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
    }

});

// REGISTRAR TIPO DE EGRESO

$("#registrarTipoEgreso").on( "click", function() {

    // validacion de campos
    var nombre = $('#nombre').val();

        if (nombre != "") {

            M.toast({html: 'Registrado correctamente', classes: 'rounded', completeCallback: function() {
                $('#formRegistroTipoEgreso').submit();
            }});
        }
        else{
            $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        }
    });





  // ###### LO NUEVO DE CONSULTA - DETENIDO - EDITAR CAMPOS

$("#editarDetenido").on( "click", function() {

    // VALIDACION DE CAMPOS
    primer_nombre = $('#primer_nombre').val();
    primer_apellido = $('#primer_apellido').val();
    fecha_nacimiento = $('#fecha_nacimiento').val();
    estado = $("#estado").find(':selected').val();
    municipio = $("#municipio").find(':selected').val();
    direccion = $('#direccion').val();
    sexo = $('#sexo').find(":selected").val();

    // en el caso que el usuario desea cambiar la foto actual
    if ($('#foto_nueva').val()) {
        foto_nueva = $(this).val();
    }

    if (primer_nombre != "" && primer_apellido != "" && fecha_nacimiento != "" && sexo > 0 && estado != "" && municipio != "" && direccion != "") {
        isValid = true;
        $('#editarDetenido').attr('disabled','disabled');
        $('#atrasDetenido').attr('disabled','disabled');

        M.toast({html: 'Editado exitosamente', classes: 'rounded', completeCallback: function() {
            $('#formEditarDetenido').submit();
        }});
    }
    else{
        $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        $('#mensaje_campos').attr('class','helper-text');
    }
});


// ######### EGRESO EGRESOS

    // Manejo del clic en el botón
    $('#btnEnviarEgreso').click(function() {

        var fecha_egreso = $('#fecha_egreso').val();;
        var descripcion_egreso = $('#descripcion_egreso').val();
        var tipo_egreso = $('#tipo_egreso').find(":selected").val();
        var detencion_detenido = $('#detencion_detenido').find(":selected").val();

        if (fecha_egreso != "" && descripcion_egreso != "" && tipo_egreso > 0 && detencion_detenido > 0)  {
                $('#btnEnviarEgreso').attr('disabled','disabled');
            M.toast({html: 'Registrado exitosamente.', classes: 'rounded', completeCallback: function() {
                $('#form_registrar_egreso').submit();
           }});
        }
        else{
            $('#mensaje_campos_egreso').text("Debe completar todos los campos requeridos *");
            
        }
    });



    // ######## ELIMINAR DETENIDOS
    $('#btnEliminarDetenido').click(function() {
        var detenido_id = $('#detenido_id').val();

        $('#btnEliminarDetenido').attr('disabled','disabled');
        $('#irAtrasDetenido').attr('disabled','disabled');

        $.ajax({
            url: 'detenido_eliminado.php',
            method: 'POST',
            data: { detenido_id: detenido_id },
            success: function (data) {
                if (data == 'exito'){
                    M.toast({html: 'Eliminado correctamente', classes: 'rounded', completeCallback: function() {
                        window.location.href = 'consulta.php';
                    }});
                } else{
                    M.toast({html: 'Ocurrió un problema al Eliminar', classes: 'rounded', completeCallback: function() {
                        window.location.href = 'consulta.php';
                    }});
                }
            }
        });
    });

    // eliminado de detenciones
    
    $('#btnEliminarDetenciones').click(function() {
        var detencion_id = $('#detencion_id').val();
        $.ajax({
            url: 'detencion_eliminado.php',
            method: 'POST',
            data: { detencion_id: detencion_id },
            success: function (data) {
                if (data == 'exito'){
                    $('#btnEliminarDetenciones').attr('disabled','disabled');
                    $('#irAtrasDetenciones').attr('disabled','disabled');

                    M.toast({html: 'Eliminado correctamente', classes: 'rounded', completeCallback: function() {
                        window.location.href = 'lista_detenciones.php';
                    }});
                } 
            }
        });
    });


        // eliminado de egresos
        $('#btnEliminarEgreso').click(function() {
            var detencion_id = $('#detencion_id').val();
            $.ajax({
                url: 'detencion_eliminado.php',
                method: 'POST',
                data: { detencion_id: detencion_id },
                success: function (data) {
                    if (data == 'exito'){
                        $('#btnEliminarEgreso').attr('disabled','disabled');
                        window.location.href = 'lista_egresos.php?msj=1';
                    } else{
                        window.location.href = 'lista_egresos.php?msj=2';
                    }
                } 
            }) 
        });



      // ###### LO NUEVO DE CONSULTA - DETENCIONES - EDITAR CAMPOS

$("#editarDetencion").on( "click", function() {

    // VALIDACION DE CAMPOS
    var organismo = $("#organismo").find(':selected').val();
    var delito = $("#delito").find(':selected').val();
    var detenido = $("#detenido").find(':selected').val();
    var f_ingreso = $('#f_ingreso').val();
    var lugar_detencion = $('#lugar_detencion').val();
    var descripcion_detencion = $('#descripcion_detencion').val();
    var direccion_detencion = $('#direccion_detencion').val();
    var estado_detencion = $('#estado').find(":selected").val();
    var municipio_detencion = $('#municipio').find(":selected").val();

    if (organismo > 0 && delito > 0 && detenido > 0 && f_ingreso != "" && lugar_detencion != "" && descripcion_detencion != "" && direccion_detencion != "" && estado_detencion != "" && municipio_detencion != "") {
        
        $('#editarDetencion').attr('disabled','disabled');
        $('#atrasDetencion').attr('disabled','disabled');

        M.toast({html: 'Editado exitosamente', classes: 'rounded', completeCallback: function() {
            $('#formEditarDetencion').submit();
       }});
        
    }
    else{
        $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        $('#mensaje_campos').attr('class','helper-text');
    }
});


// ###################################### LLAMADA A FUNCION LISTADO DE EGRESOS SEGUN DETENIDO

$("#editarEgreso").on( "click", function() {

    // VALIDACION DE CAMPOS
    var tipo_egreso = $("#tipo_egreso").find(':selected').val();
    var fecha_egreso = $('#fecha_egreso').val();
    var descripcion_egreso = $('#descripcion_egreso').val();
    var detencion = $('#detencion').find(":selected").val();

    if (tipo_egreso > 0 && detencion > 0 && descripcion_egreso != "" && fecha_egreso != "") {
        
        $('#editarEgreso').attr('disabled','disabled');
        $('#atrasEgreso').attr('disabled','disabled');

        M.toast({html: 'Editado exitosamente', classes: 'rounded', completeCallback: function() {
            $('#formEditarEgreso').submit();
       }});
        
    }
    else{
        $('#mensaje_campos').text("Debe completar todos los campos requeridos *");
        $('#mensaje_campos').attr('class','helper-text');
    }
});




// ##################### MULTIREGISTRO DE DETENCIONES #############################################
// ################################################################################################
// ################################################################################################


  $('#borrar_bloques_btn').click(function() {
    $('#ContenedorBloques').empty(); // Remove all generated blocks
    $('#botoneraBloques').empty();
  });

  // Click event handler for "Delete Block" button
  $('#eliminar_ultimobloque_btn').click(function() {
    var blocks = $('#ContenedorBloques').children('.card-panel');

    if (blocks.length > 1) {
        blocks.last().remove(); // Remove the last block (except the first)
        
    } else if (blocks.length == 1){
        M.toast({html: 'Debe permanecer al menos un bloque de datos.'});

    } else {
        M.toast({html: 'Debe agregar al menos un bloque de datos.'});
    }
  });


  // ########################### NUEVOS BLOQUES - PANEL - ####################################
$('#nuevoBloqueCampos').click(function() { // LA CREACION DE NUEVOS BLOQUES DE DATOS (AUTOMÁTICOS)
    var bloques = $('#numero_bloques').val();

    if (bloques > 10) {
        M.toast({html: 'El número de bloques para crear es máximo 10.'});
        return;

    } else if(bloques != "" && bloques > 0){
        generarBloqueDatos(bloques); // Llamado a la función luego de la validación
    } return false;

});

// ################################### GENERACIÓN DE BLOQUES DE DATOS ####################################

function generarBloqueDatos(bloques) { // FUNCIÓN QUE CREA LOS BLOQUES A PARTIR DE ÍNDICE 
    bloques = parseInt(bloques);
    var contenedor = $('#ContenedorBloques');
    var botones = $('#botoneraBloques');
    contenedor.empty();
    botones.empty();

    // Fetch the states from the server
    $.ajax({
        url: 'estados_ven.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            for (var i = 0; i < bloques; i++) {
                var blockHtml = `
                <div class="card-panel">
                    <div class="row">
                        <p class="bold">Datos de la Detención</p>
                        <div class="input-field col s6 m3">
                            <input id="expediente_${i}" type="text" class="validate" name="expediente[]" required="true" filter="text">
                            <label for="expediente_${i}">Nro. Expediente*</label>
                            <span id="mensaje_expediente_${i}" style="display:none" class="helper-text"></span>
                        </div>
                        <div class="input-field col s6 m3">
                            <input id="f_ingreso_${i}" type="text" class="validate" name="f_ingreso[]" required="true" filter="text">
                            <label for="f_ingreso_${i}">Fecha de ingreso*</label>                                
                        </div>
                        <div class="input-field col s6 m6">
                            <input id="lugar_detencion_${i}" type="text" class="validate" name="lugar_detencion[]" required="true" filter="text">
                            <label for="lugar_detencion_${i}">Lugar de detención*</label>                              
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <select name="detenido[]" id="detenido_${i}" required="true" class="validate">
                                <option value ="0" selected disabled>Seleccione un detenido de la lista*</option>
                            </select>
                            <label for="detenido_${i}">Detenido</label>
                        </div>   
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m6">
                            <textarea id="descripcion_detencion_${i}" class="materialize-textarea validate" name="descripcion_detencion[]" required="true"></textarea>
                            <label for="descripcion_detencion_${i}">Descripción*</label>                              
                        </div>
                        <div class="input-field col s6 m3">
                            <select name="delito[]" id="delito_${i}" required="true" class="validate">
                                <option value="0" selected disabled>Delito*</option>
                            </select>
                            <label for="delito_${i}">Delito</label> 
                                                         
                        </div>
                        <div class="input-field col s6 m3">
                            <select name="organismo[]" id="organismo_${i}" required="true" class="validate">
                                <option value="0" selected disabled>Organismos*</option>
                            </select>
                            <label for="organismo_${i}">Organismos</label>                       
                        </div>
                    </div>
                    <div class="row">
                        <p class="bold">Dirección de la Detención</p>
                        <div class="input-field col s6 m3">
                            <select id="estado_${i}" class="validate estado_seleccionado" name="estado[]" required="true">
                                ${muestraEstadosGenerados(data)} 
                            </select>
                            <label for="estado_${i}">Estado</label> 
                        </div>
                        <div class="input-field col s6 m3">
                            <select id="municipio_${i}" class="validate" name="municipio[]" required="true">
                                <option value="0" disabled selected>Municipio*</option>
                            </select>  
                            <label for="municipio_${i}">Municipio</label> 
                        </div>
                        <div class="input-field col s6 m6">
                            <textarea id="direccion_detencion_${i}" name="direccion_detencion[]" class="materialize-textarea validate" required="true"></textarea>
                            <label for="direccion_detencion">Dirección*</label>
                        </div>
                    </div>
                </div>`;

                contenedor.append(blockHtml); // VARIABLE QUE CONTIENE EL/ LOS BLOQUE/S (LUEGO LOS AÑADE AL CONTENEDOR)

                //  #######################################################################################

                generacionDelitos(i); // delitos (llenar el combo)
                generacionOrganismos(i); // organismos  (llenar el combo)
                generacionDetenidos(i); // delitos (llenar el combo)
                validaExpediente(i); //expediente existente?

                // #######################################################################################

                //  IMPLEMENTAMOS DATEPICKER INDEPENDIENTE EN FECHA_INGRESO, FECHA_NACIMIENTO DEBIDO A LA ITERACIÓN
                let currentDate = new Date();
                let currentYear = currentDate.getFullYear();

                $('#f_ingreso_'+(i)).datepicker({
                    format: 'dd/mm/yyyy',
                    maxDate: new Date(),
                    defaultDate: new Date(),
                    i18n: {
                        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                        weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                        weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                        weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                        selectMonths: true,
                        selectYears: true, 
                    yearRange: [2000, currentYear] // Establece el rango de años desde 1980 hasta el año actual
                });

                // #######################################################################################
                
            } // fin del FOR

//          #######################################################################################

            var bloqueBotonera = `
                <div class="col s12 m10 offset-m4"><button type="button" class="btn green center" id="submit_button" onclick="botonRegistroDetenciones()">Registrar Detenciones</button></div>
                <div id="mensaje_error"></div>`;
            botones.append(bloqueBotonera);

//          #######################################################################################

            // Initialize the select elements
            $('select').formSelect();
            $('.datepicker').datepicker();
            
            // ################################ ESTADOS SELECCIONADOS (DETENIDO Y DETENCION) ######################################

            // DETENCIONES
            $('.estado_seleccionado').change(function() { // PERMITE TOMAR EL ID Y EL INDEX COMO PARAMETRO PARA TRAER MUNICIPIOS
                var id = $(this).attr('id').split('_')[1];
                var index = id;
                var estado_id = $(this).val();
                traerMunicipios(estado_id, index); //pase de parametros
            });
        }   
    })
}

// ##################################### VALIDACION DE VALOR AGREGADO A CAMPO EXPEDIENTE ###########################################

var cont = 0;
function validaExpediente(index) {
    $(`#expediente_${index}`).blur(function() {
        
        var expediente = $("#expediente_"+index).val();
        if (expediente > 0 || expediente != "") {

            $.ajax({
            data: {'expediente':expediente},
            url:'../php/validar_existencia_expediente.php',
            type: 'post',
                success: function (info) { 
                    if (info == 1) { // valida la respuesta del servidor
                        $('#mensaje_expediente_'+index).html("Expediente registrado, ingrese otro.");
                        $('#mensaje_expediente_'+index).css("color","red");
                        $('#mensaje_expediente_'+index).fadeIn(500);
                        cont = 1;
                        
                    } else{ // significa que el número de expediente el valido
                        $('#mensaje_expediente_'+index).fadeIn(500);
                        $('#mensaje_expediente_'+index).html("Expediente válido, puede continuar.");
                        $('#mensaje_expediente_'+index).css("color","green");
                        $('#mensaje_expediente_'+index).fadeOut(4000);
                        cont = 0;
                    }
                }
            })

        } else {
            $('#mensaje_expediente_'+index).html("Ingrese un número de Expediente.");
            $('#mensaje_expediente_'+index).css("color","red");
            $('#mensaje_expediente_'+index).fadeIn(500);
            
        } return false;

    });

}

// ##################################### ESTADOS GENERADOS DINÁMICAMENTE #####################################

function muestraEstadosGenerados(estados) { //FUNCION QUE MUESTRA LOS ESTADOS EN EL CAMPO CORRESPONDIENTE
    var opciones = '<option value="0" disabled selected>Estado*</option>';
    estados.forEach(function(estado) {
       
        opciones += `<option value="${estado.id}">${estado.nombre}</option>`;
    });
    return opciones;
}

// ####################################### MUNICIPIOS GENERADOS DINÁMICAMENTE ###########################

function traerMunicipios(estado_id, index) { // TRAER LOS MUNICIPIOS Y LOS AÑADED AL CAMPO CORRESPONDIENTE A PARTIR DEL ESTADO_ID Y DEL INDEX
    $.ajax({
        url: 'fetch_municipios.php',
        method: 'GET',
        data: { estado_id: estado_id },
        dataType: 'json',
            success: function(data) {

                var municipioSeleccionado = $(`#municipio_${index}`);
                municipioSeleccionado.empty();
                municipioSeleccionado.append('<option value="0" disabled selected>Municipio*</option>');

                data.forEach(function(municipio) {
                    municipioSeleccionado.append(`<option value="${municipio.id}">${municipio.nombre}</option>`);
                });
                municipioSeleccionado.formSelect();
            },
        error: function(xhr, status, error) {
            console.error('Error trayendo los municipios:', error);
        }
    });
}

// ######################################### DETENIDOS GENERADOS DINÁMICAMENTE ##################################

function generacionDetenidos(index) { //FUNCION QUE MUESTRA LOS DETENIDOS EN EL CAMPO CORRESPONDIENTE
    $.ajax({
        url: 'traer_detenidos.php',
        method: 'GET',
        dataType: 'json',
        success: function(detenidos) {

            var detenidoSeleccionado = $(`#detenido_${index}`);
            detenidoSeleccionado.empty();
            detenidoSeleccionado.append('<option value="0" disabled selected>Seleccione un detenido de la lista*</option>');
            detenidos.forEach(function(detenido) {
                detenidoSeleccionado.append(`<option value="${detenido.id}">${detenido.nombre} ${detenido.apellido} | ${detenido.nacionalidad} ${detenido.cedula}</option>`);
            });
            detenidoSeleccionado.formSelect();
        },
        error: function(xhr, status, error) {
            console.error('Error trayendo los detenidos:', error);
        }
    });
}

// ######################################### DETENIDOS GENERADOS DINÁMICAMENTE ##################################

function generacionDelitos(index) { //FUNCION QUE MUESTRA LOS DELITOS EN EL CAMPO CORRESPONDIENTE
    $.ajax({
        url: 'traer_delitos.php',
        method: 'GET',
        dataType: 'json',
        success: function(delitos) {

            var delitoSeleccionado = $(`#delito_${index}`);
            delitoSeleccionado.empty();
            delitoSeleccionado.append('<option value="0" disabled selected>Delito*</option>');
            delitos.forEach(function(delito) {
                delitoSeleccionado.append(`<option value="${delito.id}">${delito.nombre}</option>`);
            });
            delitoSeleccionado.formSelect();
        },
        error: function(xhr, status, error) {
            console.error('Error trayendo los delitos:', error);
        }
    });
}
// ###################################### ORGANISMOS GENERADOS DINÁMICAMENTE ########################################

function generacionOrganismos(index) { //FUNCION QUE MUESTRA LOS ORGANISMOS EN EL CAMPO CORRESPONDIENTE
    $.ajax({
        url: 'traer_organismos.php',
        method: 'GET',
        dataType: 'json',
        success: function(organismos) {

            var organismoSeleccionado = $(`#organismo_${index}`);
            organismoSeleccionado.empty();
            organismoSeleccionado.append('<option value="0" disabled selected>Organismo*</option>');
            organismos.forEach(function(organismo) {
                organismoSeleccionado.append(`<option value="${organismo.id}">${organismo.nombre}</option>`);
            });
            organismoSeleccionado.formSelect();
        },
        error: function(xhr, status, error) {
            console.error('Error trayendo los organismos:', error);
        }
    });
}

// ############################### SE ENVIA EL FORMULARIO LUEGO DE LA VALIDACION ###################

function botonRegistroDetenciones() {
    var formulario = $('#formularioDinamicoDetenciones');

    // Remove any existing submit event handler to prevent duplicate handlers
    formulario.off('submit');

    // Attach a new submit event handler
    formulario.on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        if (validacionFormulario()) {
            $('#mensaje_error').hide(500);
            // Manually trigger the form submission after validation
            this.submit();
        } else {
            $('#mensaje_error').empty().append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">Debe completar todos los campos requeridos</span>');
        }
    });

    // Trigger the submit event programmatically (this will call the above handler)
    formulario.submit();
}

// ###############################SE VALIDAN LOS DATOS DEL FORMULARIO PREVIO AL SUBMIT ######################
function validacionFormulario() {
    var isValid = true;

    $('#ContenedorBloques .card-panel').each(function() {
        $(this).find('input, select, textarea').each(function() {
            // Skip validation for the optional fields
            var id = $(this).attr('id');
            if (!$(this).val() || $(this).val() === '0' || cont === 1) { // valida los campos del formulario
                $(this).addClass('invalid');
                isValid = false;
            } else {
                $(this).removeClass('invalid');
            }
        });
    });

    return isValid;
}

// ################################################################################################
// ##################################### F I N A L REGISTRO DETENCIONES ###########################
// ###############################################################################################################################################





// ##################### MULTIREGISTRO DE DETENIDOS ###############################################
// ################################################################################################
// ################################################################################################

$('#borrar_bloquesDetenido_btn').click(function() {
    $('#ContenedorBloquesDetenidos').empty(); // Remove all generated blocks
    $('#botoneraBloquesDetenidos').empty();
  });
  
  // Click event handler for "Delete Block" button

  $('#eliminar_ultimobloqueDetenido_btn').click(function() {
    var blocks = $('#ContenedorBloquesDetenidos').children('.card-panel');

    if (blocks.length > 1) {
        blocks.last().remove(); // Remove the last block (except the first)
        
    } else if (blocks.length == 1){
        M.toast({html: 'Debe permanecer al menos un bloque de datos.'});

    } else {
        M.toast({html: 'Debe agregar al menos un bloque de datos.'});
    }
  });

  // ########################### NUEVOS BLOQUES DETENIDO - PANEL - ####################################
  $('#nuevoBloqueCamposDetenido').click(function() { // LA CREACION DE NUEVOS BLOQUES DE DATOS (AUTOMÁTICOS)
    var bloques = $('#numero_bloques_detenidos').val();

    if (bloques > 10) {
        M.toast({html: 'El número de bloques para crear es máximo 10.'});
        return;

    } else if(bloques != "" && bloques > 0){
        generarBloqueDatosDetenidos(bloques); // Llamado a la función luego de la validación
    } return false;

});

  // ########################### GENERAR NUEVOS BLOQUES DE DATOS PARA DETENIDOS - #############################

function generarBloqueDatosDetenidos(bloques) { // FUNCIÓN QUE CREA LOS BLOQUES A PARTIR DE ÍNDICE 
    bloques = parseInt(bloques);
    var contenedor = $('#ContenedorBloquesDetenidos');
    var botones = $('#botoneraBloquesDetenidos');
    contenedor.empty();
    botones.empty();

    // Fetch the states from the server
    $.ajax({
        url: 'estados_ven.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            for (var i = 0; i < bloques; i++) {
                var blockHtml = `
                <div class="card-panel">
                    <div class="row">
                        <p class="bold">Datos del Detenido</p>
                        <div class="input-field col s6 m3">
                            <select id="nacionalidad_${i}" class="validate" name="nacionalidad[]" required="true">
                                <option value="0" disabled selected>Seleccione*</option>
                                <option value="1">V</option>
                                <option value="2">E</option>
                            </select>
                            <label for="nacionalidad_${i}">Nacionalidad</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <input id="cedula_${i}" name="cedula[]" type="number" required="true" class="validate" filter="number">
                            <label for="cedula_${i}">C.I.*</label>
                            <span id="mensaje_cedula_${i}" style="display:none" class="helper-text"></span>
                        </div>
                        <div class="input-field col s6 m3">
                            <input id="p_nombre_${i}" name="p_nombre[]" type="text" required="true" class="validate" filter="text">
                            <label for="p_nombre_${i}">Primer nombre*</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <input  id="s_nombre_${i}" name="s_nombre[]" type="text" class="validate" class="validate" filter="text">
                            <label for="s_nombre_${i}">Segundo nombre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m3">
                            <input id="p_apellido_${i}" name="p_apellido[]" type="text" class="validate" required="true" class="validate" filter="text">
                            <label for="p_apellido_${i}">Primer apellido*</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <input id="s_apellido_${i}" name="s_apellido[]" type="text" class="validate" class="validate" filter="text">
                            <label for="s_apellido_${i}">Segundo apellido</label>
                        </div>
                        <div class="input-field col s6 m4">
                            <input id="fecha_nacimiento_${i}" type="text" name="fecha_nacimiento[]" class="validate" required="true" onchange="agregarCalculoEdad(${i})">
                            <label for="fecha_nacimiento_${i}">Fecha de nacimiento*</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <input id="edad_calculada_${i}" type="text" name="edad_calculada[]" disabled="disabled" placeholder="Edad">
                            <input id="edad_${i}" type="hidden" name="edad[]">
                        </div>
                    </div>
                    <div class="row">
                        <p class="bold">Dirección del Detenido</p>
                        <div class="input-field col s6 m3">
                            <select id="estado_detenido_${i}" class="validate estado_detenido_seleccionado" name="estado_detenido[]" required="true">
                                ${traerEstadosDetenido(data)}
                            </select>
                            <label for="estado_detenido_${i}">Estado</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <select id="municipio_detenido_${i}" class="validate" name="municipio_detenido[]" required="true">
                            <option value="0" disabled selected>Municipio*</option>
                            </select>
                            <label for="municipio_detenido_${i}">Municipio</label>
                        </div>
                        <div class="input-field col s6 m6">
                            <textarea id="direccion_detenido_${i}" name="direccion_detenido[]" class="materialize-textarea validate" required="true"></textarea>
                            <label for="direccion">Dirección*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m3">
                            <select id="sexo_${i}" class="validate" name="sexo[]" required="true">
                                <option value="0" disabled selected>Seleccione*</option>
                                <option value="1">M</option>
                                <option value="2">F</option>
                            </select>
                            <label for="sexo_${i}">Sexo</label>
                        </div>
                        <div class="file-field input-field col s6 m9">
                            <div class="btn btn-small red">
                                <span>Cargar foto</span>
                                <input type="file" class="validate" required="true" name="foto[]" id="foto_${i}" accept="image/*">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" id="campo_foto_${i}" type="text" placeholder="Tipo: PNG, JPG, JPEG. Hasta 500kb">
                                <div id="errores"></div>
                            </div>
                        </div>
                    </div>
                </div><br>`;

                contenedor.append(blockHtml); // VARIABLE QUE CONTIENE EL/ LOS BLOQUE/S (LUEGO LOS AÑADE AL CONTENEDOR)

                //  ########################### LLAMADOS A FUNCIONES ###################################

                validaCedula(i); //cedula existente?

                // ############################# FECHA DE NACIMIENTO ###################################

                //  IMPLEMENTAMOS DATEPICKER INDEPENDIENTE EN FECHA_NACIMIENTO DEBIDO A LA ITERACIÓN
                let currentDate = new Date();
                let currentYear = currentDate.getFullYear();

                $('#fecha_nacimiento_'+(i)).datepicker({
                    format: 'dd/mm/yyyy',
                    maxDate: new Date(currentYear-18,12,31),
                    defaultDate: new Date(currentYear-18,1,31),
                    i18n: {
                        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                        weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                        weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                        weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"] },
                        selectMonths: true,
                        selectYears: true, 
                    yearRange: [1930, currentYear-18] // Establece el rango de años desde 1930 hasta el año actual
                });

                // #######################################################################################
                
            } // fin del FOR

//          #######################################################################################

            var bloqueBotoneraDetenido = `
                <div class="col s12 m10 offset-m4"><button type="button" class="btn green" id="submit_button_detenido" onclick="botonRegistroDetenidos()">Registrar Detenidos</button></div>
                <div id="mensaje_error"></div>`;
            botones.append(bloqueBotoneraDetenido);

//          #######################################################################################

            // Initialize the select elements
            $('select').formSelect();
            $('.datepicker').datepicker();

            // ################################ ESTADOS SELECCIONADOS (DETENIDO) ######################################

            $('.estado_detenido_seleccionado').change(function() { // PERMITE TOMAR EL ID Y EL INDEX COMO PARAMETRO PARA TRAER MUNICIPIOS
                var id = $(this).attr('id').split('_')[2];
                var index = id;
                var estado_detenido_id = $(this).val();
                traerMunicipiosDetenido(estado_detenido_id, index); //pase de parametros
            });
            // #######################################################################################
        }
        
    })
}

function traerEstadosDetenido(estados) { //FUNCION QUE MUESTRA LOS ESTADOS EN EL CAMPO CORRESPONDIENTE
    var opciones = '<option value="0" disabled selected>Estado*</option>';
    estados.forEach(function(estado) {
       
        opciones += `<option value="${estado.id}">${estado.nombre}</option>`;
    });
    return opciones;
}

// ####################################### MUNICIPIOS GENERADOS DINÁMICAMENTE ###########################

function traerMunicipiosDetenido(estado_id, index) { // TRAER LOS MUNICIPIOS Y LOS AÑADED AL CAMPO CORRESPONDIENTE A PARTIR DEL ESTADO_ID Y DEL INDEX
    $.ajax({
        url: 'fetch_municipios.php',
        method: 'GET',
        data: { estado_id: estado_id },
        dataType: 'json',
            success: function(data) {

                var municipioSeleccionado = $(`#municipio_detenido_${index}`);
                municipioSeleccionado.empty();
                municipioSeleccionado.append('<option value="0" disabled selected>Municipio*</option>');

                data.forEach(function(municipio) {
                    municipioSeleccionado.append(`<option value="${municipio.id}">${municipio.nombre}</option>`);
                });
                municipioSeleccionado.formSelect();
            },
        error: function(xhr, status, error) {
            console.error('Error trayendo los municipios:', error);
        }
    });
}

// ##################################### VALIDACION DE VALOR AGREGADO A CAMPO CEDULA #############################
function validaCedula(index) {
    $(`#cedula_${index}`).blur(function() {
        
        var cedula = $("#cedula_"+index).val();
        if (cedula > 0 && cedula != "") {

            $.ajax({
            data: {'cedula':cedula},
            url:'../php/validar_existencia_cedula.php',
            type: 'post',
                success: function (info) {
                    if (info === "exito") { // valida la respuesta del servidor
                        $('#mensaje_cedula_'+index).html("Cédula registrada, ingrese otra.");
                        $('#mensaje_cedula_'+index).css("color","red");
                        $('#mensaje_cedula_'+index).fadeIn(500);
                    } else {
                        $('#mensaje_cedula_'+index).fadeIn(500); // significa que el número de cedula el valido
                        $('#mensaje_cedula_'+index).html("Cédula válida, puede continuar.");
                        $('#mensaje_cedula_'+index).css("color","green");
                        $('#mensaje_cedula_'+index).fadeOut(7000);
                    }
                }
            })

        } else {
            $('#mensaje_cedula_'+index).html("Ingrese un número de Cédula.");
            $('#mensaje_cedula_'+index).css("color","red");
            $('#mensaje_cedula_'+index).fadeIn(500);
            
        } return false;

    });

}

// ################################### FUNCION PARA CALCULAR LA EDAD  ############################################

function parseDate(input) {
    var parts = input.split('/');
    // Note: months are 0-based, so subtract 1
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function calcularEdad(dob) {

    var birthDate = parseDate(dob);
    if (isNaN(birthDate)) {
        return NaN; // or handle invalid date as needed
    }
    var today = new Date();
    var age = today.getFullYear() - birthDate.getFullYear();
    var monthDifference = today.getMonth() - birthDate.getMonth();

    // Adjust if birth month and day haven't occurred yet this year
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}

// ###################################### AÑADIR EL CALCULO DE LA EDAD ############################################

function agregarCalculoEdad(index){
    var dobInput = $(`#fecha_nacimiento_${index}`);
    var dob = dobInput.val();

    var ageField = $(`#edad_calculada_${index}`);
    var ageHiddenField = $(`#edad_${index}`); // campo oculto para llevar EDAD a PHP.

    if (dob) {
        var age = calcularEdad(dob);
        ageField.val(age);
        ageHiddenField.val(age);
    }
}

// ############################### SE ENVIA EL FORMULARIO LUEGO DE LA VALIDACION ###################

function botonRegistroDetenidos() {
    var formulario = $('#formularioDinamicoDetenidos');

    // Remove any existing submit event handler to prevent duplicate handlers
    formulario.off('submit');

    // Attach a new submit event handler
    formulario.on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        if (validacionFormularioDetenidos()) {
            $('#mensaje_error').hide(500);
            // Manually trigger the form submission after validation
            this.submit();
        } else {
            $('#mensaje_error').empty().append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">Debe completar todos los campos requeridos</span>');
        }
    });

    // Trigger the submit event programmatically (this will call the above handler)
    formulario.submit();
}

// ##################### SE VALIDAN LOS DATOS DEL FORMULARIO PREVIO AL SUBMIT ######################

function validacionFormularioDetenidos() {
    var isValid = true;
    var alertaPesoTipo = 0;

    $('#ContenedorBloquesDetenidos .card-panel').each(function() {
        $(this).find('input, select, textarea').each(function() {
            // Skip validation for the optional fields
            var id = $(this).attr('id');

            // Exclusión de campos no requeridos
            if (id && (id.startsWith('s_nombre_') || 
                       id.startsWith('s_apellido_') || 
                       id.startsWith('edad_calculada_') || 
                       id.startsWith('foto_') || 
                       id.startsWith('campo_foto_'))) {
                return; // Continue to the next iteration
            }

            if (!$(this).val() || $(this).val() === '0') { // Valida los campos del formulario
                $(this).addClass('invalid');
                isValid = false;
            } else {
                $(this).removeClass('invalid');
            }
        });

        // Validate file inputs within this .card-panel
        $(this).find('input[type="file"]').each(function() {
            var fileInput = $(this);
            var file = fileInput[0].files[0];
            var errorContainer = $('#errores');

            errorContainer.html(""); // Clear previous error messages

            if (file) {
                // Validate file size
                if (file.size > 512000) { // 500 KB
                    fileInput.val('');
                    errorContainer.append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">El archivo supera el límite de peso permitido.</span><br>');
                    alertaPesoTipo = 1;
                } else {
                    // Validate file format
                    var format = file.name.split('.').pop().toLowerCase();
                    if (format !== 'jpg' && format !== 'png' && format !== 'jpeg') {
                        fileInput.val('');
                        errorContainer.append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">Formato ' + format.toUpperCase() + ' no soportado.</span><br>');
                        alertaPesoTipo = 2;
                    } else {
                        errorContainer.append('<span style="color:green" class="helper-text" data-error="wrong" data-success="right">Foto válida.</span><br>');
                        alertaPesoTipo = 0;
                    }
                }
            }
        });
    });

    // Check the file validation status
    if (alertaPesoTipo !== 0) {
        isValid = false;
    }

    return isValid;
}

    // Vincular el evento de cambio de entrada de archivos para validar los archivos inmediatamente cuando se seleccionan
    $(document).on('change', 'input[type="file"]', function() {
        var fileInput = $(this);
        var file = fileInput[0].files[0];
        var errorContainer = $('#errores');

        errorContainer.html(""); // Clear previous error messages

        if (file) {
            // Validate file size
            if (file.size > 512000) { // 500 KB
                fileInput.val('');
                errorContainer.append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">El archivo supera el límite de peso permitido.</span><br>');
                alertaPesoTipo = 1;
            } else {
                // Validate file format
                var format = file.name.split('.').pop().toLowerCase();
                if (format !== 'jpg' && format !== 'png' && format !== 'jpeg') {
                    fileInput.val('');
                    errorContainer.append('<span style="color:red" class="helper-text" data-error="wrong" data-success="right">Formato ' + format.toUpperCase() + ' no soportado.</span><br>');
                    alertaPesoTipo = 2;
                } else {
                    errorContainer.append('<span style="color:green" class="helper-text" data-error="wrong" data-success="right">Foto válida.</span><br>');
                    alertaPesoTipo = 0;
                }
            }
        }
    });

    // Impedir el clic derecho en las imágenes
    $("img").css('pointer-events','none');
    $("img").bind("contextmenu", function(){
        return false;   
    });
// ################################################################################################



// ################################################################################################
// ##################################### F I N A L REGISTRO DETENIDOS #############################
// ################################################################################################

